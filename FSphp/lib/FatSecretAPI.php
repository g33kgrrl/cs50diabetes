<?php

/*******************************\
*                               *
* FatSecretAPI.php              *
*                               *
* Computer Science 50           *
* Final Project                 *
*                               *
* The FatSecret API libraryy.   *
*                               *
\*******************************/

class FatSecretAPI
{

    // Private Data
    private $_consumerKey;
    private $_consumerSecret;

    // Constructors
    function FatSecretAPI($consumerKey, $consumerSecret)
    {
        $this->_consumerKey = $consumerKey;
        $this->_consumerSecret = $consumerSecret;
        return $this;
    }

    // Properties
    function GetKey()
    {
        return $this->_consumerKey;
    }

    function SetKey($consumerKey)
    {
        $this->_consumerKey = $consumerKey;
    }

    function GetSecret()
    {
        return $this->_consumerSecret;
    }

    function SetSecret($consumerSecret)
    {
        $this->_consumerSecret = $consumerSecret;
    }

    // Public Methods

    // Convert timestamp (seconds since epoch) to FS timestamp (days since epoch)
    //   @param time {timestamp} Seconds since epoch
    function DateInt($time)
    {
        return floor($time / 60 / 60 / 24);
    }

    // Display apology graphic and message, plus FS error information
    //   @param msg {string} Apology message
    //   @param ex {FatSecretException} Error structure from FatSecret API
    //   @param url {string} Url to continue to when user clicks through the error
    function Apologize($msg,$ex,$url=null)
    {
        apologize($msg, $url, "Error: " . $ex->getCode() . " - " . $ex->getMessage());
    }

    // Create a new profile with a user specified ID
    //   @param userID {string} Your ID for the newly created profile (set to null if you
    //                          are not using your own IDs)
    //   @param token {string} The token for the newly created profile is returned here
    //   @param secret {string} The secret for the newly created profile is returned here
    function ProfileCreate($userID, &$token, &$secret)
    {
        $url = API_REST . 'method=profile.create';

        if(!empty($userID))
            $url = $url . '&user_id=' . $userID;

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret, null, null, $reqUrl);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);

        $token = $result->auth_token;
        $secret = $result->auth_secret;
    }

    // Get the auth details of a profile
    //   @param userID {string} Your ID for the profile
    //   @param token {string} The token for the profile is returned here
    //   @param secret {string} The secret for the profile is returned here
    function ProfileGetAuth($userID, &$token, &$secret)
    {
        $url = API_REST . 'method=profile.get_auth&user_id=' . $userID;

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret, null, null, $reqUrl);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);

        $token = $result->auth_token;
        $secret = $result->auth_secret;
    }

    // Create a new session for JavaScript API users
    //   @param auth {array} Pass user_id for your own ID or the token and secret for the
    //      profile. E.G.: array(user_id=>"user_id") or array(token=>"token", secret=>"secret")
    //   @param expires {int} The number of minutes before a session is expired after it is
    //      first started. Set this to 0 to never expire the session. (Set to any value less than 0 for default)
    //   @param consumeWithin {int} The number of minutes to start using a session after it is
    //      first issued. (Set to any value less than 0 for default)
    //   @param permittedReferrerRegex {string} A domain restriction for the session. (Set to null if you do not need this)
    //   @param cookie {bool} The desired session_key format
    function ProfileRequestScriptSessionKey($auth, $expires=-1, $consumeWithin=-1, $permittedReferrerRegex=null, $cookie=false)
    {
        $url = API_REST . 'method=profile.request_script_session_key';

        if(!empty($auth['user_id']))
                $url = $url . '&user_id=' . $auth['user_id'];

        if($expires >= 0)
                $url = $url . '&expires=' . $expires;

        if($consumeWithin >= 0)
                $url = $url . '&consume_within=' . $consumeWithin;

        if(!empty($permittedReferrerRegex))
                $url = $url . '&permitted_referrer_regex=' . $permittedReferrerRegex;

        if($cookie == true)
                $url = $url . "&cookie=true";

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                                $auth['token'], $auth['secret'], $reqUrl); 

        $response = $this->GetQueryResponse($reqUrl, $reqParams);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);

        return $result->session_key;
    }

    // Build a User Authorization URL for the user to authorize the Request Token and get a verification code
    //   @return url {string} The User Authorization URL
    function ProfileBuildUserAuthURL()
    {
        $oauth = new OAuthBase();

        $url = API_RTOK . "?" . OAuthBase::$OAUTH_CALLBACK_OOB;

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                                null, null, $reqUrl); 

        // un-comment for debugging
        // $this->DisplayString("query",$reqUrl . '?' . $reqParams);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);

        // un-comment for debugging
        // print 'query response';
        // var_dump($response);

        $result = $oauth->GetQueryParameters($response);

        // un-comment for debugging
        // print "Get Request Token";
        // var_dump($result);

        if ($result[OAuthBase::$OAUTH_CALLBACK_CONF] !== 'true')
            apologize("OAuth callback failed to confirm");

        $token = $result[OAuthBase::$OAUTH_TOKEN];
        store("token", $token);
        $secret = $result[OAuthBase::$OAUTH_TOKEN_SECRET];
        store("secret", $secret);

        $url = API_UAUTH . "?" . OAuthBase::$OAUTH_TOKEN . "=" . $token;

        return $url;
    }

    // Get verifier from user and use to get access token and access token secret, then store in DB
    //   @param verifier {string} Verification code returned after user authorization
    //   @return result {array} An array containing the access token and access token secret
    function ProfileGetAccessToken($verifier)
    {
        $oauth = new OAuthBase();

        $url = API_ATOK . "?" . OAuthBase::$OAUTH_VERIFIER . "=" . $verifier;

        $token = retrieve("token");
        $secret = retrieve("secret");

        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                                $token, $secret, $reqUrl); 
        // un-comment for debugging
        $this->DisplayString("query",$reqUrl . '?' . $reqParams);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);
        // un-comment for debugging
        print 'query response';
        var_dump($response);

        $result = $oauth->GetQueryParameters($response);
        // un-comment for debugging
        //print "Get Access Token";
        //var_dump($result);
        //exit;

        return $result;
    }

    // Get Weight Entries
    function WeightGetMonth()
    {
        $url = API_REST . 'method=weights.get_month';

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                $_SESSION['token'], $_SESSION['secret'], $reqUrl);

        // un-comment for debugging
        $this->DisplayString("query",$reqUrl . '?' . $reqParams);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);
        // un-comment for debugging
        print 'query response';
        var_dump($response);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);
        // un-comment for debugging
        var_dump($result);
        exit;

        return $result;
    }

