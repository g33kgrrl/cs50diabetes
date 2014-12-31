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

        $token = $user['token'];;
        $secret = $user['secret'];
        if (empty($token))
        {
            try
            {
                $FS->ProfileGetAuth($username, $token, $secret);
            }
            catch(FatSecretException $ex)
            {
                $FS->Apologize("Unable to authorize FS profile!", $ex, $url);
            }
        }

        updateSessionUser($username, $token, $secret);

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
