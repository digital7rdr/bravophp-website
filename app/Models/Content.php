<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use Throwable;

/** Page content overrides, stored as JSON per key. */
final class Content
{
    /** @return array<string,mixed>|null */
    public static function get(string $key): ?array
    {
        try {
            $stmt = Database::connection()->prepare('SELECT data FROM content WHERE content_key = :k LIMIT 1');
            $stmt->execute(['k' => $key]);
            $row = $stmt->fetch();
            if (!$row || $row['data'] === null || $row['data'] === '') {
                return null;
            }
            $decoded = json_decode((string) $row['data'], true);
            return is_array($decoded) ? $decoded : null;
        } catch (Throwable) {
            return null;
        }
    }

    /** @param array<string,mixed> $data */
    public static function set(string $key, array $data): void
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO content (content_key, data, updated_at) VALUES (:k, :d, NOW())
             ON DUPLICATE KEY UPDATE data = :d2, updated_at = NOW()'
        );
        $stmt->execute(['k' => $key, 'd' => $json, 'd2' => $json]);
    }
}
