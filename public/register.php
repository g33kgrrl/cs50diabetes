<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $regurl = "register.php";
        if ($password != $_POST['confirm'])
        {
            apologize("Password confirmation failed!", $regurl);
        }

        $stat = query("INSERT INTO users (username, hash, cash) " .
                      "VALUES(?, ?, 1000.0000)", $username, crypt($password));
        if ($stat === false)
        {
            apologize("Invalid username and/or password!", $regurl);
        }

        // If registration succeeded, stay logged-in
        $users = query("SELECT * FROM users WHERE username = ?", $username);
        $user = $users[0];
        $_SESSION['id']        = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['cash']      = $user['cash'];
        $_SESSION['lastsym']   = null;
        $_SESSION['portfolio'] = [];

        // redirect to portfolio
        redirect("/");
    }
    else
    {
        // else render form
        render("Register", "register_form.php");
    }

?>
