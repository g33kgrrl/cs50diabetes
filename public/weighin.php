<?php

    /*******************************\
    *                               *
    * weighin.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Log a weigh-in.               *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php"); 

    $stat;
    try
    {
//      $stat = $FS->LogWeighIn(245, "First Weigh-in", 70, 210);
        $stat = $FS->LogWeighIn(243, "One week");
    }
    catch(FatSecretException $ex)
    {
        $FS->Apologize("Unable to get FS weight log!", $ex, "weighin.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Do Weigh-In</title>
    </head>

    <body>
        <h1>Weigh-In</h1>
        <pre><?php var_dump($stat); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>
    </body>

</html>
