<?php
include("header.php");
require_once __DIR__ . '/inc/db.php';

$pdo = get_db();

try {
    $stmt = $pdo->query("SELECT username FROM users ORDER BY username ASC");
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<body>
    <br>
    <div class="container page-offset">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Spartan Market Users (William Nguyen)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $name): ?>
                    <tr>
                        <td><?= htmlspecialchars($name) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
