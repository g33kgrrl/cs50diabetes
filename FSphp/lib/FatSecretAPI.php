<?php

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
        return floor($time / 3600 / 24);
    }

    // Display apology graphic and message, plus FS error information
    //   @param msg {string} Apology message
    //   @param ex {FatSecretException} Error structure from FatSecret API
    //   @param url {string} Url to continue to when user clicks through the error
    function Apologize($msg,$ex,$url)
    {
        apologize($msg . " Error: " . $ex->getCode() . " - " . $ex->getMessage(), $url);
    }

    // Create a new profile with a user specified ID
    //   @param userID {string} Your ID for the newly created profile (set to null if you are not using your own IDs)
    //   @param token {string} The token for the newly created profile is returned here
    //   @param secret {string} The secret for the newly created profile is returned here
    function ProfileCreate($userID, &$token, &$secret)
    {
        $url = API_REST . 'method=profile.create';
        
        if(!empty($userID))
            $url = $url . '&user_id=' . $userID;

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                null, null, $reqUrl, $reqParams);

        $prm = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        $rsp = $this->GetQueryResponse($reqUrl, $prm);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);

        $token = $doc->auth_token;
        $secret = $doc->auth_secret;
    }
        
    /* Get the auth details of a profile
    * @param userID {string} Your ID for the profile
    * @param token {string} The token for the profile is returned here
    * @param secret {string} The secret for the profile is returned here
    */
    function ProfileGetAuth($userID, &$token, &$secret)
    {
        $url = API_REST . 'method=profile.get_auth&user_id=' . $userID;
        
        $oauth = new OAuthBase();
        
        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                null, null, $reqUrl, $reqParams);

        $prm = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        $rsp = $this->GetQueryResponse($reqUrl, $prm);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);
        
        $token = $doc->auth_token;
        $secret = $doc->auth_secret;
    }
        
    /* Create a new session for JavaScript API users
    * @param auth {array} Pass user_id for your own ID or the token and secret for the profile. E.G.: array(user_id=>"user_id") or array(token=>"token", secret=>"secret")
    * @param expires {int} The number of minutes before a session is expired after it is first started. Set this to 0 to never expire the session. (Set to any value less than 0 for default)
    * @param consumeWithin {int} The number of minutes to start using a session after it is first issued. (Set to any value less than 0 for default)
    * @param permittedReferrerRegex {string} A domain restriction for the session. (Set to null if you do not need this)
    * @param cookie {bool} The desired session_key format
    * @param sessionKey {string} The session key for the newly created session is returned here
    */
    function ProfileRequestScriptSessionKey($auth, $expires, $consumeWithin, $permittedReferrerRegex, $cookie, &$sessionKey)
    {
        $url = API_REST . 'method=profile.request_script_session_key';
        
        if(!empty($auth['user_id']))
                $url = $url . '&user_id=' . $auth['user_id'];
        
        if($expires > -1)
                $url = $url . '&expires=' . $expires;

        if($consumeWithin > -1)
                $url = $url . '&consume_within=' . $consumeWithin;

        if(!empty($permittedReferrerRegex))
                $url = $url . '&permitted_referrer_regex=' . $permittedReferrerRegex;

        if($cookie == true)
                $url = $url . "&cookie=true";
                
        $oauth = new OAuthBase();
        
        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $auth['token'], $auth['secret'],
                                $reqUrl, $reqParams);

        $prm = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        $rsp = $this->GetQueryResponse($reqUrl, $prm);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);
                        
        $sessionKey = $doc->session_key;
    }

    // Get Weight Entries
    function WeightGetMonth()
    {
        $url = API_REST . 'method=weights.get_month';
        
        $token = $_SESSION['token'];
        $secret = $_SESSION['secret'];

        $oauth = new OAuthBase();

/*
        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $token, $secret, $reqUrl, $reqParams);
        $reqParams = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$reqUrl . '?' . $reqParams);
*/

        $reqParams = $oauth->BuildRequestParams($url, $this->_consumerKey, $this->_consumerSecret, $token, $secret, $reqUrl);
$this->DisplayString("query",$reqUrl . '?' . $reqParams);

        $response = $this->GetQueryResponse($reqUrl, $reqParams);
print 'query response';
var_dump($response);

        $result = new SimpleXMLElement($response);
        $this->ErrorCheck($result);
print 'weight log';
var_dump($result);
exit;

        return $result;
    }

    // Get Food Entries
    function FoodEntriesGet($foodlog)
    {
        $url = API_REST . 'method=food_entries.get&date=16424';

        $token = $_SESSION['token'];
        $secret = $_SESSION['secret'];

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $token, $secret, $reqUrl, $reqParams);

        $prm = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$reqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($reqUrl, $prm);

