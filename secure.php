<?php include('header.php'); ?>

<?php
$result = [];
if (!isset($_SESSION['role']) || !isset($_SESSION['logged_in'])) {
    denyAccess();
}
if ($_SESSION['role'] !== 'admin' || $_SESSION['logged_in'] !== true) {
    denyAccess();
} else {
    // for reading
    if (!($file = fopen("../secure/password.txt", "r"))) {
        print("<title>Error</title></head>
            <body>Could not open password file
            </body></html>");
        die();
    }
    // read each line in the file and extract name and password
    while (!feof($file)) {
        $line = fgets($file);
        $line = chop($line);

        // split username and password
        $field = explode(",", $line);

        array_push($result, $field[0]);
    }
    // close text file
    fclose($file);
}

function denyAccess()
{
    echo "<title>Access Denied</title></head>
        <body style = \"font-family: arial;
        font-size: 1em; color: red\">
        <strong>You were denied access to this server.
        <br /></strong>";
    exit();
}
?>
<!-- Main Content -->
<div class="container">
    <h1>Welcome <?= htmlspecialchars($_SESSION['user']); ?>!</h1><br>
</div>

<div class="container">
    <table style="text-align:center;">
        <tr>
            <th>Users</th>
        </tr>
        <?php foreach ($result as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>

</html>