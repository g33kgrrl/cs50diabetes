<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Pull user id from _SESSION
        $id   = $_SESSION['id'];
        // Retrieve temporary values (idx & sell)
        $idx  = retrieve('idx');
        $sell = retrieve('sell');

        // Pull record for stock from user's portfolio in _SESSION
        $stock = $_SESSION['portfolio'][$idx];
        // Pull symbol & shares from record
        $symbol = $stock['symbol'];
        $shares = $stock['shares'];
        // Get CURRENT stock price
        $price  = getprice($symbol);

        // Set the URL to return to for "Try Again"
        $sellurl = "sell.php";

        // Subtract shares sold
        $origshares = $shares;
        $shares -= $sell;
        // If ALL shares of this stock sold, delete the record
        if ($shares == 0)
        {
            $stat = query("DELETE FROM portfolio WHERE id = ? AND symbol = ?",
                          $id, $symbol);
        }
        // Otherwise, just update the record
        else
        {
            $stat = query("UPDATE portfolio SET shares = ? WHERE id = ? " .
                          "AND symbol = ?", $shares, $id, $symbol);
        }
        if ($stat === false)
        {
            var_dump($stat);
            apologize("Error deleting stocks (confirm_sell.php) " .
                      "[$origshares vs $shares]", $sellurl);
        }

        // Update copy of portfolio in _SESSION
        // If all shares sold, delete record
        if ($shares == 0)
        {
            // Shift all stocks down in portfolio to hole left by deleted one
            $limit = count($_SESSION['portfolio']) - 1;
            for ($i = $idx; $i < $limit; $i++)
                $_SESSION['portfolio'][$i] = $_SESSION['portfolio'][$i + 1];
            // Remove the last item from the array
            unset($_SESSION['portfolio'][$limit]);
            $_SESSION['lastsym'] = $stock['symbol'];
        }
        // Otherwise update share count in record
        else
        {
            $_SESSION['portfolio'][$idx]['shares'] = $shares;
        }

        // Update 'cash' with the money received from sale of the stock
        $cash = $_SESSION['cash'];
        $cash += $sell * $price;
        $stat = query("UPDATE users SET cash = ? WHERE id = ?", $cash, $id);
        if ($stat === false)
        {
            var_dump($stat);
            apologize("Error updating cash (confirm_sell.php)", $sellurl);
        }
        $_SESSION['cash'] = $cash;

        log_entry($id, "SELL", $symbol, $sell, $price, $sellurl);

        // Redirect to re-display the portfolio
        redirect('/');
    }

?>
