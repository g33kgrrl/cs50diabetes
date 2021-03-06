<?php

    /*******************************\
    *                               *
    * weightlog_form.php            *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the Weight Log screen.*
    *                               *
    \*******************************/

?>

    <h2><?=$title?></h2>

    <table class="bg">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
            </tr>
        </thead>
        <tbody>

    <?php foreach ($weightLog as $entry): ?>

            <tr class="R">
                <td><?= $entry["date"] ?></td>
                <td><?= number_format($entry["weight"], 1)?></td>
            </tr>

            <?php endforeach ?>

        </tbody>
    </table>
    <div class="medred">
        <a href="weightgraph.php">Graph It!</a>
    </div>
