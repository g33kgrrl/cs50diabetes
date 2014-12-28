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

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $url = "weighin.php";
        $curWeight = $_POST['curWeight'];
        $comment = $_POST['comment'];
        $height = $_POST['height'];
        $goalWeight = $_POST['goalWeight'];

        $stat;
        try
        {
            $stat = $FS->LogWeighIn($curWeight,$comment,$height,$goalWeight);
        }
        catch(FatSecretException $ex)
        {
            $FS->Apologize("Unable to log weigh-in!", $ex, $url);
        }

        if (!stat)
        {
            apologize("Unknown failure logging weigh-in!", $url);
        }

        redirect("weightlog.php");        
    }
    // else render form
    else
    {
        render(makeusertitle(null,false,"Weigh-In"), "weighin_form.php", []);
    }
?>
