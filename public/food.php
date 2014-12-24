<!DOCTYPE html>

<?php
    // configuration
    require("../includes/config.php"); 
    $foodlog;
    try {
        $foodlog = $API->SearchFood("Strawberry");
    }
    catch(FatSecretException $ex) {
        apologize("Unable to get FS food most recently eaten!  "
                . "Error: " . $ex->getCode() . " - " . $ex->getMessage());
    }
?>

<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Food Entries Log</title>
    </head>

    <body>
        <h1>Food Entries Log</h1>
        <pre><?php var_dump($foodlog); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>
    </body>

</html>
