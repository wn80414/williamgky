<?php
// db.php - MySQL connection helper using PDO
// Copy this file and edit the DB_* constants with your own credentials.

defined('DB_HOST') || define('DB_HOST', '127.0.0.1');
defined('DB_PORT') || define('DB_PORT', '3306');
defined('DB_NAME') || define('DB_NAME', 'spartan_market');
defined('DB_USER') || define('DB_USER', 'root');
defined('DB_PASS') || define('DB_PASS', '1723');
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');

function get_db_dsn(): string {
    return sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
}

/**
 * Returns a PDO instance. Call as $pdo = get_db();
 * Throws PDOException on failure.
 */
function get_db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false,
    ];

    $dsn = get_db_dsn();
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    return $pdo;
}

/* Usage example:
   require_once __DIR__ . '/inc/db.php';
   $pdo = get_db();
   $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
   $stmt->execute([$id]);
   $row = $stmt->fetch();
*/

?>
