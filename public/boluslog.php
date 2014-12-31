<?php

    /*******************************\
    *                               *
    * boluslog.php                  *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display Bolus log history.    *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    $bolusLog = load_bolusLog();

    $bolusMealtimeAvgs = load_bolusMealtimeAvgs();

    // tack on bolus log and page title before passing data to render()
    render(makeUserTitle(null, false, "Bolus Log"), "boluslog_disp.php",
           [ "bolusLog" => $bolusLog, "bolusMealtimeAvgs" => $bolusMealtimeAvgs], true);

?>
