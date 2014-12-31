<?php

    /*******************************\
    *                               *
    * bg.php                        *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Enter BG reading.             *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // get blood glucose
        $bgReading = $_POST["bgReading"];

        // get meal time
        $mealtime = $_POST["mealtime"];
        
        // add bg reading to log
        $addReading = query("INSERT INTO bglog (id, mealtime, reading) VALUES(?, ?, ?)",
                            $_SESSION["id"], $mealtime, $bgReading);
        
        if ($addReading === false)
        {
            apologize("Could not add reading to blood glucose log.");
        }
        
        redirect("bglog.php");        
    }
    // else render form
    else
    {
        render(makeUserTitle("Enter", false, "Blood Glucose"), "bg_form.php", [], true);
    }
?>
