<?php

    /*******************************\
    *                               *
    * weight.php                    *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Get weight log.               *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php"); 

    $weightlog;
    try
    {
        $weightlog = $FS->WeightGetMonth();
    }
    catch(FatSecretException $ex)
    {
        $FS->Apologize("Unable to get FS weight log!", $ex);
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Weight Log</title>
    </head>

    <body>
        <h1>Weight Log</h1>
        <pre><?php var_dump($weightlog); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>
    </body>

</html>
