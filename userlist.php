<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$file = 'users.txt';
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

echo json_encode([
    "status" => "success",
    "count" => count($result),
    "result" => $result
], JSON_PRETTY_PRINT);
