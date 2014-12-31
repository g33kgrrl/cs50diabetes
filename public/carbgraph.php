<?php

    /*******************************\
    *                               *
    * carbgraph.php                 *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Show the carb graph.          *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    render(makeUserTitle("Graph", false, "BG"), "carbgraph_disp.php", [], true);
?>
