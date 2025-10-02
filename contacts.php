<?php include('header.php'); ?>

<head>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }


    .contact-container {
        background-color: white;
        max-width: 1000px;
        margin: 60px auto;
        padding: 0 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
    }

    .contact-info p {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    </style>
</head>

<body>

    <!-- Contact Section -->
    <div class="contact-container">

        <!-- Contact Info -->
        <div class="contact-info">
            <br>
            <h2>Contact Us</h2>
            <pre>
                <?php
                // Path to the text file
                $filename = 'contacts.txt';

                // Check if file exists
                if (file_exists($filename)) {
                    // Read the file content and output it safely
                    echo '<p>'.htmlspecialchars(file_get_contents($filename)).'</p>';
                } else {
                    echo "Sorry, the file does not exist.";
                }
                ?>
            </pre>
        </div>
    </div>

</body>

</html>