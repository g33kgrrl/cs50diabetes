<?php

    // configuration
    require("../includes/config.php");
    
    $bgLog = load_bgLog();
    
    $bgMealtimeAvgs = load_bgMealtimeAvgs();
        
    // tack on blood glucose log and page title before passing data to render()       
    render(makeusertitle(null,false,"Blood Glucose Log"), "bglog_form.php",
           [ "bgLog" => $bgLog,
             "bgMealtimeAvgs" => $bgMealtimeAvgs],
           true);

?>
