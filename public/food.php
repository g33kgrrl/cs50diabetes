<?php

    /*******************************\
    *                               *
    * food.php                      *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display food log.             *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php"); 
    $foodlog;
    try {
        $foodlog = $FS->FoodGetEntries();
    }
    catch(FatSecretException $ex) {
        $FS->Apologize("Unable to get food entries!", $ex, "food.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Food Entries Log</title>
    </head>

    <body>
        <h1>Food Entries Log</h1>
        <pre><?php var_dump($foodlog); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>
    </body>

</html>
