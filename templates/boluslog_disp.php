<?php

    /*******************************\
    *                               *
    * boluslog_form.php             *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the Bolus Log screen. *
    *                               *
    \*******************************/

?>

<div class="twoCols">
    <h2><?=$title?></h2>

    <?php foreach ($bolusLog as $testDate => $entries): ?>
    <?php $bolusDailyAvg = load_bolusDailyAvg($bolusLog[$testDate]); ?>

    <table class="bg">
        <caption><h3><?=$testDate?></h3></caption>
        <thead>
            <tr>
                <th>Time</th>
                <th>Mealtime</th>
                <th>Bolus</th>
            </tr>
        </thead>
        <tbody>

<?php
            $meal = "";
?>

            <? foreach ($entries as $entry): ?>

<?php
            // check for high mealtime BG span and mark after-meal entry if too high
            if ($entry["mealtime"] === "BB" ||
                $entry["mealtime"] === "BL" ||
                $entry["mealtime"] === "BD")
            {
                $meal = substr($entry["mealtime"], -1);
            }
?>

            <tr class="<?= $entry['mealtime'] ?>">
                <td><?= $entry["time"] ?></td>
                <td><?= $entry["mealtime"] ?></td>
                <td><?= $entry["bolus"] ?></td>
            </tr>

            <?php endforeach ?>

            <tr class="ALL">
                <td colspan="2">Average</td>
                <td><?= $bolusDailyAvg ?></td>
            </tr>

        </tbody>
    </table>
    <?php endforeach ?>
    <div class="medred">
        <a href="bolusgraph.php">Graph It!</a>
    </div>

</div>

<div class="twoCols">
    <h2>Averages</h2>

    <table class="bg">
        <caption><h3>By Mealtime</h3></caption>
        <thead>
            <tr>
                <th>Mealtime</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($bolusMealtimeAvgs as $bolusMealtimeAvg => $value): ?>

            <tr class="<?= $bolusMealtimeAvg ?>">
                <td><?= $bolusMealtimeAvg ?></td>
                <td><?= $value ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="legend">
        <h4 class="center">Legend</h4>
        <p> F = Fasting</p>
        <p>BB = Before Breakfast</p>
        <p>AB = After Breakfast</p>
        <p>BL = Before Lunch</p>
        <p>AL = After Lunch</p>
        <p>BD = Before Dinner</p>
        <p>AD = After Dinner</p>
        <p> B = Bedtime</p>
        <p> R = Random</p>
    </div>
</div>
