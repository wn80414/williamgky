<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Spartan Market</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 0 20px;
            height: 60px;
        }

        .nav-center,
        .nav-right {
            display: flex;
            gap: 15px;
        }

        .nav-center {
            margin: 0 auto;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        .navbar a:hover {
            background-color: #575757;
            border-radius: 4px;
        }

        /* Page Content */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #0e0e0eff;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="nav-center">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="products.php">Products</a>
            <a href="news.php">News</a>
            <a href="contacts.php">Contact</a>
            <a href="animal.php">Animal</a>
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

</body>

</html>