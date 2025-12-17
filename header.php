<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Spartan Market</title>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUa6mY5Y6Yd2Vn0s0k3QpQ4f5p3K/3e1Z6mZ6Y5v1p6Kj3q9R6qD9Q6G5z6K" crossorigin="anonymous">
    <!-- Site styles (load after bootstrap & fonts) -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="navbar">
        <div class="nav-center">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="product_list.php">Products</a>
            <a href="news.php">News</a>
            <a href="contacts.php">Contact</a>
            <a href="animal.php">Animal</a>
            <a href="myusers.php">My Company User List</a>
            <a href="curl.php">Other Company's User List</a>
        </div>
        <div class="nav-right">
            <?php if (!isset($_SESSION['user']) || $_SESSION['logged_in'] !== true): ?>
            <!-- Show these if NOT logged in -->
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php else: ?>
            <!-- Show these if logged in -->
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['logged_in'] !== true): ?>
                <p><a href="secure.php">Profile: <?= htmlspecialchars(strtoupper($_SESSION['user'])); ?></a></p>
            <?php else: ?>
                <p><a href="home.php">Profile: <?= htmlspecialchars(strtoupper($_SESSION['user'])); ?></a></p>
            <?php endif; ?>
            <p> <a href="logout.php">Logout</a></p>
        <?php endif; ?>
        </div>
    </div>

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-left">
                <small>&copy; <?= date('Y') ?> Spartan Market — Built by SJSU students</small>
            </div>
            <div class="footer-right">
                <a href="contacts.php">Contact Us</a>
            </div>
        </div>
    </footer>

</body>

</html>