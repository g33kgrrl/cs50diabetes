<?php

    /*******************************\
    *                               *
    * functions.php                 *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
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
    function apologize($message, $againurl=null, $extra=null)
    {
        $params = [ 'message' => $message ];

        if (isset($extra))
        {
            $params['extra'] = $extra;
        }

        if ($againurl === null)
        {
            render(null, "apology.php", $params );
        }
        else
        {
            render(null, "apology.php", $params, true, $againurl, "Try Again");
        }
        exit;
    }

    // Facilitates debugging by dumping contents of variable to display
    function dump($title,$variable)
    {
        require("../templates/dump.php");
        exit;
    }

    // make a noun possessive
    function possessive($str)
    {
        if (strtolower(substr($str,-1)) === 's')
            return $str . '\'';
        return $str . '\'s';
    }

    function makeUserTitle($pre,$last,$post)
    {
        $title = '';
        if ($pre !== null)
            $title = $pre . ' ';
        $name = $_SESSION['firstName'];
        if ($last === true)
            $name = $name . ' ' . $_SESSION['lastName'];
        if ($post !== null)
        {
            $title = $title . possessive($name) . ' ' . $post;
        }
        else
        {
            $title = $title . $name;
        }
        return $title;
    }

    function updateSessionUser($username,$tok=null,$sec=null)
    {
        // query database for user
        $users = query("SELECT * FROM users WHERE username = ?", $username);

        // if # of matches is NOT one, flag an error
        if (count($users) != 1)
        {
            apologize("Invalid username", $url);
        }

        // first (and only) row
        $user = $users[0];

        $token = $user['token'];
        $secret = $user['secret'];

        if (empty($token))
        {
            $token = $tok;
            $secret = $sec;
        }

        // log the user in, and remember that user is now logged in by storing
        //   user's ID (and all other pertinent info) in _SESSION
        $_SESSION['id']          = $user['id'];
        $_SESSION['username']    = $username;
        $_SESSION['firstName']   = $user['firstName'];
        $_SESSION['lastName']    = $user['lastName'];
        $_SESSION['token']       = $token;
        $_SESSION['secret']      = $secret;
        $_SESSION['carbRatio']   = $user['carbRatio'];
        $_SESSION['sensitivity'] = $user['sensitivity'];
        $_SESSION['bgTargetMin'] = $user['bgTargetMin'];
        $_SESSION['bgTargetMax'] = $user['bgTargetMax'];
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
                "dbTimestamp"  => $entry["timestamp"],
                "phpTimestamp" => $phpTimestamp,
                "date"         => $testDate,
                "time"         => date("g:i a", $phpTimestamp),
                "mealtime"     => $entry["mealtime"],
                "reading"      => $entry["reading"],
            ];
        }

        return $bgLog;
    }

    /**
     * Calculate user's daily average blood glucose
     */
    function load_bgDailyAvg($entries)
    {
        $bgDailyAvg = number_format(round(array_sum(array_column($entries, 'reading')) / count($entries), 1), 1);

        return $bgDailyAvg;
    }

    /**
     * Calculate user's average blood glucose at each mealtime
     */
    function load_bgMealtimeAvgs()
    {
        $bgMealtimeAvgs = [];
        $entries = [];
        $mealtimes = ['F', 'BB', 'AB', 'BL', 'AL', 'BD', 'AD', 'B', 'R'];

        $total = 0;
        $totcnt = 0;
        foreach ($mealtimes as $mealtime)
        {
            $entries = query("SELECT reading FROM bglog WHERE id = ? AND mealtime = ?", $_SESSION["id"], $mealtime);

            $cnt = count($entries);
            $totcnt += $cnt;
            if ($cnt === 0)
            {
                $bgMealtimeAvgs[$mealtime] = '--';
            }
            else
            {
                $sum = array_sum(array_column($entries, 'reading'));
                $total += $sum;
                $bgMealtimeAvgs[$mealtime] = number_format(round($sum / $cnt, 1), 1);
            }

        }

        if ($totcnt === 0)
        {
            $bgMealtimeAvgs['ALL'] = '--';
        }
        else
        {
            $bgMealtimeAvgs['ALL'] = number_format(round($total / $totcnt, 1), 1);
        }

        return $bgMealtimeAvgs;
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
            $hdr = $destination;
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $hdr = $protocol . '://' . $host . $destination;
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            $hdr = $protocol . '://' . $host . $path . '/' . $destination;
        }

        header("Location: " . $hdr);

        // exit immediately since we're redirecting anyway
        exit;
    }

    // Renders template, passing in values.
    function render($title, $template, $values=[], $suppressFS=false, $link=null, $linkmsg=null)
    {
        // if template does not exist, error
        if (!file_exists("../templates/$template"))
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
        // else render it
        else
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render middle (i.e., body)
            print '<div id="middle">' . "\n";
            // render template
            require("../templates/$template");
            print "</div>\n";

            // render link, if specified
            if ($link !== null)
            {
                print "<div>\n";
                if ($linkmsg === null)
                {
                    $linkmsg = $link;
                }
                print '<div><br/><p class="medium"><a href="'.$link.'">'.$linkmsg."</a></p><br/></div>\n";
            }

            // render footer
            require("../templates/footer.php");
        }

    }

?>
