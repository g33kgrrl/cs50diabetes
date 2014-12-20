<?php

    // configuration
    require("../includes/config.php"); 

    // Retrieve entire portfolio for this user from _SESSION
    $portfolio = $_SESSION['portfolio'];

    // Go through entire portfolio to count total stock
    //   and calculate total value
    $total_shares = 0;
    $net_worth = 0;
    $idx = 0;
    foreach ($portfolio as $stock)
    {
        $shares = $stock['shares'];
        $price  = getprice($stock['symbol']);
        // Update total shares
        $total_shares += $shares;
        // Calculate total value of these shares
        $value = $shares * $price;
        // Update total value of portfolio
        $net_worth += $value;
        
        // Format total value of all shares of this stock
        $portfolio[$idx]['price'] = $price;
        $portfolio[$idx]['value'] = $value;
        $idx++;
    }

    $net_worth += $_SESSION['cash'];

    // render portfolio
    render("{$_SESSION['username']}'s Portfolio", "portfolio.php",
           [ 'portfolio'    => $portfolio,
             'net_worth'    => $net_worth,
             'total_shares' => $total_shares ] );
?>
