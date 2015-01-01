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

        var graph = new google.visualization.DataTable();
        graph.addColumn('string', 'X');
        graph.addColumn('number', 'Weight');

        // break out and add a PHP string in here
    <?php
        $rawData = load_weightLog();

        $graphData = "";

        for ($idx = 0; $idx < sizeof($rawData) ; $idx++)
        {
            $graphData .= '[\'' . $rawData[$idx]['date'] . '\',' . $rawData[$idx]['weight'] . '],';
        }

    ?>
        graph.addRows([<?= $graphData ?>]);

        var options = {
            title: 'Weight',
            legend: { position: 'none' },
            colors:['red','#004411'],
            width: 1000,
            height: 563,
            hAxis: { title: 'Date' },
            vAxis: { title: 'lb.' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(graph, options);

    }

</script>
<div class="center">
    <div id="chart_div"></div>
</div>
