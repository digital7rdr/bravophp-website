<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use Throwable;

/** Key/value settings (logo, appearance colours, font). Stored in `settings`. */
final class Setting
{
    /** @var array<string,string>|null */
    private static ?array $cache = null;

    /** @return array<string,string> */
    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }
        try {
            $rows = Database::connection()->query('SELECT setting_key, setting_value FROM settings')->fetchAll();
            $out = [];
            foreach ($rows as $r) {
                $out[$r['setting_key']] = (string) ($r['setting_value'] ?? '');
            }
            return self::$cache = $out;
        } catch (Throwable) {
            return self::$cache = [];
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $all = self::all();
        $v = $all[$key] ?? null;
        return ($v === null || $v === '') ? $default : $v;
    }

    public static function set(string $key, string $value): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO settings (setting_key, setting_value, created_at, updated_at)
             VALUES (:k, :v, NOW(), NOW())
             ON DUPLICATE KEY UPDATE setting_value = :v2, updated_at = NOW()'
        );
        $stmt->execute(['k' => $key, 'v' => $value, 'v2' => $value]);
        self::$cache = null;
    }
}
