<?php
session_start();
require_once __DIR__ . '/inc/db.php';

$pdo = get_db();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$login    = $_POST['login'] ?? null;

$username = trim(str_replace(' ', '', $username));

if (!$username || !$password) {
    fieldsBlank();
}

if (isset($login)) {

    $stmt = $pdo->prepare("
        SELECT username, password, role
        FROM users
        WHERE LOWER(username) = LOWER(?)
        LIMIT 1
    ");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        accessGranted($user['username'], $user['role']);
    } else {
        accessDenied();
    }
}


function accessGranted($username, $role)
{
    $_SESSION['user'] = $username;
    $_SESSION['logged_in'] = true;
    $_SESSION['role'] = $role;

    session_regenerate_id(true);

    if ($role === 'admin') {
        header("Location: secure.php");
    } else {
        header("Location: home.php");
    }
    exit();
}

function accessDenied()
{
    $_SESSION['error'] = "Wrong username or password.";
    header("Location: login.php");
    exit();
}

function fieldsBlank()
{
    $_SESSION['error'] = "Please fill out all form fields.";
    header("Location: login.php");
    exit();
}
