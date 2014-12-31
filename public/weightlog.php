<?php

    /*******************************\
    *                               *
    * weightlog.php                 *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display Weight Log.           *
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

    // Pass weight log history for rendering
    render(makeUserTitle(null, false, "Weight Log"), "weightlog_form.php",
           [ "weightlog" => $weightlog ], true );

?>
