<?php

    /*******************************\
    *                               *
    * weightgraph_disp.php          *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Show the Weight graph.        *
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
        data.addColumn('number', 'Weight');

        // break out and add a PHP string in here
    <?php
        $weightLog = load_weightLog($FS);
        $weightStr = "";

        foreach ($weightLog as $testDate => $entries)
        {
            $weightStr .= '[\'' . $testDate . '\', ' . $weightLog[$testDate].weight . '], ';
        }

    ?>
        data.addRows([<?= $dailyAvgs ?>]);

        var options = {
            title: 'Weight',
            legend: { position: 'none' },
            colors:['red','#004411'],
            width: 1000,
            height: 563,
            hAxis: { title: 'Time' },
            vAxis: { title: 'lb.' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);

    }

</script>
<div class="center">
    <div id="chart_div"></div>
</div>
