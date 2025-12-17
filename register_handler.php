<?php
session_start();
require_once __DIR__ . '/inc/db.php';

$pdo = get_db();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$register = $_POST['register'] ?? null;

$username = trim(str_replace(' ', '', $username));

if (!$username || !$password) {
    fieldsBlank();
}

if (isset($register)) {

    $stmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(username) = LOWER(?)");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        usernameDenied($username);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO users (username, password, role)
        VALUES (?, ?, 'user')
    ");

    $stmt->execute([$username, $hashedPassword]);

    userAdded($username);
}

function userAdded($name)
{
    $_SESSION['success'] = "User successfully added.";
    header("Location: register.php");
    exit();
}

function usernameDenied($username)
{
    $_SESSION['error'] = "Username already exists.";
    header("Location: register.php");
    exit();
}

function fieldsBlank()
{
    $_SESSION['error'] = "Please fill out all form fields.";
    header("Location: register.php");
    exit();
}
