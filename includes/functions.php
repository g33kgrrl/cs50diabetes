<?php

    /*******************************\
    *                               *
    * functions.php                 *
    *                               *
    * Computer Science 50           *
    * Problem Set 7                 *
    *                               *
    * Helper functions.             *
    *                               *
    \*******************************/

    require_once("constants.php");

    // Store a temporary value in $_SESSION
    function store($element, $value)
    {
        $idx = '_temp_' . $element;
        $_SESSION[$idx] = $value;
    }

    // Retrieve a temporary value from $_SESSION, and remove it
    function retrieve($element)
    {
        $idx = '_temp_' . $element;
        $value = $_SESSION[$idx];
        unset($_SESSION[$idx]);
        return $value;
    }

    // Apologizes to user with message.
    function apologize($message, $againurl=null)
    {
        if ($againurl === null)
        {
            render(null, "apology.php", [ "message" => $message ] );
        }
        else
        {
            render(null, "apology.php", [ "message" => $message ],
                         $againurl, "Try Again");
        }
        exit;
    }

    // Facilitates debugging by dumping contents of variable to display
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    // Logs out current user, if any.  Based on Example #1 at
    //   http://us.php.net/manual/en/function.session-destroy.php.
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    // Returns a stock by symbol (case-insensitively) else false if not found.
    function lookup($symbol)
    {
        // reject symbols that start with ^
        if (preg_match("/^\^/", $symbol))
        {
            return false;
        }

        // reject symbols that contain commas
        if (preg_match("/,/", $symbol))
        {
            return false;
        }

        // open connection to Yahoo
        $handle = @fopen("http://download.finance.yahoo.com/d/" .
                         "quotes.csv?f=snl1&s=$symbol", 'r');
        if ($handle === false)
        {
            // trigger (big, orange) error
            trigger_error("Could not connect to Yahoo!", E_USER_ERROR);
            exit;
        }

        // download first line of CSV file
        $data = fgetcsv($handle);
        if ($data === false  ||  count($data) == 1)
        {
            return false;
        }

        // close connection to Yahoo
        fclose($handle);

        // ensure symbol was found
        if ($data[2] === "0.00")
        {
            return false;
        }

        // return stock as an associative array
        return [ "symbol" => $data[0],
                 "name"   => $data[1],
                 "price"  => $data[2] ];
    }


    // Returns a the CURRENT price of a stock (by symbol)
    function getprice($symbol)
    {
        $s = lookup($symbol);
        if ($s === false)
        {
            apologize("($symbol) is NOT a valid stock symbol!");
        }
        return $s['price'];
    }

    // Executes SQL statement, possibly with parameters, returning
    //   an array of all rows in result set or false on (non-fatal) error.
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" .
                                  SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed
                //   invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    // Redirects user to destination, which can be a URL or a relative path on
    //   the local host.
    // Because this function outputs an HTTP header, it must be called before
    //   caller outputs any HTML.
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    // Renders template, passing in values.
    function render($title, $template, $values = [], $link=null, $linkmsg=null)
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render middle (i.e., body)
            print "<div id=\"middle\">\n";
            // render template
            require("../templates/$template");
            // render link, if specified
            if ($link !== null)
            {
                if ($linkmsg === null)
                {
                    $linkmsg = $link;
                }
                print "  <br/>\n";
                print "  <p class=\"medium\">\n";
                print "    <a href=\"$link\">$linkmsg</a>\n";
                print "  </p>\n";
                print "  <br/>\n";
            }
            print "</div>\n";

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

    // Reads a user's full portfolio
    function read_portfolio($id)
    {
        // Query database for user
        $stocks = query("SELECT * FROM portfolio WHERE id = ?", $id);
        $portfolio = [];
        foreach ($stocks as $stock)
        {
            $s = lookup($stock['symbol']);
            if ($s === false)
            {
                apologize($stock['symbol'] . " is NOT a valid stock symbol!");
            }
            $portfolio[] = [ 'symbol' => $s['symbol'],
                             'name'   => $s['name'],
                             'shares' => $stock['shares'] ];
        }
        return $portfolio;
    }

    // Write a record to the history
    function log_entry($id, $action, $sym, $shares, $price, $failurl)
    {
        // Update the SQL database
        $stat = query("INSERT INTO history " .
                      "(id, action, symbol, shares, price) " .
                      "VALUES(?, ?, ?, ?, ?)",
                      $id, $action, $sym, $shares, $price);
        if ($stat === false)
        {
            apologize("Log Entry Failed!", $failurl);
        }
        return true;
    }

    // Read history log for user
    function read_history($id)
    {
        $h = query("SELECT * FROM history WHERE id = ?", $id);
        if ($h === false)
        {
            $h = [];
        }
        return $h;
    }

    /**
     * Fetch user's blood glucose log and load into array.
     */
    function load_bgLog()
    {
        $bgLog = [];
        
        $entries = query("SELECT * FROM bglog WHERE id = ?", $_SESSION["id"]);
    
        foreach ($entries as $entry)
        {       
            $phpTimestamp = strtotime($entry["timestamp"]);
            
            $testDate = date("m-d-y", $phpTimestamp);
            
            $bgLog[$testDate][] = [
                "dbTimestamp" => $entry["timestamp"],
                "phpTimestamp" => $phpTimestamp,
                "date" => $testDate,
                "time" => date("g:i a", $phpTimestamp),
                "mealtime" => $entry["mealtime"],
                "reading" => $entry["reading"],                
            ];
        }   
                        
        return $bgLog;
    }

    /**
     * Calculate user's daily average blood glucose
     */
    function load_bgDailyAvg($entries)
    {           
        $bgDailyAvg = array_sum(array_column($entries, 'reading'));
        
        $bgDailyAvg = round($bgDailyAvg/count($entries));
                        
        return $bgDailyAvg;
    }
    
    /**
     * Calculate user's average blood glucose at each mealtime
     */
    function load_bgMealtimeAvgs()
    {           
        $bgMealtimeAvgs = [];
        $entries = [];
        $mealtimes = ['F', 'BB', 'AB', 'BL', 'AL', 'BD', 'AD', 'R'];
        
        foreach ($mealtimes as $mealtime)
        {
            $entries = query("SELECT reading FROM bglog WHERE id = ? AND mealtime = ?", $_SESSION["id"], $mealtime);
            
            $bgMealtimeAvg = array_sum(array_column($entries, 'reading'));
        
            $bgMealtimeAvg = round($bgMealtimeAvg/count($entries));                 
            
            $bgMealtimeAvgs[$mealtime] = $bgMealtimeAvg;
        }
        
        $bgMealtimeAvgs['ALL'] = round((array_sum($bgMealtimeAvgs)/count($bgMealtimeAvgs)));
                 
        return $bgMealtimeAvgs;
    }
    
    
?>