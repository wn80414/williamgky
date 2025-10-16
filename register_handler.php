<?php
session_start();
extract($_POST);

// check if user has left USERNAME or PASSWORD field blank
if (!$username || !$password) {
    fieldsBlank();
    die();
}

$username = trim($username);
$username = str_replace(' ', '', $username);

// check if the New User button was clicked
if (isset($register)) {


    // open password.txt for reading
    if (!($file = fopen("../secure/password.txt", "r"))) {
        print("<title>Error</title></head><body>
        Could not open password file for reading.
        </body></html>");
        die();
    }

    // check if username already exists
    $userExists = false;
    while (!feof($file)) {
        $line = fgets($file);
        $filedata = explode(",", trim($line));
        if (strtolower($filedata[0]) == strtolower($username)) {
            $userExists = true;
            break;
        }
    }
    fclose($file);

    if ($userExists) {
        usernameDenied($username);
        die();
    }

    // open password.txt for writing using append mode
    if (!($file = fopen("../secure/password.txt", "a"))) {
        // print error message and terminate script
        // execution if file cannot be opened
        print("<title>Error</title></head><body>
        Could not open password file
        </body></html>");
        die();
    }

    // write username and password to file and
    // call function userAdded
    fputs($file, "$username,$password,user\n");
    userAdded($username);
    fclose($file);
}


// print a message indicating the user has been added
function userAdded($name)
{
    $_SESSION['success'] = "User sucessfully added.";
    header("Location: register.php");
    exit();
}

// print a message indicating access has been denied
function usernameDenied($username)
{
    $_SESSION['error'] = "Username already exists.";
    header("Location: register.php");
    exit();
}
// print a message indicating that fields have been left blank
function fieldsBlank()
{
    $_SESSION['error'] = "Please fillout all form fields.";
    header("Location: register.php");
    exit();
}
