<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $regurl = "register.php";
        if ($password != $_POST['confirm']) {
            apologize("Password confirmation failed!", $regurl);
        }

	try {
	    $API->ProfileCreate($username, $token, $secret);
	}
	catch(Exception $ex) {
// Uncomment these lines to reconnect a new CS50 Diabetes user to an existing FatSecret user
//          if ($ex->GetCode() != 106) {
                apologize("Unable to create FS profile!<br/>"
                          . 'Error: ' . $ex->getCode() . ' - ' . $ex->getMessage(),
                          $regurl);
//          }
	}
	try {
            $API->ProfileGetAuth($username, $token2, $secret2);
	}
	catch(FatSecretException $ex) {
            apologize("Unable to authorize FS profile!"
                      . 'Error: ' . $ex->getCode() . ' - ' . $ex->getMessage(),
                      $regurl);
	}
        if ((string)$token !== (string)$token2)
        {
            apologize("FS token syncronization error: " .
                      (string)$token . " vs. " . (string)$token2, $regurl);
        }
        if ((string)$secret !== (string)$secret2)
        {
            apologize("FS secret syncronization error: " .
                      (string)$secret . " vs. " . (string)$secret2, $regurl);
        }

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $stat = query("INSERT INTO users (username, hash, fname, lname) "
                      . "VALUES(?, ?, ?, ?)",
                      $username, crypt($password), $fname, $lname);
        if ($stat === false)
        {
            apologize("Invalid username and/or password!", $regurl);
        }

        // If registration succeeded, stay logged-in
        $users = query("SELECT * FROM users WHERE username = ?", $username);
        $user = $users[0];
        $_SESSION['id']        = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['token']     = (string)$token2;
        $_SESSION['secret']    = (string)$secret2;
        $_SESSION['fname']     = $user['fname'];
        $_SESSION['lname']     = $user['lname'];

        // redirect to index
        redirect("/");
    }
    else
    {
        // else render form
        render("Register", "register_form.php", [], true);
    }
?>
