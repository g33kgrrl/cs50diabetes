<?php

    /*******************************\
    *                               *
    * carblog.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display carb log history.     *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    $carbLog = load_carbLog();

    $carbMealtimeAvgs = load_carbMealtimeAvgs();

    // tack on carb log and page title before passing data to render()
    render(makeUserTitle(null, false, "Carb Log"), "carblog_disp.php",
           [ "carbLog" => $carbLog, "carbMealtimeAvgs" => $carbMealtimeAvgs], true);

?>
