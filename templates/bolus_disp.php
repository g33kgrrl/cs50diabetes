<?php

    /*******************************\
    *                               *
    * bolus_disp.php                *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display bolus calculator      *
    *   results.                    *
    *                               *
    \*******************************/

?>

    <h1>
        Bolus for <?=$_SESSION['firstName']?> <?=$_SESSION['lastName']?>
    </h1>
<?php
    if (isset($BG))
    {
?>
        <div>
            BG = <?=$BG['BG']?>, bolus = <?=$BG['bolus']?> units
        </div>
<?php
    }
    if (isset($Carbs))
    {
?>
        <div>
            Carbs = <?=$Carbs['Carbs']?>, bolus = <?=$Carbs['bolus']?> units
        </div>
<?php
    }
?>
    <div>
        Total bolus = <?=$bolus?> units
    </div>
