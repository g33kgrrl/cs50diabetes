<?php

    // configuration
    require("../includes/config.php"); 

    // Retrieve entire portfolio for this user from _SESSION
    $history = read_history($_SESSION['id']);

    // Go through entire user history to count total volume
    //   and calculate total value
    $total_shares = 0;
    $net_volume = 0;
    $idx = 0;
    foreach ($history as $transaction)
    {
        $shares = $transaction['shares'];
        $price  = $transaction['price'];
        // Update total shares
        $total_shares += $shares;
        // Calculate total value of this transaction
        $value = $shares * $price;
        if ($transaction['action'] == 'BUY')
        {
            $value = -$value;
        }

        // Update total value of portfolio
        $net_volume += $value;
        
        $history[$idx]['value'] = $value;
        $idx++;
    }

    // render portfolio
    render(makeusertitle(null,false,"History", "history_disp.php",
           [ 'history'      => $history,
             'net_volume'   => $net_volume,
             'total_shares' => $total_shares ] );

?>