print 'query response';
var_dump($rsp);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);

print "Food Log";
var_dump($doc);
print "code=" . ord(substr((string)$doc,0,1));
exit;

        return $doc;
    }

    // Search Food Database
    function SearchFood($searchStr)
    {
        $url = API_REST . "method=foods.search&max_results=50&search_expression=\"" . urlencode($searchStr) . '"';

        $token = $_SESSION['token'];
        $secret = $_SESSION['secret'];

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                null, null, $reqUrl, $reqParams);
//                              $token, $secret, $reqUrl, $reqParams);

        $prm = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$reqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($reqUrl, $prm);

print 'query response';
var_dump($rsp);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);

print "Food Sesarch: " . $searchStr;
var_dump($doc);
print "code=" . ord(substr((string)$doc,-1));
exit;

        return $doc;
    }

    // Search Food Database
    function FoodRecentlyEaten($meal)
    {
        $url = API_REST . "method=foods.get_recently_eaten";

        if ($meal !== null)
            $url = $url . '&meal="' . $meal . '"';

        $token = $_SESSION['token'];
        $secret = $_SESSION['secret'];

        $oauth = new OAuthBase();

        $reqUrl;
        $reqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $token, $secret, $reqUrl, $reqParams);

        $prm = (string)$reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$reqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($reqUrl, $prm);

print 'query response';
var_dump($rsp);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);

print "Food Sesarch: " . $meal;
var_dump($doc);
print "code=" . ord(substr((string)$doc,-1));
exit;

        return $doc;
    }

    /* Private Methods */
    private function DisplayString($name,$str) {
        print $name . '="' . $str . '" (' . strlen($str) . ')<br/>';
    }

    private function GetQueryResponse($requestUrl, $postString) {
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

/* OAuth */
class OAuthBase
{
    /* OAuth Parameters */
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
    
    protected $unreservedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.~';
    
    function BuildRequestParams($url, $cKey, $cSecret, $uToken, $uSecret, &$reqUrl)
    {
        $reqParams;
        $signature = $this->GenerateSignature($url,
                                $cKey, $cSecret, $uToken, $uSecret, $reqUrl, $reqParams);
        $reqParams = $reqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        return $reqParams;
    }

    function GenerateSignature($url, $cKey, $cSecret, $uToken, $uSecret, &$reqUrl, &$reqParams)
    {
        $signatureBase = $this->GenerateSignatureBase($url, $cKey, $uToken, $reqUrl, $reqParams);
        $secretKey = $this->UrlEncode($cSecret) . '&' . $this->UrlEncode($uSecret);
        return base64_encode(hash_hmac('sha1', $signatureBase, $secretKey, true));
    }
    
    private function GenerateSignatureBase($url, $cKey, $token, &$reqUrl, &$reqParams){		
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

    private function GetQueryParameters($paramString)
    {
        $elements = explode('&',$paramString);
        $result = [];
        foreach ($elements as $element)
        {
            list($key,$token) = explode('=',$element);
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

    private function NormalizeRequestParameters($parameters) {
        ksort($parameters);

        $elements = [];
        foreach ($parameters as $paramName=>$paramValue)
        {
            $elements[] = $this->UrlEncode($paramName) . '=' . $this->UrlEncode($paramValue);
        }
        return implode('&',$elements);
    }
        
    private function UrlEncode($string) {
        $string = urlencode($string);
        $string = str_replace('+','%20',$string);
        $string = str_replace('!','%21',$string);
        $string = str_replace('*','%2A',$string);
        $string = str_replace('\'','%27',$string);
        $string = str_replace('(','%28',$string);
        $string = str_replace(')','%29',$string);
        return $string;
    }

        private function GenerateTimeStamp(){
        	return time();
        }
        
        private function GenerateNonce(){
        	return md5(uniqid());
        }
}

?>
