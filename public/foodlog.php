<?php

    /*******************************\
    *                               *
    * foodlog.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display food log.             *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php"); 

    $foodlog = [];
    for ($date = $FS->DateInt(time()), $idx = 0; $idx < 14; $idx++, $date--)
    {
        try {
            $temp = $FS->FoodGetEntries($date);
            if (strlen($temp) > 1)
                $foodlog[$date] = $FS->FoodGetEntries($date);
        }
        catch(FatSecretException $ex) {
            $FS->Apologize("Unable to get food entries!", $ex, "food.php");
        }
    }

    // Pass weight log history for rendering
    render(makeUserTitle(null, false, "Food Log"), "foodlog_form.php",
           [ "foodlog" => $foodlog ], true );
?>
