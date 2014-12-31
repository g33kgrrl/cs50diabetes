<?php

    /*******************************\
    *                               *
    * foodlog.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Display food log.             *
    *                               *
    \*******************************/

?>

<div>
    <h2><?=$title?></h2>

        <pre><?php var_dump($foodlog); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>

<?php
    foreach ($foodlog as $idx => $foodday)
    {
        $temp = $foodday->food_entry;
        foreach ($temp as $x => $element)
        {
            print $idx . "->food_entry[" . $x . "]: ";
            print "(" . sizeof($element) . ") : ";
            print_r($element);
/*
            if (is_array($element))
            {
                print "(" . sizeof($element) . ") ";
                var_dump($element);
            }
            else
            {
                print "{" . gettype($element) . "} " . $element;

                if (gettype($element) === "object")
                    var_dump($element);
            }
*/
            print "<br/>";
        }
//        print "<div>" . date("Y-m-d", $day->date_int * 60 * 60 * 24) . " : ";
//        print number_format((double)$day->weight_kg * 2.20462, 1) . " lb.";
//        if (!empty($day->weight_comment))
//            print " [" . $day->weight_comment . "]";
//        print "</div>";
    }
?>

</div>
