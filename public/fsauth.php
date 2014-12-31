<?php

    /***************************************\
    *                                       *
    * fsauth.php                            *
    *                                       *
    * Computer Science 50                   *
    * Final Project                         *
    *                                       *
    * Enable auto FatSecret authentication. *
    *                                       *
    \***************************************/

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // get FatSecret access token
        $fsVerifier = $_POST['fsVerifier'];
        
        $auth = $FS->ProfileGetAccessToken($fsVerifier);

        $token = $auth[OAuthBase::OAUTH_TOKEN];
        $secret = $auth[OAuthBase::OAUTH_TOKEN_SECRET];
        $id = $_SESSION['id'];
        // add FatSecret Access Token and Access Token Secret to user record
        $stat = query("UPDATE users SET token = ?, secret = ? WHERE id = ?", $token, $secret, $id);

    print "stat {" . sizeof($stat) . "}<br/>";
    var_dump($stat);

        // query database for user
        $users = query("SELECT * FROM users WHERE username = ?", $username);
        // first (and only) row
        $user = $users[0];
        // log the user in, and remember that user is now logged in by storing
        //   user's ID (and all other pertinent info) in _SESSION
        $_SESSION['id']          = $user['id'];
        $_SESSION['username']    = $username;
        $_SESSION['firstName']   = $user['firstName'];
        $_SESSION['lastName']    = $user['lastName'];
        $_SESSION['token']       = (string)$token;
        $_SESSION['secret']      = (string)$secret;
        $_SESSION['carbRatio']   = $user['carbRatio'];
        $_SESSION['sensitivity'] = $user['sensitivity'];
        $_SESSION['bgTargetMin'] = $user['bgTargetMin'];
        $_SESSION['bgTargetMax'] = $user['bgTargetMax'];

        $_SESSION['token'] = $token;
        $_SESSION['secret'] = $secret;

        // un-comment for debugging
        var_dump($stat);
        exit;

        redirect("/");
    }
    // else render form
    else
    {
        // $url = "";
        $url = $FS->ProfileBuildUserAuthURL();

        render(makeUserTitle("Enter", false, "FatSecret verification code"),
               "fsauth_form.php", [ 'url' => $url ], true);
    }

?>
