<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Support\FallbackContent;
use PDO;
use PDOException;

final class ContentRepository
{
    private ?PDO $db = null;
    private bool $usingFallback = false;

    public function __construct()
    {
        try {
            $this->db = Database::connection();
        } catch (PDOException) {
            $this->usingFallback = true;
        }
    }

    public function usingFallback(): bool
    {
        return $this->usingFallback;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function navigation(): array
    {
        if ($this->usingFallback) {
            return array_values(array_filter(FallbackContent::pages(), static fn (array $page): bool => (int) $page['is_published'] === 1));
        }

        $statement = $this->db()->query('SELECT * FROM pages WHERE is_published = 1 ORDER BY sort_order, id');
        return $this->tree($this->hydratePaths($statement->fetchAll()));
    }

    /**
     * @return array<string, mixed>|null
     */
    public function page(string $slug): ?array
    {
        if ($this->usingFallback) {
            foreach (FallbackContent::pages() as $page) {
                if ($page['slug'] === $slug && (int) $page['is_published'] === 1) {
                    return $page;
                }
            }

            return null;
        }

        $statement = $this->db()->prepare('SELECT * FROM pages WHERE slug = ? AND is_published = 1 LIMIT 1');
        $statement->execute([$slug]);
        $page = $statement->fetch();

        return $page ?: null;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function pageByPath(string $path): ?array
    {
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if (!$segments) {
            return $this->page('home');
        }

        if ($this->usingFallback) {
            return $this->page(end($segments));
        }

        $parentId = null;
        $page = null;

        foreach ($segments as $segment) {
            if ($parentId === null) {
                $statement = $this->db()->prepare('SELECT * FROM pages WHERE slug = ? AND parent_id IS NULL AND is_published = 1 LIMIT 1');
                $statement->execute([$segment]);
            } else {
                $statement = $this->db()->prepare('SELECT * FROM pages WHERE slug = ? AND parent_id = ? AND is_published = 1 LIMIT 1');
                $statement->execute([$segment, $parentId]);
            }

            $page = $statement->fetch();

            if (!$page) {
                return null;
            }

            $parentId = (int) $page['id'];
        }

        return $page ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function allPages(): array
    {
        $statement = $this->db()->query('SELECT * FROM pages ORDER BY sort_order, id');
        return $this->hydratePaths($statement->fetchAll());
    }

    /**
     * @return array<string, int>
     */
    public function stats(): array
    {
        return [
            'pages' => (int) $this->db()->query('SELECT COUNT(*) FROM pages')->fetchColumn(),
            'published_pages' => (int) $this->db()->query('SELECT COUNT(*) FROM pages WHERE is_published = 1')->fetchColumn(),
            'messages' => (int) $this->db()->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn(),
            'new_messages' => (int) $this->db()->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'new'")->fetchColumn(),
            'sections' => (int) $this->db()->query('SELECT COUNT(*) FROM feature_groups')->fetchColumn(),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function adminPage(int $id): ?array
    {
        $statement = $this->db()->prepare('SELECT * FROM pages WHERE id = ? LIMIT 1');
        $statement->execute([$id]);
        $page = $statement->fetch();

        return $page ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function groupsForPage(array $page): array
    {
        if ($this->usingFallback) {
            return FallbackContent::groupsFor($page['slug']);
        }

        $groups = $this->db()->prepare('SELECT * FROM feature_groups WHERE page_id = ? ORDER BY sort_order, id');
        $groups->execute([(int) $page['id']]);
        $records = $groups->fetchAll();

        foreach ($records as &$group) {
            $items = $this->db()->prepare('SELECT * FROM feature_items WHERE group_id = ? ORDER BY sort_order, id');
            $items->execute([(int) $group['id']]);
            $group['items'] = $items->fetchAll();
        }

        return $records;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function saveContactMessage(array $data): void
    {
        if ($this->usingFallback) {
            return;
        }

        $statement = $this->db()->prepare(
            'INSERT INTO contact_messages (name, email, subject, message, status, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())'
        );
        $statement->execute([
            $data['name'],
            $data['email'],
            $data['subject'],
            $data['message'],
            'new',
            $_SERVER['REMOTE_ADDR'] ?? null,
            substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function recentMessages(int $limit = 8): array
    {
        $statement = $this->db()->prepare('SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT ?');
        $statement->bindValue(1, $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function messages(): array
    {
        $statement = $this->db()->query('SELECT * FROM contact_messages ORDER BY created_at DESC');
        return $statement->fetchAll();
    }

    public function updateMessageStatus(int $id, string $status): void
    {
        $statement = $this->db()->prepare('UPDATE contact_messages SET status = ? WHERE id = ?');
        $statement->execute([$status, $id]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updatePage(int $id, array $data): void
    {
        $fields = [
            'menu_label',
            'parent_id',
            'title',
            'meta_description',
            'eyebrow',
            'headline',
            'body',
            'hero_image',
            'hero_media_type',
            'primary_label',
            'primary_url',
            'secondary_label',
            'secondary_url',
            'cta_headline',
            'cta_body',
            'cta_label',
            'cta_url',
            'sort_order',
            'is_published',
        ];

        $assignments = implode(', ', array_map(static fn (string $field): string => $field . ' = ?', $fields));
        if (($data['parent_id'] ?? null) === $id) {
            $data['parent_id'] = null;
        }

        $values = array_map(static function (string $field) use ($data): mixed {
            if ($field === 'parent_id') {
                return empty($data[$field]) ? null : (int) $data[$field];
            }

            return $data[$field] ?? '';
        }, $fields);
        $values[] = $id;

        $statement = $this->db()->prepare('UPDATE pages SET ' . $assignments . ', updated_at = NOW() WHERE id = ?');
        $statement->execute($values);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createPage(array $data): int
    {
        $slug = $this->uniqueSlug($data['slug'] ?: $data['title']);

        $statement = $this->db()->prepare(
            'INSERT INTO pages
            (parent_id, slug, menu_label, title, meta_description, eyebrow, headline, body, hero_image, hero_media_type, primary_label, primary_url, secondary_label, secondary_url, cta_headline, cta_body, cta_label, cta_url, sort_order, is_published, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())'
        );

        $statement->execute([
            empty($data['parent_id']) ? null : (int) $data['parent_id'],
            $slug,
            $data['menu_label'] ?: $data['title'],
            $data['title'],
            $data['meta_description'] ?? '',
            $data['eyebrow'] ?? '',
            $data['headline'] ?: $data['title'],
            $data['body'] ?? '',
            $data['hero_image'] ?: 'hero-home.jpg',
            $data['hero_media_type'] ?? 'image',
            $data['primary_label'] ?? 'Contact Bravo',
            $data['primary_url'] ?? '/contact',
            $data['secondary_label'] ?? '',
            $data['secondary_url'] ?? '',
            $data['cta_headline'] ?? '',
            $data['cta_body'] ?? '',
            $data['cta_label'] ?? '',
            $data['cta_url'] ?? '',
            (int) ($data['sort_order'] ?? 100),
            !empty($data['is_published']) ? 1 : 0,
        ]);

        return (int) $this->db()->lastInsertId();
    }

    /**
     * @param array<int, array<string, mixed>> $groups
     */
    public function updateFeatureContent(array $groups): void
    {
        foreach ($groups as $groupId => $group) {
            $statement = $this->db()->prepare('UPDATE feature_groups SET title = ?, intro = ?, layout = ?, sort_order = ? WHERE id = ?');
            $statement->execute([
                $group['title'] ?? '',
                $group['intro'] ?? '',
                $group['layout'] ?? 'cards',
                (int) ($group['sort_order'] ?? 0),
                (int) $groupId,
            ]);

            foreach (($group['items'] ?? []) as $itemId => $item) {
                $itemStatement = $this->db()->prepare('UPDATE feature_items SET icon = ?, title = ?, body = ?, note = ?, sort_order = ? WHERE id = ?');
                $itemStatement->execute([
                    $item['icon'] ?? 'shield',
                    $item['title'] ?? '',
                    $item['body'] ?? '',
                    $item['note'] ?? '',
                    (int) ($item['sort_order'] ?? 0),
                    (int) $itemId,
                ]);
            }
        }
    }

    public function usersExist(): bool
    {
        $statement = $this->db()->query('SELECT COUNT(*) FROM users');
        return (int) $statement->fetchColumn() > 0;
    }

    /**
     * @return array<string, string>
     */
    public function settings(): array
    {
        $statement = $this->db()->query('SELECT setting_key, setting_value FROM settings ORDER BY setting_key');
        $settings = [];

        foreach ($statement->fetchAll() as $row) {
            $settings[$row['setting_key']] = (string) $row['setting_value'];
        }

        return array_merge([
            'site_name' => 'Bravo Secure',
            'contact_email' => 'info@bravo-secure.com',
            'secure_line' => '+1 (555) 817-7332',
            'logo_path' => 'images/logo.svg',
            'logo_text' => 'Bravo Secure',
            'admin_notice' => '',
        ], $settings);
    }

    /**
     * @param array<string, string> $settings
     */
    public function updateSettings(array $settings): void
    {
        $statement = $this->db()->prepare(
            'INSERT INTO settings (setting_key, setting_value, created_at, updated_at) VALUES (?, ?, NOW(), NOW())
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()'
        );

        foreach ($settings as $key => $value) {
            $statement->execute([$key, $value]);
        }
    }

    public function createUser(string $name, string $email, string $password): void
    {
        $statement = $this->db()->prepare('INSERT INTO users (name, email, password_hash, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())');
        $statement->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    private function db(): PDO
    {
        if (!$this->db instanceof PDO) {
            $this->db = Database::connection();
        }

        return $this->db;
    }

    /**
     * @param array<int, array<string, mixed>> $pages
     * @return array<int, array<string, mixed>>
     */
    private function hydratePaths(array $pages): array
    {
        $byId = [];

        foreach ($pages as $page) {
            $page['children'] = [];
            $byId[(int) $page['id']] = $page;
        }

        $build = function (array $page) use (&$build, &$byId): string {
            if (($page['slug'] ?? '') === 'home') {
                return '/';
            }

            if (!empty($page['parent_id']) && isset($byId[(int) $page['parent_id']])) {
                $parentPath = rtrim($build($byId[(int) $page['parent_id']]), '/');
                return $parentPath . '/' . $page['slug'];
            }

            return '/' . $page['slug'];
        };

        foreach ($pages as &$page) {
            $page['path'] = $build($page);
            $page['depth'] = substr_count(trim((string) $page['path'], '/'), '/');
            $page['parent_label'] = !empty($page['parent_id']) && isset($byId[(int) $page['parent_id']])
                ? $byId[(int) $page['parent_id']]['menu_label']
                : '';
        }

        return $pages;
    }

    /**
     * @param array<int, array<string, mixed>> $pages
     * @return array<int, array<string, mixed>>
     */
    private function tree(array $pages): array
    {
        $byId = [];

        foreach ($pages as $page) {
            $page['children'] = [];
            $byId[(int) $page['id']] = $page;
        }

        foreach ($byId as $id => &$page) {
            if (!empty($page['parent_id']) && isset($byId[(int) $page['parent_id']])) {
                $byId[(int) $page['parent_id']]['children'][] = &$page;
            }
        }
        unset($page);

        return array_values(array_filter($byId, static fn (array $page): bool => empty($page['parent_id'])));
    }

    private function uniqueSlug(string $value): string
    {
        $base = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $value), '-')) ?: 'page';
        $slug = $base;
        $counter = 2;

        while ($this->slugExists($slug)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        $statement = $this->db()->prepare('SELECT COUNT(*) FROM pages WHERE slug = ?');
        $statement->execute([$slug]);
        return (int) $statement->fetchColumn() > 0;
    }
}
