<!DOCTYPE html>

<?php
    // configuration
    require("../includes/config.php"); 
    $weightlog;
    try {
        $weightlog = $API->WeightGetMonth();
    }
    catch(FatSecretException $ex) {
        apologize("Unable to get FS weight log!  "
                . "Error: " . $ex->getCode() . " - " . $ex->getMessage());
    }
?>

<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Weight Log</title>
    </head>

    <body>
        <h1>Weight Log</h1>
        <pre><?php var_dump($weightlog); ?></pre>
        <a href="javascript:history.go(-1);">Back</a>
    </body>

</html>
