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

        // get mealtime
        $mealtime = $_POST["mealtime"];

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
        else
        {
            $BG = 0;
        }

        $carbs = $_POST['carbs'];
        if ($carbs > 0)
        {
            $partial = $carbs / $_SESSION['carbRatio'];
            $params['Carbs'] = [ 'Carbs' => $carbs . " gm", 'bolus' => $partial ];
            $bolus += $partial;
        }
        else
            $carbs = 0;

        $bolus = floor($bolus * 10) / 10;
        if ($bolus < 0)
            $bolus = 0;

        $params['bolus'] = number_format($bolus, 1);

        if ($carbs > 0 || $BG > 0)
        {
            // add bg reading to log
            $stat = query("INSERT INTO bglog (id, mealtime, reading, carbs, bolus) VALUES(?, ?, ?, ?, ?)",
                          $_SESSION["id"], $mealtime, $BG, $carbs, $bolus);

            if ($stat === false)
            {
                apologize("Bolus = " . $params['bolus'], null, "Could not add entry to bg log.");
            }
        }

        // Render form to confirm purchase
        render(makeUserTitle("Display", false, "Bolus"), "bolus_disp.php", $params, true);
    }

    // else render form
    else
    {
        if ($_SESSION['carbRatio'] <= 0)
        {
            apologize("Bolus not enabled!");
        }

        render(makeUserTitle("Calculate", false, "Bolus"), "bolus_form.php", [], true);
    }

?>
