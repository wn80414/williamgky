<?php
include("header.php");

$result = [];
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
    if (!$field[0] == "") {
        array_push($result, $field[0]);
    }
}
// close text file
fclose($file);
?>
<style>
    table {
        border-collapse: collapse;
        width: 40%;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <br>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Spartan Market Users (William Nguyen)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $name): ?>
                    <tr>
                        <td><?= htmlspecialchars($name) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>