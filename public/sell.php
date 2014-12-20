<?php

    // configuration
    require('../includes/config.php');

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $idx   = $_POST['idx'];
        $sell  = $_POST['sell'];
        $stock = $_SESSION['portfolio'][$idx];

        $symbol = $stock['symbol'];
        $name   = $stock['name'];
        $shares = $stock['shares'];
        $price  = getprice($symbol);

        if (strtolower($sell) == 'all')
        {
            $sell = $shares;
        }

        // Validate number of shares to sell
        $sellurl = 'sell.php';
        if ($sell < 1)
        {
            apologize("Can't sell less than 1 share", $sellurl);
        }
        if ($sell != floor($sell))
        {
            apologize("Can't sell fractional shares", $sellurl);
        }
        if ($sell > $shares)
        {
            apologize("Can't sell more shares than you own!", $sellurl);
        }

        $valstr = '$' . number_format($sell * $price, 4);
        $prcstr = '$' . number_format($price, 4);
        $conf_msg1 = "Selling $sell share" . (($sell == 1) ? '' : 's') .
                     " of $symbol ($name)";
        $conf_msg2 = "at $prcstr each, for a total of $valstr";

        store('idx', $idx);
        store('sell', $sell);

        // else render form
        render("Confirm Sale of {$_SESSION['username']}'s Shares",
                "confirm.php",
                [ 'conf_msg1' => $conf_msg1,
                  'conf_msg2' => $conf_msg2,
                  'controller' => "confirm_sell.php" ] );

    }
    else
    {
        $portfolio = $_SESSION['portfolio'];
        $total_shares = 0;
        $total_value = 0;
        $idx = 0;
        foreach ($portfolio as $stock)
        {
            $shares = $stock['shares'];
            $total_shares += $shares;
            $price = getprice($stock['symbol']);
            $value = $shares * $price;
            $total_value += $value;
            $portfolio[$idx]['price'] = $price;
            $portfolio[$idx]['value'] = $value;
            $idx++;
        }

        // else render form
        render("Sell Shares", "sell_form.php",
               [ 'portfolio'    => $portfolio,
                 'total_value'  => $total_value,
                 'total_shares' => $total_shares ] );
    }

?>
