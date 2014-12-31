<?php

    /*******************************\
    *                               *
    * weightlog_form.php            *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the weight log screen.*
    *                               *
    \*******************************/

?>

<div>
    <h2><?=$title?></h2>

<?php
    foreach ($weightlog->day as $idx => $day)
    {
        print "<div class=\"medred\">" . date("Y-m-d", $day->date_int * 60 * 60 * 24) . " : ";
        print number_format((double)$day->weight_kg * 2.20462, 1) . " lb.";
        if (!empty($day->weight_comment))
            print " [" . $day->weight_comment . "]";
        print "</div>";
    }
?>

</div>
