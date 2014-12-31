<?php

/*******************************\
*                               *
* header.php                    *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* Render universal page header. *
*                               *
\*******************************/

?>

<!DOCTYPE html>
	
<html lang="en">

    <head>

        <meta charset="utf-8"/>
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)) { ?>
            <title><?=APPLICATION?>: <?=htmlspecialchars($title)?></title>
        <?php } else { ?>
            <title><?=APPLICATION?></title>
        <?php } ?>

        <script src="/js/jquery-1.10.2.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>
    </head>

    <body>
        <div class="container center">

            <?php
                if (!empty($_SESSION['id']))
                {
                    if ($suppressFS === false)
                    {
            ?>
                        <img src="/img/CS50Diabetes.png" title="CS50 Diabetes" width="400" />
                        <div class="fsDiv">
                            <script src="<?=API_LOAD?>key=<?=API_KEY?>&auto_load=true&show_loading=true&theme=blue_small"></script>
<!--                        <script src="<?=API_LOAD?>key=<?=API_KEY?>&auto_load=true&theme=blue_small"></script> -->
                        </div>
            <?php
                    }
                    else
                    {
            ?>
                        <img src="/img/CS50Diabetes.png" title="CS50 Diabetes" width="540" />
            <?php
                    }
                }
                else
                {
            ?>
                        <img src="/img/CS50Diabetes.png" title="CS50 Diabetes" />

            <?php
                }
            ?>
