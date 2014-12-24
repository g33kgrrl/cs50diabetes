<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $url = 'login.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        // query database for user
        $users = query("SELECT * FROM users WHERE username = ?", $username);

        // if # of matches is NOT one, flag an error
        if (count($users) != 1)
        {
            apologize("Invalid username", $url);
        }
        // first (and only) row
        $user = $users[0];

        // if password no good, flag an error
        $hash = $user['hash'];
        if (crypt($password, $hash) != $hash)
        {
            apologize("Invalid password",$url);
        }

	try {
            $API->ProfileGetAuth($username, $token, $secret);
	}
	catch(FatSecretException $ex) {
            apologize("Unable to authorize FS profile!  Error: " . $ex->getCode()
                      . " - " . $ex->getMessage(), $url);
	}

        // log the user in, and remember that user is now logged in by storing
        //   user's ID (and all other pertinent info) in _SESSION
        $_SESSION['id']       = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['token']    = (string)$token;
        $_SESSION['secret']   = (string)$secret;
        $_SESSION['fname']    = $user['fname'];
        $_SESSION['lname']    = $user['lname'];

        // redirect to index
        redirect("/");
    }
    else
    {
        if (!empty($_SESSION['id']))
        {
            redirect("/");
        }
        // else render form
        render("Log In", "login_form.php", [], true);
    }

?>
