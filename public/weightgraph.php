<?php

    /*******************************\
    *                               *
    * weightgraph.php               *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Show the Weight graph.        *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    render(makeUserTitle("Graph", false, "Weight"), "weightgraph_disp.php", [], true);
?>
