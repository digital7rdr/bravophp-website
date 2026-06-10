SET @column_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'pages'
      AND COLUMN_NAME = 'parent_id'
);

SET @statement := IF(
    @column_exists = 0,
    'ALTER TABLE pages ADD COLUMN parent_id INT UNSIGNED NULL AFTER id',
    'SELECT 1'
);

PREPARE add_parent_id FROM @statement;
EXECUTE add_parent_id;
DEALLOCATE PREPARE add_parent_id;

SET @fk_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'pages'
      AND CONSTRAINT_NAME = 'pages_parent_id_foreign'
);

SET @statement := IF(
    @fk_exists = 0,
    'ALTER TABLE pages ADD CONSTRAINT pages_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES pages(id) ON DELETE SET NULL',
    'SELECT 1'
);

PREPARE add_parent_fk FROM @statement;
EXECUTE add_parent_fk;
DEALLOCATE PREPARE add_parent_fk;
