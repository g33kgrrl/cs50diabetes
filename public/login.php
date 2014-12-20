<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // query database for user
        $users = query("SELECT * FROM users WHERE username = ?", $username);

        // if # of matches is NOT one, flag an error
        if (count($users) != 1)
        {
            apologize("Invalid username.","login.php");
        }
        // if password no good, flag an error
        // first (and only) row
        $user = $users[0];
        $hash = $user['hash'];
        if (crypt($password, $hash) != $hash)
        {
            apologize("Invalid password.","login.php");
        }

        // log the user in, and remember that user is now logged in by storing
        //   user's ID (and username, cash and entire portfolio) in _SESSION
        $_SESSION['id']        = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['cash']      = $user['cash'];
        $_SESSION['lastsym']   = null;
        $_SESSION['portfolio'] = read_portfolio($_SESSION['id']);

        // redirect to portfolio
        redirect("/");
    }
    else
    {
        // else render form
        render("Log In", "login_form.php");
    }

?>
