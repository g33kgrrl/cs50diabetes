<?php

    /*******************************\
    *                               *
    * mainmenu.php                  *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Renders the main menu.        *
    *                               *
    \*******************************/

?>

<div>
    <h2><?=$title?></h2>

    <table class="mainMenu">

        <caption>Main Menu</caption>
        <tr>
            <td class="menuentry center"><a href="bg.php"><img src="/img/bg.png"><br/>Enter BG</a></td>
            <td class="menuentry center"><a href="bolus.php"><img src="/img/bolus.png"><br/>Calc. Bolus</a></td>
        </tr>
        <tr>
            <td class="menuentry center"><a href="bglog.php"><img src="/img/bglog.png"><br/>BG History</a></td>
            <td class="menuentry center"><a href="cfgbolus.php"><img src="/img/cfgbolus.png"><br/>Config. Bolus</a></td>
        </tr>

    </table>

</div>
