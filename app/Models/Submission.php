<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Submission
{
    /** @param array<string,mixed> $data */
    public static function create(array $data): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO submissions (reference, secure_code, type, status, name, email, payload, created_at)
             VALUES (:reference, :secure_code, :type, :status, :name, :email, :payload, NOW())'
        );
        $stmt->execute([
            'reference' => $data['reference'],
            'secure_code' => $data['secure_code'],
            'type' => $data['type'],
            'status' => $data['status'] ?? 'new',
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'payload' => json_encode($data['payload'] ?? [], JSON_UNESCAPED_UNICODE),
        ]);
    }

    /** @return array<string,mixed>|null */
    public static function findByReference(string $reference): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM submissions WHERE reference = :r LIMIT 1');
        $stmt->execute(['r' => $reference]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** @return array<string,mixed>|null */
    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM submissions WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Filtered list.
     * @return array<int,array<string,mixed>>
     */
    public static function filter(string $q = '', string $status = 'all', string $type = 'all', int $limit = 200): array
    {
        $where = [];
        $params = [];
        if ($status !== 'all') { $where[] = 'status = :status'; $params['status'] = $status; }
        if ($type !== 'all') { $where[] = 'type = :type'; $params['type'] = $type; }
        if ($q !== '') {
            $where[] = '(reference LIKE :q OR name LIKE :q OR email LIKE :q)';
            $params['q'] = '%' . $q . '%';
        }
        $sql = 'SELECT * FROM submissions';
        if ($where) { $sql .= ' WHERE ' . implode(' AND ', $where); }
        $sql .= ' ORDER BY created_at DESC LIMIT ' . (int) $limit;

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll() ?: [];
    }

    public static function updateStatus(int $id, string $status): void
    {
        $stmt = Database::connection()->prepare('UPDATE submissions SET status = :s WHERE id = :id');
        $stmt->execute(['s' => $status, 'id' => $id]);
    }

    public static function total(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM submissions')->fetchColumn();
    }

    public static function countNew(): int
    {
        $stmt = Database::connection()->prepare("SELECT COUNT(*) FROM submissions WHERE status = 'new'");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