/*
    // Log a weigh-in
    function LogWeighIn($weight, $comment=null, $height=null, $goalWeight=null)
    {
        $url = API_REST . 'method=weight.update&weight_type=lb&current_weight_kg=' . $weight;

        if ($comment !== null)
            $url = $url . "&comment=" . $comment;

        if ($height !== null)
            $url = $url . "&height_type=inch&current_height_cm=" . $height;

        if ($goalWeight !== null)
            $url = $url . "&goal_weight_kg=" . $goalWeight;

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                                $_SESSION['token'], $_SESSION['secret'], $reqUrl);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);

        return $result;
    }
*/

    // Get Food Entries
    function FoodGetEntries($date)
    {
        $url = API_REST . 'method=food_entries.get&date=' . floor($date);

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                                $_SESSION['token'], $_SESSION['secret'], $reqUrl);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);

        return $response;
//      return $result;
    }

/*
    // Search Food Database
    function FoodRecentlyEaten($meal)
    {
        $url = API_REST . "method=foods.get_recently_eaten";

        if ($meal !== null)
            $url = $url . '&meal="' . $meal . '"';

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret,
                                                $_SESSION['token'], $_SESSION['secret'], $reqUrl);

$this->DisplayString("query",$reqUrl . '?' . $reqParams);
        $response = $this->GetQueryResponse($reqUrl, $reqParams);

print 'query response';
var_dump($response);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);

print "Food Recently Eaten: " . $meal;
var_dump($result);
print "code=" . ord(substr((string)$result,-1));
exit;

        return $result;
    }
*/

    // Private Methods
    private function DisplayString($name,$str)
    {
        print $name . '="' . $str . '" (' . strlen($str) . ')<br/>';
    }

    private function GetQueryResponse($requestUrl, $postString)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    private function ErrorCheck($doc)
    {
        if($doc->getName() == 'error')
            throw new FatSecretException((int)$doc->code, $doc->message);
    }
}

class FatSecretException extends Exception
{

    public function FatSecretException($code, $message)
    {
        parent::__construct($message, $code);
    }
}

