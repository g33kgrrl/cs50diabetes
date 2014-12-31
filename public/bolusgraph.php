<?php

    /*******************************\
    *                               *
    * bggraph.php                   *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Show the BG graph.            *
    *                               *
    \*******************************/

    // configuration
    require("../includes/config.php");

    render(makeUserTitle("Graph", false, "Boluses"), "bolusgraph_disp.php", [], true);
?>
