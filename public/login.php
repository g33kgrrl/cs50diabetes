<?php

    /*******************************\
    *                               *
    * login.php                     *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Login user and authenticate   *
    *   with FatSecret.             *
    *                               *
    \*******************************/

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

        $token;
        $secret;
	try
        {
            $FS->ProfileGetAuth($username, $token, $secret);
	}
	catch(FatSecretException $ex)
        {
            $FS->Apologize("Unable to authorize FS profile!", $ex, $url);
	}
        $auth = [ 'user_id' => $username, 'token' => (string)$token, 'secret' => (string)$secret ];
        $sessionKey = $FS->ProfileRequestScriptSessionKey($auth, null, null, null, false);

        // log the user in, and remember that user is now logged in by storing
        //   user's ID (and all other pertinent info) in _SESSION
        $_SESSION['id']          = $user['id'];
        $_SESSION['username']    = $username;
        $_SESSION['token']       = (string)$token;
        $_SESSION['secret']      = (string)$secret;
        $_SESSION['sessionKey']  = (string)$sessionKey;
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
        if (!empty($_SESSION['id']))
        {
            redirect("/");
        }
        // else render form
        render("Log In", "login_form.php", [], true);
    }

?>
