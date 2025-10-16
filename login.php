<?php include('header.php'); ?>

<head>
    <style>
        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <br>
    <div class="container">
        <form class="login-form" action="login_handler.php" method="POST">
            <h2>Login</h2>
            <!-- 
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>
            -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <!-- 
            <label for="confirm_password">Verify Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
    -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="message error" style="color: red" id="msg"><?= $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="message success" style="color: green" id="msg"><?= $_SESSION['success']; ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>

</html>