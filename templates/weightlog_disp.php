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

    <?php foreach ($weightLog as $testDate => $entries): ?>

    <table class="bg">
<!--        <caption><h3><?= $testDate ?></h3></caption> -->
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
            </tr>
        </thead>
        <tbody>

            <? foreach ($entries as $entry): ?>

            <tr class="R">
                <td><?= $entry["date"] ?></td>
                <td><?= $entry["weight"]?></td>
            </tr>

            <?php endforeach ?>

        </tbody>
    </table>
    <?php endforeach ?>
    <div class="medred">
        <a href="weightgraph.php">Graph It!</a>
    </div>

</div>
