<?php

    /*******************************\
    *                               *
    * register.php                  *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Register new user.            *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $url = "register.php";
        if ($password != $_POST['confirm']) {
            apologize("Password confirmation failed!", $url);
        }

        $token;
        $secret;
	try
        {
	    $FS->ProfileCreate($username, $token, $secret);
	}
	catch(Exception $ex)
        {
            if ($ex->GetCode() != 106) {
                $FS->Apologize("Unable to create FS profile!", $ex, $url);
            }
	}
print "token:";
var_dump($token);

        $token2;
        $secret2;
	try {
            $FS->ProfileGetAuth($username, $token2, $secret2);
	}
	catch(FatSecretException $ex) {
            $FS->Apologize("Unable to authorize FS profile!",$ex,$url);
	}
print "token2:";
var_dump($token2);
        if ((string)$token !== (string)$token2)
        {
            apologize("FS token syncronization error: ", $url,
                      (string)$token . " vs. " . (string)$token2);
        }
        if ((string)$secret !== (string)$secret2)
        {
            apologize("FS secret syncronization error: ", $url,
                      (string)$secret . " vs. " . (string)$secret2);
        }

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $stat = query("INSERT INTO users (username, hash, firstName, lastName) "
                      . "VALUES(?, ?, ?, ?)",
                      $username, crypt($password), $firstName, $lastName);
        if ($stat === false)
        {
            apologize("Invalid username and/or password!", $url);
        }

        // If registration succeeded, stay logged-in
        updateSessionUser($username, $token2, $secret2);

        // redirect to index
        redirect("/");
    }
    else
    {
        // else render form
        render("Register", "register_form.php", [], true);
    }
?>
