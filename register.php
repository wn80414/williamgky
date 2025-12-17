<?php include('header.php'); ?>

<head>
    
</head>

<body>
    <br>

    <div class="container page-offset center-screen">
        <form class="register-form" action="register_handler.php" method="POST">
            <h2>Register</h2>
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
                <div class="message error" id="msg"><?= $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="message success" id="msg"><?= $_SESSION['success']; ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <br>
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>

</html>