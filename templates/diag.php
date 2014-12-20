<!DOCTYPE html>

<?php
    // configuration
    require("../includes/config.php"); 
?>

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
