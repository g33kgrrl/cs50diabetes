<?php

    /*******************************\
    *                               *
    * cfgbolus.php                  *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Configure bolus calculator.   *
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
        $url = "cfgbolus.php";

        $carbRatio   = $_POST['carbRatio'];
        $sesitivity  = $_POST['sensitivity'];
        $bgTargetMin = $_POST['bgTargetMin'];
        $bgTargetMax = $_POST['bgTargetMax'];

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
// Carb Ratio: 10 gm/U (3-150)
// Sensitivity: 20 mg/dL per U (10-400)
// BG Target: 95-100 mg/dL (60-250)
        $params =
            [ 'enabled'     => ($_SESSION['carbRatio'] >= 0) ? "checked" : "",
              'carbRatio'   => $_SESSION['carbRatio'],
              'sensitivity' => $_SESSION['sensitivity'],
              'bgTargetMin' => $_SESSION['bgTargetMin'],
              'bgTargetMax' => $_SESSION['bgTargetMax'] ];
        render(makeusertitle(null,false,"Bolus Settings"), "cfgbolus_form.php", $params, true);
    }

?>
