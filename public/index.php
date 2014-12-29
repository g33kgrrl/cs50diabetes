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
    render("{$_SESSION['firstName']} {$_SESSION['lastName']}", "mainmenu.php");
?>
