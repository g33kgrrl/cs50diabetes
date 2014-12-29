<?php

    /*******************************\
    *                               *
    * constants.php                 *
    *                               *
    * Computer Science 50           *
    * Final Project                 *
    *                               *
    * Global constants.             *
    *                               *
    \*******************************/

    // your application's name
    define("APPLICATION", "CS50 Diabetes");

    // your database's name
    define("DATABASE", "project");

    // your database's password
    define("PASSWORD", "crimson");

    // your database's server
    define("SERVER", "localhost");

    // your database's username
    define("USERNAME", "jharvard");

    // Base URL for FatSecret API
    define("API_URL", "http://platform.fatsecret.com/");

    // FatSecret "Load" URL
    define("API_LOAD", API_URL . "js?");

    // FatSecret "REST" URL
    define("API_REST", API_URL . "rest/server.api?");

    // FatSecret obtain unauthorized reqest token URL
    define("API_RTOK", "http://www.fatsecret.com/oauth/request_token");

    // FatSecret obtain unauthorized reqest token URL
    define("API_ATOK", "http://www.fatsecret.com/oauth/access_token");

    // FatSecret user token authorization
    define("API_UAUTH", "http://www.fatsecret.com/oauth/authorize");

    //please register at http://platform.fatsecret.com for an API KEY 
    define("API_KEY", "caf512af2ef74757be53df253b10601d");

    //please register at http://platform.fatsecret.com for an API SECRET
    define("API_SECRET", "26dca9bdb29942a49ed69ae32d612a4c"); 

?>
