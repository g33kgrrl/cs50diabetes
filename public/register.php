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
// Uncomment these lines to reconnect a new CS50 Diabetes user to an existing FatSecret user
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
            apologize("FS token syncronization error: " .
                      (string)$token . " vs. " . (string)$token2, $url);
        }
        if ((string)$secret !== (string)$secret2)
        {
            apologize("FS secret syncronization error: " .
                      (string)$secret . " vs. " . (string)$secret2, $url);
        }

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $stat = query("INSERT INTO users (username, hash, firstName, lastName, 0) "
                      . "VALUES(?, ?, ?, ?, ?)",
                      $username, crypt($password), $firstName, $lastName);
        if ($stat === false)
        {
            apologize("Invalid username and/or password!", $url);
        }

        $auth = [ 'user_id' => $username, 'token' => (string)$token2, 'secret' => (string)$secret2 ];
        $sessionKey = $FS->ProfileRequestScriptSessionKey($auth, null, null, null, false);

        // If registration succeeded, stay logged-in
        $users = query("SELECT * FROM users WHERE username = ?", $username);
        $user = $users[0];
        $_SESSION['id']          = $user['id'];
        $_SESSION['username']    = $user['username'];
        $_SESSION['token']       = (string)$token2;
        $_SESSION['secret']      = (string)$secret2;
        $_SESSION['sessKey']     = (string)$sessionKey;
        $_SESSION['firstName']   = $user['firstName'];
        $_SESSION['lastName']    = $user['lastName'];
        $_SESSION['carbRatio']   = $user['carbRatio'];
        $_SESSION['sensitivity'] = $user['sensitivity'];
        $_SESSION['bgTargetMin'] = $user['bgTargetMin'];
        $_SESSION['bgTargetMax'] = $user['bgTargetMax'];

        // redirect to index
        redirect("/");
    }
    else
    {
        // else render form
        render("Register", "register_form.php", [], true);
    }
?>
