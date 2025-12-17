<?php
require_once __DIR__ . '/inc/db.php';

$pdo = get_db();

// Users to insert
$users = [
    ['admin', '123', 'admin'],
    ['user1', '123', 'user'],
    ['user2', '123', 'user'],
    ['williamnguyen', '123', 'user'],
    ['bobnguyen', '123', 'user'],
    ['kevinnguyen', '123', 'user'],
    ['jim', '123', 'user'],
    ['jim2', '123', 'user'],
    ['timkim', '123', 'user'],
];

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");

foreach ($users as $user) {
    $username = $user[0];
    $password = password_hash($user[1], PASSWORD_DEFAULT); // hash password
    $role = $user[2];

    try {
        $stmt->execute([$username, $password, $role]);
        echo "Inserted user: $username\n";
    } catch (PDOException $e) {
        echo "Failed to insert user $username: " . $e->getMessage() . "\n";
    }
}
?>