<!DOCTYPE html>


<html lang="en">

    <head>

        <meta charset="utf-8"/>
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)) { ?>
            <title>C$50 Finance: <?=htmlspecialchars($title)?></title>
        <?php } else { ?>
            <title>C$50 Finance</title>
        <?php } ?>

        <script src="/js/jquery-1.10.2.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>

    </head>

    <body>
        <div class="container">
            <div id="top">
                <a href="/"><img alt="CS50 Diabetes" src="/img/logo.gif"/></a>
            </div>
            <!-- <div style="width:500px;margin:0 auto;float:right;">
                <script src="http://platform.fatsecret.com/js?key=caf512af2ef74757be53df253b10601d&auto_load=true"></script>
            </div> -->
