<?php

/*******************************\
*                               *
* dump.php                      *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* Dump a variable.              *
*                               *
\*******************************/

?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title><?=$title?></title>
    </head>

    <body>
        <h1><?=$title?>:</h1>
        <pre><?php print_r($variable); ?></pre>
        <br/>
        <a href="javascript:history.go(-1);">Back</a>
    </body>

</html>
