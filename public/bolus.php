<?php

    /*******************************\
    *                               *
    * bolus.php                     *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Calculate Insulin bolus.      *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

//
// Carb Ratio: 10 gm/U (3-150)
// Sensitivity: 20 mg/dL per U (10-400)
// BG Target: 95-100 mg/dL (60-250)
//
    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $url = "bolus.php";

        $params = [];
        $bolus = 0;

        // get blood glucose
        $BG = $_POST['BG'];
        if ($BG > 0)
        {
            $bgTMin = $_SESSION['bgTargetMin'];
            $bgTMax = $_SESSION['bgTargetMax'];
            if ($BG > $bgTMax)
                $partial = ($BG - $_SESSION['bgTargetMax']) / $_SESSION['sensitivity'];
            else if ($BG < $bgTMin)
                $partial = ($BG - $_SESSION['bgTargetMin']) / $_SESSION['sensitivity'];
            else
                $partial = 0;
            $params['BG'] = [ 'BG' => $BG . " mg/dL", 'bolus' => $partial ];
            $bolus += $partial;
        }

        $carbs = $_POST['carbs'];
        if ($carbs > 0)
        {
            $partial = $carbs / $_SESSION['carbRatio'];
            $params['Carbs'] = [ 'Carbs' => $carbs . " gm", 'bolus' => $partial ];
            $bolus += $partial;
        }

        $mealtime = $_POST["mealtime"];

        if ($bolus < 0)
            $bolus = 0;

        $params['bolus'] = number_format(floor($bolus * 10) / 10, 1);

        if ($BG > 0)
        {
            // add bg reading to log
            $stat = query("INSERT INTO bglog (id, mealtime, reading) VALUES(?, ?, ?)", $_SESSION["id"], $mealtime, $BG);

            if ($stat === false)
            {
                apologize("Bolus = " . $params['bolus'] . " Could not add reading to blood glucose log.");
            }
        }

        // Render form to confirm purchase
        render(makeusertitle("Display Bolus for",false,null), "bolus_disp.php", $params, true);
    }

    // else render form
    else
    {
        if ($_SESSION['carbRatio'] == 0)
        {
            apologize("Bolus not enabled!");
        }

        render(makeusertitle("Calculate Bolus for",false,null), "bolus_form.php", [], true);
    }

?>
