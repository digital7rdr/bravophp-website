<?php

declare(strict_types=1);

function base_path(string $path = ''): string
{
    return BASE_PATH . ($path ? '/' . ltrim($path, '/') : '');
}

function public_path(string $path = ''): string
{
    return base_path('public' . ($path ? '/' . ltrim($path, '/') : ''));
}

function load_env(string $path): void
{
    if (!is_file($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        $value = trim($value, "\"'");

        $_ENV[$key] = $value;
        putenv($key . '=' . $value);
    }
}

function env_value(string $key, mixed $default = null): mixed
{
    $value = $_ENV[$key] ?? getenv($key);
    return $value === false || $value === null || $value === '' ? $default : $value;
}

function config(string $key, mixed $default = null): mixed
{
    static $configs = [];
    [$file, $item] = array_pad(explode('.', $key, 2), 2, null);

    if (!isset($configs[$file])) {
        $path = base_path('config/' . $file . '.php');
        $configs[$file] = is_file($path) ? require $path : [];
    }

    if ($item === null) {
        return $configs[$file] ?? $default;
    }

    return $configs[$file][$item] ?? $default;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $path = '/' . ltrim($path, '/');
    return $path === '/' ? '/' : $path;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function media_src(?string $path, string $fallback = ''): string
{
    $path = trim((string) ($path ?: $fallback));

    if ($path === '') {
        return '';
    }

    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }

    if (str_starts_with($path, '/assets/')) {
        return $path;
    }

    if (str_starts_with($path, 'uploads/') || str_starts_with($path, 'images/')) {
        return asset($path);
    }

    return asset('images/' . ltrim($path, '/'));
}

function site_setting(string $key, mixed $default = null): mixed
{
    static $settings;

    if ($settings === null) {
        try {
            $repository = new \App\Models\ContentRepository();
            $settings = $repository->settings();
        } catch (Throwable) {
            $settings = [];
        }
    }

    return $settings[$key] ?? $default;
}

function site_logo_src(): string
{
    return media_src(site_setting('logo_path', 'images/logo.svg'), 'images/logo.svg');
}

function is_active(string $path): bool
{
    $current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

    if ($path === '/') {
        return $current === '/';
    }

    return $current === $path || str_starts_with($current, rtrim($path, '/') . '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['_csrf'] ?? '';

    if (!is_string($token) || !hash_equals($_SESSION['_csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Security token mismatch. Please refresh and try again.');
    }
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function retain_old(array $input): void
{
    $_SESSION['_old'] = $input;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function icon(string $name): string
{
    $icons = [
        'shield' => '<path d="M12 3 5 6v5c0 4.2 2.8 7.9 7 9 4.2-1.1 7-4.8 7-9V6l-7-3Z"/><path d="m9.5 12 1.7 1.7 3.6-4"/>',
        'message' => '<path d="M4 6h16v10H8l-4 4V6Z"/><path d="M8 10h8M8 13h5"/>',
        'users' => '<path d="M16 18c0-2.2-1.8-4-4-4s-4 1.8-4 4"/><circle cx="12" cy="8" r="3"/><path d="M20 18c0-1.7-1-3.1-2.5-3.7"/><path d="M16.5 5.3a3 3 0 0 1 0 5.4"/>',
        'target' => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/><path d="M12 2v4M12 18v4M2 12h4M18 12h4"/>',
        'car' => '<path d="m5 12 2-5h10l2 5"/><path d="M5 12h14v6H5z"/><circle cx="8" cy="18" r="1.5"/><circle cx="16" cy="18" r="1.5"/>',
        'clock' => '<circle cx="12" cy="12" r="8"/><path d="M12 7v5l3 2"/>',
        'lock' => '<rect x="6" y="10" width="12" height="9" rx="2"/><path d="M8 10V8a4 4 0 0 1 8 0v2"/>',
        'bell' => '<path d="M18 14v-3a6 6 0 1 0-12 0v3l-2 3h16l-2-3Z"/><path d="M10 20h4"/>',
        'layers' => '<path d="m12 4 8 4-8 4-8-4 8-4Z"/><path d="m4 12 8 4 8-4"/><path d="m4 16 8 4 8-4"/>',
        'chart' => '<path d="M4 19h16"/><path d="M7 16V9M12 16V5M17 16v-3"/><path d="m5 10 5-5 4 4 5-6"/>',
        'headset' => '<path d="M4 13a8 8 0 0 1 16 0"/><path d="M4 13v3a2 2 0 0 0 2 2h2v-7H6a2 2 0 0 0-2 2ZM20 13v3a2 2 0 0 1-2 2h-2v-7h2a2 2 0 0 1 2 2Z"/><path d="M14 20h2a4 4 0 0 0 4-4"/>',
        'building' => '<path d="M4 20h16"/><path d="M6 20V8h7v12"/><path d="M13 20V4h5v16"/><path d="M8 11h2M8 15h2M15 8h1M15 12h1M15 16h1"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
        'phone' => '<path d="M7 4h3l1.5 4-2 1.2a10 10 0 0 0 5.3 5.3l1.2-2 4 1.5v3a2 2 0 0 1-2.2 2A16 16 0 0 1 5 6.2 2 2 0 0 1 7 4Z"/>',
        'briefcase' => '<rect x="4" y="7" width="16" height="12" rx="2"/><path d="M9 7V5h6v2M4 12h16"/>',
        'globe' => '<circle cx="12" cy="12" r="8"/><path d="M4 12h16M12 4a12 12 0 0 1 0 16M12 4a12 12 0 0 0 0 16"/>',
        'check' => '<circle cx="12" cy="12" r="8"/><path d="m8.5 12.5 2.2 2.2 4.8-5.4"/>',
        'arrow' => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'star' => '<path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.8 1-6.1-4.4-4.3 6.1-.9L12 3Z"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m16 16 4 4"/>',
        'list' => '<path d="M8 6h12M8 12h12M8 18h12"/><circle cx="4" cy="6" r="1"/><circle cx="4" cy="12" r="1"/><circle cx="4" cy="18" r="1"/>',
        'home' => '<path d="M4 11l8-7 8 7M6 10v9h12v-9M10 19v-5h4v5"/>',
        'calendar' => '<rect x="4" y="5" width="16" height="16" rx="2"/><path d="M4 9h16M8 3v4M16 3v4"/>',
    ];

    $paths = $icons[$name] ?? $icons['shield'];
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $paths . '</svg>';
}
