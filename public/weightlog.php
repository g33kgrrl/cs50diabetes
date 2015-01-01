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

    $weightLog = load_weightLog();

    // Pass weight log history for rendering
    render(makeUserTitle(null, false, "Weight Log"), "weightlog_disp.php",
           [ "weightLog" => $weightLog ], true );

?>
