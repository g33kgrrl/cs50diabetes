<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // get blood glucose
        $bgReading = $_POST["bgReading"];
        
        // whole numbers only
        if (!preg_match("/^\d+$/", $bgReading))
        {
            apologize("\"{$bgReading}\" is not a valid reading.");
        }
        
        $mealtime = $_POST["mealtime"];      
        
        // add bg reading to log
        $addReading = query("INSERT INTO bglog (id, mealtime, reading) VALUES(?, ?, ?)", $_SESSION["id"], $mealtime, $bgReading);
        
        if ($addReading === false)
        {
            apologize("Could not add reading to blood glucose log.");
        }
        
        redirect("bglog.php");        
    }
    // else render form
    else
    {
        render(makeusertitle("Enter",false,"Blood Glucose"), "bg_form.php", [], true);
    }
?>
