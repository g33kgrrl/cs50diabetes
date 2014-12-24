<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // get blood glucose
        $bgReading = $_POST["bgReading"];
        
        // whole numbers only
        if (!preg_match("/^\d+$/", $bgReading))
        {
            apologize("\"{$bgReading}\" is not a valid reading.");
        }
        
        // $meal = $_POST["meal"];
        // TODO
        $mealtime = $_POST["mealtime"];
        
        // $bgReading = $_POST["bgReading"];
        
        /* if ($bgReading  > $cash)
        {
            apologize("Insufficient funds ($valstr) to purchase $buy " .
                      "shares of $symbol ($name) at $prcstr each", $buyurl);
        }
        
        /*
        $buy = $_POST['buy'];
        $buyurl = "bg.php";
        $count = count($_SESSION['portfolio']);

        if (isset($_POST['idx']))
        {
            $idx = $_POST['idx'];
            $type = "an existing portfolio";
            if ($idx >= $count)
            {
                $sym = $_SESSION['lastsym'];
                $type = "a remembered";
            }
            if (!empty($_POST['sym']))
            {
                apologize("Ticker symbol must NOT be specified when " .
                          "$type stock is selected",$buyurl);
            }
        }
        else
        {
            $idx = $count;
            $sym = $_POST['sym'];
        }

        if ($idx < $count)
        {
            $sym = $_SESSION['portfolio'][$idx]['symbol'];
        }
        else
        {
            if (empty($sym))
            {
                apologize("You must specifry a stock to purchase", $buyurl);
            }
            $idx = null;
        }

        $stock = lookup($sym);
        if ($stock === false)
        {
            apologize("($sym) is NOT a valid stock symbol!", $buyurl);
        }
        $cash   = $_SESSION['cash'];
        $symbol = $stock['symbol'];
        $name   = $stock['name'];
        $price  = $stock['price'];
        if ($idx == null)
        {
            $_SESSION['lastsym'] = $symbol;
        }

        if (strtolower($buy) == 'max')
        {
            $buy = floor($cash / $price);
        }
        // Validate number of shares to buy
        if ($buy < 1)
        {
            apologize("Can't buy less than 1 share", $buyurl);
        }
        if ($buy != floor($buy))
        {
            apologize("Can't buy fractional shares", $buyurl);
        }

        $value = $buy * $price;
        $prcstr = '$' . number_format($price, 4);
        $valstr = '$' . number_format($value, 4);
        if ($value > $cash)
        {
            apologize("Insufficient funds ($valstr) to purchase $buy " .
                      "shares of $symbol ($name) at $prcstr each", $buyurl);
        }

        $conf_msg1 = "Buying $buy share" . (($buy == 1) ? '' : 's') .
                     " of $symbol ($name)";
        $conf_msg2 = "at $prcstr each, for a total of $valstr";

        store('idx', $idx);
        store('buy', $buy);
        if ($idx === null)
            store('sym', $symbol);

        // Render form to confirm purchase
        render("Confirm Purchase of Shares for {$_SESSION['username']}",
               "confirm.php",
               [ 'conf_msg1' => $conf_msg1,
                 'conf_msg2' => $conf_msg2,
                 'controller' => "confirm_buy.php" ] );
                 
        */
        
        
        // add bg reading to log
        $addReading = query("INSERT INTO bglog (id, mealtime, reading) VALUES(?, ?, ?)", $_SESSION["id"], $mealtime, $bgReading);
        
        if ($addReading === false)
        {
            apologize("Could not add reading to blood glucose log.");
        }
        
        redirect("bglog.php");        
    }

    // else render form
    else
    {
        render(makeusertitle("Enter",false,"Blood Glucose"), "bg_form.php", [], true);
    }
?>
