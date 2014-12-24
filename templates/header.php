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
        <div class="container"><br/>
            <div id="top" class="bigblue">
                <a href="/"><?=APPLICATION?></a><br/>
            </div>
<?php
    if (!empty($_SESSION['id']))
    {
        if ($suppressFS === false)
        {
?>
            <div style="width: 560px; margin: 0 auto; float: right;">
                <script src="<?=API_LOAD?>key=<?=API_KEY?>&amp;auto_load=true&amp;theme=blue_small"></script>
            </div>
<?php
        }
    }
?>
