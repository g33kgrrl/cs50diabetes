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
        
        $result = $FS->ProfileGetAccessToken($fsVerifier);

        // un-comment for debugging
        // var_dump($result);

        redirect("/");
    }
    // else render form
    else
    {
        // $url = "";
        $url = $FS->ProfileBuildUserAuthURL();

        render(makeusertitle("Enter",false,"FatSecret verification code"), "fsauth_form.php", ["url"=>$url], true);
    }

?>
