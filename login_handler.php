<?php
session_start();
extract($_POST);

// check if user has left USERNAME or PASSWORD field blank
if (!$username || !$password) {
    fieldsBlank();
    die();
}

// check if the New User button was clicked
if (isset($login)) {
    // for reading
    if (!($file = fopen("../secure/password.txt", "r"))) {
        print("<title>Error</title></head>
        <body>Could not open password file
        </body></html>");
        die();
    }
    $userVerified = 0;

    // read each line in the file and extract name and password
    while (!feof($file)) {
        $line = fgets($file);
        $line = chop($line);

        // split username and password
        $field = explode(",", $line);

        // verify username
        if (strtolower($username) == strtolower($field[0])) {
            $userVerified = 1;

            // call function checkPassword to verify user's password
            if (checkPassword($password, $field) == true)
                accessGranted($username, $field[2]);
            else
                wrongPassword();
        }
    }
    // close text file
    fclose($file);

    // call function accessDenied if username has
    // not been verified
    if (!$userVerified) {
        accessDenied();
    }
}

// verify user_password and return a boolean
function checkPassword($userpassword, $filedata)
{
    if ($userpassword == $filedata[1])
        return true;
    else
        return false;
}

// print a message indicating permission has been granted
function accessGranted($username, $role)
{
    $_SESSION['user'] = $username;
    $_SESSION['logged_in'] = true;
    $_SESSION['role'] = $role;
    session_regenerate_id(true);
    if ($role == 'admin'){
        header("Location: secure.php");     
    } else{
        header("Location: home.php");     
    } 
    
    exit();
}
// print a message indicating password is invalid
function wrongPassword()
{
    $_SESSION['error'] = "Wrong username or password.";
    header("Location: register.php");
    exit();
}

// print a message indicating access has been denied
function accessDenied()
{
    $_SESSION['error'] = "Wrong username or password.";
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
