<?php include('header.php'); ?>

<head>

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