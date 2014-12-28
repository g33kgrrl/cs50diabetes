<?php

    /*******************************\
    *                               *
    * bglog_form.php                *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the BG Log screen.    *
    *                               *
    \*******************************/

?>

<div class="twoCols">
    <h2><?=$title?></h2>

    <?php foreach ($bgLog as $testDate => $entries): ?>
    <?php $bgDailyAvg = load_bgDailyAvg($bgLog[$testDate]); ?>
    <table>
        <caption><h3><?= $testDate ?></h3></caption>
        <thead>
            <tr>
                <th>Time</th>
                <th>Mealtime</th>
                <th>Reading</th>
            </tr>
        </thead>
        <tbody>

<?php 
            $beforeMeal;
            $meal = "";
            $bgSpan;
?>

            <? foreach ($entries as $entry): ?>
            
<?
            $bgLevel = "";
            $bgAlert = "";            
            
            // check for BG high/low and mark entry as needed
            if ($entry["reading"] < 70 && $entry["reading"] !== "--")
            {
                $bgLevel = "bgLow";
                $bgAlert = " L";
            }
            elseif ($entry["reading"] >= 140 || ($entry["reading"] >= 110 && 
                                                    ($entry["mealtime"] == 'F'  || 
                                                     $entry["mealtime"] == "BB" || 
                                                     $entry["mealtime"] == "BL" || 
                                                     $entry["mealtime"] == "BD")))
            {
                $bgLevel = "bgHigh";
                $bgAlert = " H";
            }

            // check for high mealtime BG span and mark after-meal entry if too high
            if ($entry["mealtime"] === "BB" ||
                $entry["mealtime"] === "BL" ||
                $entry["mealtime"] === "BD")
            {
                $beforeMeal = $entry["reading"];
                $meal = substr($entry["mealtime"], -1);
            }
            elseif ($entry["mealtime"] === "AB" ||
                    $entry["mealtime"] === "AL" ||
                    $entry["mealtime"] === "AD")
            {
                if (substr($entry["mealtime"], -1) === $meal && 
                    $entry["reading"]              !== "--" && 
                    $beforeMeal                    !== "--")
                {
                    $bgSpan = $entry["reading"] - $beforeMeal;
                    
                    if ($bgSpan > 40)
                    {
                        $bgLevel = "bgHigh";
                        $bgAlert .= " S";
                    }
                }
            }
?>

            <tr class="<?= $entry['mealtime'] . " " . $bgLevel ?>">
                <td><?= $entry["time"] ?></td>
                <td><?= $entry["mealtime"] ?></td>
                <td><?= $entry["reading"] . $bgAlert ?></td>
            </tr>

            <?php endforeach ?>

            <tr class="ALL">
                <td colspan="2">Average</td>
                <td><?= $bgDailyAvg ?></td>
            </tr>

        </tbody>
    </table>
    <?php endforeach ?>

</div>

<div class="twoCols">
    <h2>Averages</h2>

    <table>
        <caption><h3>By Mealtime</h3></caption>
        <thead>
            <tr>
                <th>Mealtime</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($bgMealtimeAvgs as $bgMealtimeAvg => $value): ?>
<?
            $bgLevel = "";
            $bgAlert = "";            
            
            if ($value < 70 && $value !== "--")
            {
                $bgLevel = "bgLow";
                $bgAlert = " L";
            }
            elseif ($value >= 140 || ($value >= 110 && 
                                        ($value == 'F'  || 
                                         $value == "BB" || 
                                         $value == "BL" || 
                                         $value == "BD")))
            {
                $bgLevel = "bgHigh";
                $bgAlert = " H";
            }
            
?>

            <tr class="<?= $bgMealtimeAvg . " " . $bgLevel ?>">
                <td><?= $bgMealtimeAvg ?></td>
                <td><?= $value . $bgAlert ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>


    <table>
        <caption><h3>By Meal</h3></caption>
        <thead>
            <tr>
                <th>Meal</th>
                <th>Avg Span</th>
            </tr>
        </thead>
        <tbody>

<?php
            $beforeMeal;
            $meal;
            $bgSpan;
            
            foreach ($bgMealtimeAvgs as $bgMealtimeAvg => $value): ?>
<?
            
            $bgLevel = "";
            $bgAlert = "";

            if ($bgMealtimeAvg === "BB" ||
                 $bgMealtimeAvg === "BL" ||
                 $bgMealtimeAvg === "BD")
            {
                $beforeMeal = $value;
                $meal = substr($bgMealtimeAvg, -1);
            }
            elseif ($bgMealtimeAvg === "AB" ||
                    $bgMealtimeAvg === "AL" ||
                    $bgMealtimeAvg === "AD")
            {
                if ($value  === "--" || $beforeMeal == "--")
                {
                    $bgSpan = "--";
                }
                else
                {
                    $bgSpan = $value - $beforeMeal;
                    
                    if ($bgSpan > 40)
                    {
                        $bgLevel = "bgHigh";
                        $bgAlert = " S";
                    }
                }
?>

                <tr class="<?= $bgMealtimeAvg . " " . $bgLevel ?>">
                    <td><?= $meal ?></td>
                    <td><?= $bgSpan . $bgAlert ?></td>
                </tr>

<?
            }
?>            
            

            <?php endforeach ?>
        </tbody>
    </table>




</div>
