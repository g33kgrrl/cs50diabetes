<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $oldpwd = $_POST['oldpwd'];
        $username = $_SESSION['username'];
        $chgurl = "chgpwd.php";

        // query database for user
        $users = query("SELECT * FROM users WHERE username = ?",
                       $username);
        // if # of matches is NOT one, flag an error
        if (count($users) != 1)
        {
            apologize("Username error!", $chgurl);
        }
        $hash = $users[0]['hash'];
        // if password no good, flag an error
        if (crypt($oldpwd, $hash) != $hash)
        {
            apologize("Invalid old password.", $chgurl);
        }
        $password = $_POST['password'];
        if ($password != $_POST['confirm'])
        {
            apologize("Password confirmation failed!", $chgurl);
        }

        $hash = crypt($password);
        $stat = query("UPDATE users SET hash = ? WHERE username = ?",
                      $hash, $username);
        if ($stat === false)
        {
            apologize("Invalid password!", $chgurl);
        }

        // redirect to index
        redirect("/");
    }
    else
    {
        // else render form
        render(makeusertitle("Change",false,"Password"), "chgpwd_form.php", [], true);
    }

?>
