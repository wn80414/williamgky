<?php


class Curl
{
  public static function getUserList($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // using curl_exec() is used to execute the POST request
    $resp = curl_exec($ch);

    // decode the response 
    $final_decoded_data = json_decode($resp, true);

    //close the cURL and load the page
    curl_close($ch);
    return $final_decoded_data;
  }
}
$william_db = [];
//Read my company database
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
    array_push($william_db, $field[0]);
  }
}
// close text file
fclose($file);

//Curl Other Companies
$tommy_db = Curl::getUserList('https://plb.bfm.mybluehost.me/righttwice/curl.php')['result'];
$sean_db = Curl::getUserList('https://seanhtran.com/users.php?format=json')['data'];

$fullNames = array_map(fn($p) => $p['firstName'] . ' ' . $p['lastName'], $sean_db);

include("header.php");
?>
<body>
  <br>
  <div class="container page-offset">
    <table>
      <thead>
        <tr>
          <th>Spartan Market Users (William Nguyen)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($william_db as $name): ?>
          <tr>
            <td><?= htmlspecialchars($name) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <br>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Right Twice Users (Tommy Dang)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tommy_db as $name): ?>
          <tr>
            <td><?= htmlspecialchars($name) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
  <br>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Juso Bakery (Sean Tran)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($fullNames as $name): ?>
          <tr>
            <td><?= htmlspecialchars($name) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <br>
</body>