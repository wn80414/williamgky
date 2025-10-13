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
        </div>
        <div class="nav-right">
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </div>
    </div>

</body>

</html>

