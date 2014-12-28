<?php

    /*******************************\
    *                               *
    * index.php                     *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Main page.                    *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php"); 

    // render bglog
    render("{$_SESSION['fname']} {$_SESSION['lname']}", "mainmenu.php");
?>
