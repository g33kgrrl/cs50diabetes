<?php

    /*******************************\
    *                               *
    * diag.php                      *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Dump values in $_SESSION.     *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Diagnostic Dump</title>
    </head>

    <body>
        <h1>$_SESSION</h1>
        <pre><?php var_dump($_SESSION); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>
    </body>
</html>
