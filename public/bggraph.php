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

    render(makeUserTitle("Graph", false, "BG"), "bggraph_disp.php", [], true);
?>
