<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $symbol = $_POST['symbol'];
        $stock = lookup($symbol);
        if ($stock === false)
        {
            apologize("$symbol is NOT a valid stock symbol!", "quote.php");
        }
        if (!empty($_SESSION['id']))
        {
            $_SESSION['lastsym'] = $stock['symbol'];
        }

        // render stock quote
        render("Quote Display", "quote_disp.php", $stock);
    }
    else
    {
        // else render form
        render("Quote", "quote_form.php");
    }

?>
