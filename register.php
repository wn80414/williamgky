<?php include('header.php'); ?>

<head>
    <style>
        .register-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .register-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .register-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .register-form input[type="text"],
        .register-form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .register-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .register-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">

        <form class="register-form" action="register_handler.php" method="POST">
            <h2>Register</h2>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Verify Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
    </div>

</body>

</html>