-- Editable page content overrides (one JSON row per page).
-- Defaults live in app/Support/SiteContent.php; rows here override them.

CREATE TABLE IF NOT EXISTS content (
    content_key VARCHAR(60) NOT NULL PRIMARY KEY,
    data LONGTEXT NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
