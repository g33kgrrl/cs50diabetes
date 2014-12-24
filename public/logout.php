<?php

    /*******************************\
    *                               *
    * logout.php                    *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Logout user.                  *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php"); 

    // log out current user, if any
    logout();

    // redirect user
    redirect("/");

?>