// OAuth
class OAuthBase
{
    // OAuth Parameters
    static public $OAUTH_VERSION_NUMBER        = '1.0';
    static public $OAUTH_PARAMETER_PREFIX      = 'oauth_';
    static public $XOAUTH_PARAMETER_PREFIX     = 'xoauth_';
    static public $PEN_SOCIAL_PARAMETER_PREFIX = 'opensocial_';

    static public $OAUTH_CONSUMER_KEY     = 'oauth_consumer_key';
    static public $OAUTH_CALLBACK         = 'oauth_callback';
    static public $OAUTH_VERSION          = 'oauth_version';
    static public $OAUTH_SIGNATURE_METHOD = 'oauth_signature_method';
    static public $OAUTH_SIGNATURE        = 'oauth_signature';
    static public $OAUTH_TIMESTAMP        = 'oauth_timestamp';
    static public $OAUTH_NONCE            = 'oauth_nonce';
    static public $OAUTH_TOKEN            = 'oauth_token';
    static public $OAUTH_TOKEN_SECRET     = 'oauth_token_secret';
    static public $OAUTH_VERIFIER         = 'oauth_verifier';

    static public $OAUTH_CALLBACK_CONF    = 'oauth_callback_confirmed';
    static public $OAUTH_CALLBACK_OOB     = 'oauth_callback=oob';

    protected $unreservedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.~';

    function BuildRequestParams($url, $cKey, $cSecret, $uToken, $uSecret, &$reqUrl)
    {
        $reqParams;
        $signature = $this->GenerateSignature($url, $cKey, $cSecret, $uToken,
                                              $uSecret, $reqUrl, $reqParams);
        $reqParams = $reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        return $reqParams;
    }

    function GenerateSignature($url, $cKey, $cSecret, $uToken, $uSecret, &$reqUrl, &$reqParams)
    {
        $signatureBase = $this->GenerateSignatureBase($url, $cKey, $uToken, $reqUrl, $reqParams);
        $secretKey = $this->UrlEncode($cSecret) . '&' . $this->UrlEncode($uSecret);
        return base64_encode(hash_hmac('sha1', $signatureBase, $secretKey, true));
    }

    private function GenerateSignatureBase($url, $cKey, $token, &$reqUrl, &$reqParams)
    {
        $elements = explode('?', $url);
        $parameters = $this->GetQueryParameters($elements[1]);

        $parameters[OAuthBase::$OAUTH_VERSION]          = OAuthBase::$OAUTH_VERSION_NUMBER;
        $parameters[OAuthBase::$OAUTH_NONCE]            = $this->GenerateNonce();
        $parameters[OAuthBase::$OAUTH_TIMESTAMP]        = $this->GenerateTimeStamp();
        $parameters[OAuthBase::$OAUTH_SIGNATURE_METHOD] = 'HMAC-SHA1';
        $parameters[OAuthBase::$OAUTH_CONSUMER_KEY]     = $cKey;

        if(!empty($token))
            $parameters[OAuthBase::$OAUTH_TOKEN]        = $token;

        $reqUrl = $elements[0];
        $reqParams = $this->NormalizeRequestParameters($parameters);

        return 'POST&' . UrlEncode($reqUrl) . '&' . UrlEncode($reqParams);
    }

    function GetQueryParameters($paramString)
    {
        $elements = explode('&', $paramString);
        $result = [];
        foreach ($elements as $element)
        {
            list($key,$token) = explode('=', $element);
            if($token)
                $token = urldecode($token);
            if(empty($result[$key]))
                $result[$key] = $token;
            else if (!is_array($result[$key]))
                $result[$key] = [ $result[$key], $token ];
            else
                $result[$key][] = $token;
        }

        return $result;
    }

    private function NormalizeRequestParameters($parameters)
    {
        ksort($parameters);

        $elements = [];
        foreach ($parameters as $paramName=>$paramValue)
        {
            $elements[] = $this->UrlEncode($paramName) . '=' . $this->UrlEncode($paramValue);
        }
        return implode('&', $elements);
    }

    private function UrlEncode($string)
    {
        $string = urlencode($string);
        $string = str_replace('+', '%20', $string);
        $string = str_replace('!', '%21', $string);
        $string = str_replace('*', '%2A', $string);
        $string = str_replace('\'' ,'%27', $string);
        $string = str_replace('(', '%28', $string);
        $string = str_replace(')', '%29', $string);
        return $string;
    }

    private function GenerateTimeStamp()
    {
        return time();
    }

    private function GenerateNonce()
    {
        return md5(uniqid());
    }
}

?>
