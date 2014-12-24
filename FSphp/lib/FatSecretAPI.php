<?php

class FatSecretAPI
{

    /* Private Data */
    private $_consumerKey;
    private $_consumerSecret;

        /* Constructors */	
    function FatSecretAPI($consumerKey, $consumerSecret)
    {
        $this->_consumerKey = $consumerKey;
        $this->_consumerSecret = $consumerSecret;
        return $this;
    }

    /* Properties */
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

    function DateInt($time)
    {
        return floor($time / 3600 / 24);
    }

    /* Public Methods */
    /* Create a new profile with a user specified ID
    * @param userID {string} Your ID for the newly created profile (set to null if you are not using your own IDs)
    * @param token {string} The token for the newly created profile is returned here
    * @param secret {string} The secret for the newly created profile is returned here
    */
    function ProfileCreate($userID, &$token, &$secret)
    {
        $url = API_REST . 'method=profile.create';
        
        if(!empty($userID))
            $url = $url . '&user_id=' . $userID;

        $oauth = new OAuthBase();

        $nReqUrl;
        $nReqParams;

        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                null, null, $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

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
        
        $nReqUrl;
        $nReqParams;
        
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                null, null, $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

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
        
        $nReqUrl;
        $nReqParams;
        
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $auth['token'], $auth['secret'],
                                $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);
                        
        $sessionKey = $doc->session_key;
    }

    // Get Weight Entries
    function WeightGetMonth()
    {
//      $url = API_REST . 'method=weights.get_month';
        $url = API_REST . 'method=foods.get_recently_eaten';
        
//      $token = $_SESSION['token'];
//      $secret = $_SESSION['secret'];
        $username = $_SESSION['username'];
        $token;
        $secret;
	try {
            $this->ProfileGetAuth($username, $token, $secret);
	}
	catch(FatSecretException $ex) {
            apologize("Unable to get FS authorization for " . $username . "! "
                    . "Error: " . $ex->getCode() . " - " . $ex->getMessage(), $url);
	}

        $oauth = new OAuthBase();

        $nReqUrl;
        $nReqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $token, $secret, $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$nReqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

print 'query response';
var_dump($rsp);

        $doc = new SimpleXMLElement($rsp);
        $this->ErrorCheck($doc);

print 'weight log';
var_dump($doc);
exit;

        return $doc;
    }

    // Get Food Entries
    function FoodEntriesGet($foodlog)
    {
        $url = API_REST . 'method=food_entries.get&date=16424';

        $token = $_SESSION['token'];
        $secret = $_SESSION['secret'];

        $oauth = new OAuthBase();

        $nReqUrl;
        $nReqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $token, $secret, $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$nReqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

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

        $nReqUrl;
        $nReqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                null, null, $nReqUrl, $nReqParams);
//                              $token, $secret, $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$nReqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

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

        $nReqUrl;
        $nReqParams;
        $signature = $oauth->GenerateSignature($url,
                                $this->_consumerKey, $this->_consumerSecret,
                                $token, $secret, $nReqUrl, $nReqParams);

        $prm = (string)$nReqParams . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature);
$this->DisplayString("query",$nReqUrl . '?' . $prm);
        $rsp = $this->GetQueryResponse($nReqUrl, $prm);

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
    
    private function ErrorCheck($doc){
        if($doc->getName() == 'error')
        {
            throw new FatSecretException((int)$doc->code, $doc->message);
        }
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
    static public $OAUTH_VERSION_NUMBER = '1.0';
    static public $OAUTH_PARAMETER_PREFIX = 'oauth_';
    static public $XOAUTH_PARAMETER_PREFIX = 'xoauth_';
    static public $PEN_SOCIAL_PARAMETER_PREFIX = 'opensocial_';

    static public $OAUTH_CONSUMER_KEY = 'oauth_consumer_key';
    static public $OAUTH_CALLBACK = 'oauth_callback';
    static public $OAUTH_VERSION = 'oauth_version';
    static public $OAUTH_SIGNATURE_METHOD = 'oauth_signature_method';
    static public $OAUTH_SIGNATURE = 'oauth_signature';
    static public $OAUTH_TIMESTAMP = 'oauth_timestamp';
    static public $OAUTH_NONCE = 'oauth_nonce';
    static public $OAUTH_TOKEN = 'oauth_token';
    static public $OAUTH_TOKEN_SECRET = 'oauth_token_secret';
    
    protected $unreservedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.~';
    
    function GenerateSignature($url, $cKey, $cSecret, $uToken, $uSecret, &$nReqUrl, &$nReqParams)
    {
        $signatureBase = $this->GenerateSignatureBase($url, $cKey, $uToken, $nReqUrl, $nReqParams);
        $secretKey = $this->UrlEncode($cSecret) . '&' . $this->UrlEncode($uSecret);
        return base64_encode(hash_hmac('sha1', $signatureBase, $secretKey, true));
    }
    
    private function GenerateSignatureBase($url, $cKey, $token, &$nReqUrl, &$nReqParams){		
        $parameters = [];

        $elements = explode('?', $url);
        $parameters = $this->GetQueryParameters($elements[1]);

        $parameters[OAuthBase::$OAUTH_VERSION] = OAuthBase::$OAUTH_VERSION_NUMBER;
        $parameters[OAuthBase::$OAUTH_NONCE] = $this->GenerateNonce();
        $parameters[OAuthBase::$OAUTH_TIMESTAMP] = $this->GenerateTimeStamp();
        $parameters[OAuthBase::$OAUTH_SIGNATURE_METHOD] = 'HMAC-SHA1';
        $parameters[OAuthBase::$OAUTH_CONSUMER_KEY] = $cKey;

        if(!empty($token))
            $parameters[OAuthBase::$OAUTH_TOKEN] = $token;

        $nReqUrl = $elements[0];
        $nReqParams = $this->NormalizeRequestParameters($parameters);

        return 'POST&' . UrlEncode($nReqUrl) . '&' . UrlEncode($nReqParams);
    }
        
    private function GetQueryParameters($paramString) {
        $elements = explode('&',$paramString);
        $result = [];
        foreach ($elements as $element)
        {
            list($key,$token) = explode('=',$element);
            if($token)
                $token = urldecode($token);
            if(empty($result[$key])) {
                $result[$key] = $token;
            } else if (!is_array($result[$key])) {
                $result[$key] = [ $result[$key], $token ];
            } else {
                $result[$key][] = $token;
            }
        }

        return $result;
    }

    private function NormalizeRequestParameters($parameters) {
        $elements = [];
        ksort($parameters);

        foreach ($parameters as $paramName=>$paramValue) {
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
