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

            <?php foreach ($entries as $entry): ?>
            
<?
            $bgLevel = "";
            $bgAlert = "";            
            
            if ($entry["reading"] < 70)
            {
                $bgLevel = "bgLow";
                $bgAlert = " LOW";
            }
            elseif ($entry["reading"] >= 140 || ($entry["reading"] >= 110 && ($entry["mealtime"] == 'F' || $entry["mealtime"] == "BB" || $entry["mealtime"] == "BL" || $entry["mealtime"] == "BD")))
            {
                $bgLevel = "bgHigh";
                $bgAlert = " HIGH";
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
    <h2>Analysis</h2>

    <table>
        <caption><h3>Averages</h3></caption>
        <thead>
            <tr>
                <th>Mealtime</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($bgMealtimeAvgs as $bgMealtimeAvg => $value): ?>

            <tr class="<?= $bgMealtimeAvg ?>">
                <td><?= $bgMealtimeAvg ?></td>
                <td><?= $value ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
