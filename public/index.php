<?php

    // configuration
    require("../includes/config.php"); 

    // render bglog
    render("{$_SESSION['fname']} {$_SESSION['lname']}", "menu.php");
?>
