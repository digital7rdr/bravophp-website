<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Submission;
use App\Support\SiteContent;
use Throwable;

final class PageController extends Controller
{
    private const PANEL_PAGES = ['request-support', 'secure-services'];

    public function home(): void
    {
        $pg = SiteContent::page('home');
        $this->render('pages/home', [
            'pg' => $pg,
            'request' => SiteContent::request(),
            'seo' => $pg['seo'] ?? [],
        ], 'site');
    }

    /** Generic page render — slug derived from the request path. */
    public function page(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $slug = trim($path, '/');
        $slug = $slug === '' ? 'home' : $slug;

        $pg = SiteContent::page($slug);
        if ($pg === null) {
            http_response_code(404);
            $this->render('pages/404', [], 'site');
            return;
        }

        $data = ['pg' => $pg, 'seo' => $pg['seo'] ?? []];
        if (in_array($slug, self::PANEL_PAGES, true)) {
            $data['request'] = SiteContent::request();
        }
        $this->render('pages/' . $slug, $data, 'site');
    }

    public function servicesRedirect(): void
    {
        redirect('/secure-services');
    }

    /** Store a request-panel submission. */
    public function submitRequest(): void
    {
        verify_csrf();
        $type = (string) ($_POST['service_type'] ?? 'custom-request');
        $payload = $this->cleanPost(['_csrf', 'service_type']);

        [$ref, $code] = $this->store($type, $payload);
        flash('request_ref', $ref);
        flash('request_code', $code);
        redirect($this->backTo('/request-support'));
    }

    /** Store a contact message. */
    public function sendContact(): void
    {
        verify_csrf();
        $payload = $this->cleanPost(['_csrf', 'form_type']);
        $this->store('contact', $payload);
        flash('contact_ok', '1');
        redirect('/contact');
    }

    /** Look up a request by reference for the Manage page. */
    public function lookup(): void
    {
        verify_csrf();
        $mode = (string) ($_POST['mode'] ?? 'manage');
        $reference = strtoupper(trim((string) ($_POST['reference'] ?? '')));

        $found = null;
        try {
            if ($reference !== '') {
                $row = Submission::findByReference($reference);
                if ($row) {
                    if ($mode === 'manage') {
                        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
                        if ($email !== '' && strtolower((string) ($row['email'] ?? '')) === $email) {
                            $found = $row;
                        }
                    } else {
                        $secure = strtoupper(trim((string) ($_POST['secure_code'] ?? '')));
                        if ($secure !== '' && strtoupper((string) ($row['secure_code'] ?? '')) === $secure) {
                            $found = $row;
                        }
                    }
                }
            }
        } catch (Throwable) {
            $found = null;
        }

        if ($found) {
            flash('lookup_ok', '1');
            flash('lookup_msg', sprintf(
                'Request %s — status: %s (submitted %s).',
                $found['reference'],
                strtoupper((string) $found['status']),
                substr((string) $found['created_at'], 0, 10)
            ));
        } else {
            flash('lookup_msg', "We couldn't find a request with those details. Please check and try again.");
        }
        redirect('/manage');
    }

    /**
     * @param array<int,string> $omit
     * @return array<string,string>
     */
    private function cleanPost(array $omit): array
    {
        $out = [];
        foreach ($_POST as $k => $v) {
            if (in_array($k, $omit, true) || !is_string($v)) {
                continue;
            }
            $out[$k] = trim($v);
        }
        return $out;
    }

    /**
     * @param array<string,string> $payload
     * @return array{0:string,1:string}
     */
    private function store(string $type, array $payload): array
    {
        $ref = 'BS-' . $this->code(6);
        $code = $this->code(6);
        try {
            Submission::create([
                'reference' => $ref,
                'secure_code' => $code,
                'type' => $type,
                'name' => $payload['name'] ?? ($payload['fullName'] ?? null),
                'email' => $payload['email'] ?? null,
                'payload' => $payload,
            ]);
        } catch (Throwable) {
            // DB unavailable — the reference is still shown so the UX completes.
        }
        return [$ref, $code];
    }

    private function code(int $len): string
    {
        $alphabet = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
        $out = '';
        for ($i = 0; $i < $len; $i++) {
            $out .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        return $out;
    }

    private function backTo(string $fallback): string
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? '';
        $path = $ref ? (parse_url($ref, PHP_URL_PATH) ?: $fallback) : $fallback;
        return $path;
    }
}
