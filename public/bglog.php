<?php

    /*******************************\
    *                               *
    * bglog.php                     *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display BG log history.       *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");
    
    $bgLog = load_bgLog();
    
    $bgMealtimeAvgs = load_bgMealtimeAvgs();
        
    // tack on blood glucose log and page title before passing data to render()       
    render(makeUserTitle(null, false, "BG Log"), "bglog_form.php",
           [ "bgLog" => $bgLog, "bgMealtimeAvgs" => $bgMealtimeAvgs], true);

?>
