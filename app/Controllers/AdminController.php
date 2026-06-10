<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Models\Content;
use App\Models\Setting;
use App\Models\Submission;
use App\Support\SiteContent;
use Throwable;

final class AdminController extends Controller
{
    public const TYPE_LABELS = [
        'secure-transfer' => 'Secure Transfer',
        'executive-protection' => 'Executive Protection',
        'ongoing-support' => 'Ongoing Support',
        'custom-request' => 'Custom Request',
        'contact' => 'Contact Message',
    ];

    public const STATUSES = ['new', 'reviewing', 'confirmed', 'closed'];

    public const CONTENT_DOCS = [
        'site' => 'Navigation & Footer',
        'home' => 'Home',
        'request-support' => 'Request Support',
        'secure-services' => 'Secure Services',
        'virtual-bodyguard' => 'Virtual Bodyguard',
        'bravo-comms' => 'Bravo Comms',
        'long-term-bookings' => 'Long-Term Bookings',
        'agent-network' => 'Agent Network',
        'about' => 'About',
        'contact' => 'Contact',
    ];

    /* ----------------------------- Auth ----------------------------- */

    public function setup(): void
    {
        if (!Database::available()) { $this->render('admin/db-error', [], 'admin'); return; }
        if ($this->usersExist()) { redirect('/admin/login'); }
        $this->render('admin/setup', [], 'admin');
    }

    public function createAdmin(): void
    {
        if (!Database::available()) { $this->render('admin/db-error', [], 'admin'); return; }
        verify_csrf();
        if ($this->usersExist()) { redirect('/admin/login'); }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            flash('error', 'Use a valid name, email, and a password of at least 8 characters.');
            redirect('/admin/setup');
        }

