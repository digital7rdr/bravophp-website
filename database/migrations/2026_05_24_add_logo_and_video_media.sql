SET @column_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'pages'
      AND COLUMN_NAME = 'hero_media_type'
);

SET @statement := IF(
    @column_exists = 0,
    'ALTER TABLE pages ADD COLUMN hero_media_type VARCHAR(20) NOT NULL DEFAULT ''image'' AFTER hero_image',
    'SELECT 1'
);

PREPARE add_hero_media_type FROM @statement;
EXECUTE add_hero_media_type;
DEALLOCATE PREPARE add_hero_media_type;

INSERT INTO settings (setting_key, setting_value, created_at, updated_at) VALUES
('logo_path', 'images/logo.svg', NOW(), NOW()),
('logo_text', 'Bravo Secure', NOW(), NOW())
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW();
