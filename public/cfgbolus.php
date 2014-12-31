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

        $enabled = isset($_POST['enabled']);
        $carbRatio   = $_POST['carbRatio'];
        $sensitivity = $_POST['sensitivity'];
        $bgTargetMin = $_POST['bgTargetMin'];
        $bgTargetMax = $_POST['bgTargetMax'];

        if (!$enabled)
            $carbRatio = -abs($carbRatio);
        if ($bgTargetMax - $bgTargetMin < 5)
            apologize("BG Target Min must be at least 5 less than Max", $url);
        if ($bgTargetMax - $bgTargetMin > 20)
            apologize("BG Target Max must be no more than 20 greater than Min", $url);

        // Update users DB with new bolius configuration info
        $stat = query("UPDATE users SET carbRatio = ?, sensitivity = ?, bgTargetMin = ?, bgTargetMax = ? WHERE id = ?", $carbRatio, $sensitivity, $bgTargetMin, $bgTargetMax, $_SESSION['id']);

    print "stat {" . sizeof($stat) . "}<br/>";
    var_dump($stat);

        updateSessionUser($_SESSION['username']);

        // Render form to confirm purchase
        redirect('/');
    }

    // else render form
    else
    {
// Carb Ratio: 10 gm/U (3-150)
// Sensitivity: 20 mg/dL per U (10-400)
// BG Target: 95-100 mg/dL (60-250)
        $params =
            [ 'state'       => ($_SESSION['carbRatio'] > 0) ? "checked" : "unchecked",
              'carbRatio'   => abs($_SESSION['carbRatio']),
              'sensitivity' => $_SESSION['sensitivity'],
              'bgTargetMin' => $_SESSION['bgTargetMin'],
              'bgTargetMax' => $_SESSION['bgTargetMax'] ];
        render(makeUserTitle(null, false, "Bolus Settings"), "cfgbolus_form.php", $params, true);
    }

?>