        $stmt = Database::connection()->prepare(
            'INSERT INTO users (name, email, password_hash, created_at, updated_at) VALUES (?,?,?,NOW(),NOW())'
        );
        $stmt->execute([$name, strtolower($email), password_hash($password, PASSWORD_DEFAULT)]);
        flash('success', 'Admin account created. You can sign in now.');
        redirect('/admin/login');
    }

    public function login(): void
    {
        if (!Database::available()) { $this->render('admin/db-error', [], 'admin'); return; }
        if (!$this->usersExist()) { redirect('/admin/setup'); }
        if (Auth::check()) { redirect('/admin'); }
        $this->render('admin/login', [], 'admin');
    }

    public function authenticate(): void
    {
        if (!Database::available()) { $this->render('admin/db-error', [], 'admin'); return; }
        verify_csrf();
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        if (!Auth::attempt($email, (string) ($_POST['password'] ?? ''))) {
            flash('error', 'Those credentials do not match an admin account.');
            redirect('/admin/login');
        }
        redirect('/admin');
    }

    public function logout(): void
    {
        verify_csrf();
        Auth::logout();
        redirect('/admin/login');
    }

    /* -------------------------- Submissions -------------------------- */

    public function dashboard(): void
    {
        Auth::requireLogin();
        $q = trim((string) ($_GET['q'] ?? ''));
        $status = (string) ($_GET['status'] ?? 'all');
        $type = (string) ($_GET['type'] ?? 'all');

        $rows = [];
        $total = 0;
        $newCount = 0;
        $dbError = null;
        try {
            $rows = Submission::filter($q, $status, $type);
            $total = Submission::total();
            $newCount = Submission::countNew();
        } catch (Throwable $e) {
            $dbError = $e->getMessage();
        }

        $this->render('admin/submissions', [
            'user' => Auth::user(),
            'rows' => $rows,
            'total' => $total,
            'newCount' => $newCount,
            'dbError' => $dbError,
            'q' => $q, 'status' => $status, 'type' => $type,
        ], 'admin');
    }

    public function submission(string $id): void
    {
        Auth::requireLogin();
        $row = Submission::find((int) $id);
        if (!$row) { http_response_code(404); $this->render('admin/not-found', [], 'admin'); return; }
        $this->render('admin/submission-detail', ['user' => Auth::user(), 'row' => $row], 'admin');
    }

    public function updateStatus(string $id): void
    {
        Auth::requireLogin();
        verify_csrf();
        $status = (string) ($_POST['status'] ?? 'new');
        if (in_array($status, self::STATUSES, true)) {
            Submission::updateStatus((int) $id, $status);
            flash('success', 'Status updated.');
        }
        redirect('/admin/submissions/' . (int) $id);
    }

    /* ---------------------------- Settings --------------------------- */

    public function settings(): void
    {
        Auth::requireLogin();
        $this->render('admin/settings', ['user' => Auth::user(), 'settings' => Setting::all()], 'admin');
    }

    public function updateSettings(): void
    {
        Auth::requireLogin();
        verify_csrf();

        foreach (['brand_mark', 'logo_size', 'font', 'color_accent', 'color_bg', 'color_surface', 'color_heading', 'color_body'] as $key) {
            if (isset($_POST[$key])) {
                Setting::set($key, trim((string) $_POST[$key]));
            }
        }

        foreach (['logo', 'icon'] as $field) {
            $path = $this->handleUpload($field);
            if ($path !== null) {
                Setting::set($field, $path);
            }
        }

        flash('success', 'Settings saved.');
        redirect('/admin/settings');
    }

    /* ---------------------------- Content ---------------------------- */

    public function content(): void
    {
        Auth::requireLogin();
        $this->render('admin/content', ['user' => Auth::user(), 'docs' => self::CONTENT_DOCS], 'admin');
    }

    public function editContent(string $key): void
    {
        Auth::requireLogin();
        if (!isset(self::CONTENT_DOCS[$key])) {
            http_response_code(404);
            $this->render('admin/not-found', [], 'admin');
            return;
        }
        if ($key === 'site') {
            $s = SiteContent::site();
            $doc = [
                'menu' => $s['menu'] ?? [],
                'navCtas' => $s['navCtas'] ?? [],
                'footer' => $s['footer'] ?? [],
                'contact' => $s['contact'] ?? [],
            ];
        } else {
            $doc = SiteContent::page($key) ?? [];
        }

        $this->render('admin/content-edit', [
            'user' => Auth::user(),
            'key' => $key,
            'label' => self::CONTENT_DOCS[$key],
            'doc' => $doc,
        ], 'admin');
    }

    public function saveContent(string $key): void
    {
        Auth::requireLogin();
        verify_csrf();
        if (!isset(self::CONTENT_DOCS[$key])) {
            redirect('/admin/content');
        }
        $data = is_array($_POST['c'] ?? null) ? bs_clean_content($_POST['c']) : [];
        try {
            Content::set($key, $data);
            flash('success', 'Content saved. Changes are live on the site.');
        } catch (Throwable $e) {
            flash('error', 'Could not save — ' . $e->getMessage() . ' (is the `content` table imported?)');
        }
        redirect('/admin/content/' . $key);
    }

    /** AJAX image upload from the content editor. Returns JSON {url}. */
    public function uploadImage(): void
    {
        Auth::requireLogin();
        verify_csrf();
        header('Content-Type: application/json');
        $path = $this->handleUpload('file');
        if ($path === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Upload failed — use PNG, JPG, WebP, GIF or SVG up to 6 MB.']);
            return;
        }
        echo json_encode(['url' => $path]);
    }

    /* ----------------------------- Helpers --------------------------- */

    private function usersExist(): bool
    {
        try {
            return (int) Database::connection()->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0;
        } catch (Throwable) {
            return false;
        }
    }

    private function handleUpload(string $field): ?string
    {
        if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }
        $allowed = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp', 'image/gif' => 'gif', 'image/svg+xml' => 'svg'];
        $tmp = $_FILES[$field]['tmp_name'];
        $mime = function_exists('mime_content_type') ? (string) mime_content_type($tmp) : (string) ($_FILES[$field]['type'] ?? '');
        $ext = $allowed[$mime] ?? null;
        if ($ext === null || ($_FILES[$field]['size'] ?? 0) > 6 * 1024 * 1024) {
            flash('error', 'Unsupported or oversized file for ' . $field . '.');
            return null;
        }
        $dir = public_path('assets/uploads');
        if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
        $name = $field . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
        if (!move_uploaded_file($tmp, $dir . '/' . $name)) {
            return null;
        }
        return '/assets/uploads/' . $name;
    }
}
