<?php

    /*******************************\
    *                               *
    * carbgraph_disp.php            *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Show the Carbs graph.         *
    *                               *
    \*******************************/

?>

<!-- Load the AJAX API -->
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>

<script type="text/javascript">

    // Load the Visualization API and the linechart package.
    google.load("visualization", "1", {packages:["corechart"]});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart()
    {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'X');
        data.addColumn('number', 'Carbohydrate Intake');

        // break out and add a PHP string in here
    <?php
        // $dailyAvgs = '["12-16-14", 120],   ["12-17-14", 110],  ["12-19-14", 168],
        //   ["12-20-14", 117],  ["12-22-14", 128],  ["12-23-14", 97]';

        $carbLog = load_carbLog();
        $dailyAvgs = "";

        foreach ($carbLog as $testDate => $entries)
        {
            $carbDailyAvg = load_carbDailyAvg($carbLog[$testDate]);
            $dailyAvgs .= '[\'' . $testDate . '\', ' . $carbDailyAvg . '], ';
        }

    ?>
        data.addRows([<?= $dailyAvgs ?>]);

        var options = {
            title: 'Carbohydrate Intake Daily Averages',
            legend: { position: 'none' },
            colors:['red','#004411'],
            width: 1000,
            height: 563,
            hAxis: { title: 'Time' },
            vAxis: { title: 'Grams' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);

    }

</script>
<div class="center">
    <div id="chart_div"></div>
</div>
