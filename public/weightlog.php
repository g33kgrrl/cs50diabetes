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

    $weightlog = load_weightLog($FS);

    // Pass weight log history for rendering
    render(makeUserTitle(null, false, "Weight Log"), "weightlog_disp.php",
           [ "weightlog" => $weightlog ], true );

?>
