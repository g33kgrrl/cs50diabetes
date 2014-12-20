<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Pull user id from _SESSION
        $id  = $_SESSION['id'];
        // Retrieve temporary values (idx & buy)
        $idx = retrieve('idx');
        $buy = retrieve('buy');

        // Set the URL to return to for "Try Again"
        $buyurl = "buy.php";

        // If buying a NEW stock...
        if ($idx === null)
        {
            // Retrieve stock symbol from temporary storage
            $sym   = retrieve('sym');
            $shares = 0;
            $idx = -1;
        }
        // Otherwise we're buying more of a stock we already own
        else
        {
            // Pull stock symbol out of portfolio in _SESSION
            $sym = $_SESSION['portfolio'][$idx]['symbol'];
            // Pull shares out of stock info
            $shares = $_SESSION['portfolio'][$idx]['shares'];
        }

        // Lookup stock info
        $stock = lookup($sym);
        if ($stock === false)
        {
            apologize("($sym) is NOT a valid stock symbol!", $buyurl);
        }
        // Pull symbol, name and price out of stock info
        $symbol = $stock['symbol'];
        $name   = $stock['name'];
        $price  = $stock['price'];

        // Update the SQL database
        $stat = query("INSERT INTO portfolio (id, symbol, shares)" .
                      " VALUES(?, ?, ?) ON DUPLICATE KEY" .
                      " UPDATE shares = shares + VALUES(shares)",
                      $id, $symbol, $buy);
        if ($stat === false)
        {
            apologize("Error adding stocks (confirm_buy.php) " .
                      "[$origshares vs $shares]", $buyurl);
        }

        // Update share count
        $shares += $buy;

        // If this was a NEW stock (for us)...
        if ($idx < 0)
        {
            $portfolio = $_SESSION['portfolio'];
            $count = count($portfolio);
            for ($i = $count - 1;
                    $symbol < $portfolio[$i]['symbol']  &&  $i >= 0;
                    $i--)
            {
                $portfolio[$i + 1] = $portfolio[$i];
            }
            // Add new record to portfolio in _SESSION
            $portfolio[$i + 1] = [ 'symbol' => $symbol,
                                   'name'   => $name,
                                   'shares' => $shares ];
            $_SESSION['portfolio'] = $portfolio;
        }
        else
        {
            // Update portfolio shares for this stock in _SESSION
            $_SESSION['portfolio'][$idx]['shares'] = $shares;
        }

        // Update 'cash' with the money received from sale of the stock
        $cash = $_SESSION['cash'];
        $cash -= $buy * $price;
        $stat = query("UPDATE users SET cash = ? WHERE id = ?", $cash, $id);
        if ($stat === false)
        {
            apologize("Error updating cash (confirm_buy.php)", $buyurl);
        }
        $_SESSION['cash'] = $cash;

        log_entry($id, "BUY", $symbol, $buy, $price, $buyurl);

        // Redirect to re-display the portfolio
        redirect("/");
    }

?>
