<?php

declare(strict_types=1);

/**
 * Create or reset an admin account from the command line.
 *
 *   php create-admin.php <email> <password> ["Full Name"]
 *
 * Reads DB credentials from .env. If the email already exists, its password
 * (and name) are updated; otherwise a new admin is created.
 */

define('BASE_PATH', __DIR__);

require __DIR__ . '/app/Support/helpers.php';
load_env(__DIR__ . '/.env');
require __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

[$script, $email, $password, $name] = array_pad($argv, 4, null);

if (!$email || !$password) {
    fwrite(STDERR, "Usage: php create-admin.php <email> <password> [\"Full Name\"]\n");
    exit(1);
}
if (strlen((string) $password) < 8) {
    fwrite(STDERR, "Password must be at least 8 characters.\n");
    exit(1);
}

$email = strtolower(trim((string) $email));
$name = $name ?: 'Admin';

try {
    $pdo = Database::connection();
    $hash = password_hash((string) $password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, password_hash, created_at, updated_at)
         VALUES (?, ?, ?, NOW(), NOW())
         ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash), name = VALUES(name), updated_at = NOW()'
    );
    $stmt->execute([$name, $email, $hash]);
    echo "Admin ready: {$email}\n";
} catch (Throwable $e) {
    fwrite(STDERR, "Failed: " . $e->getMessage() . "\n");
    exit(1);
}
