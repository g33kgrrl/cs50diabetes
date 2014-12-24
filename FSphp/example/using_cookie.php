<?php
    require_once('../lib/FatSecretAPI.php');
	require_once('../lib/config.php');
	
	$API = new FatSecretAPI(API_KEY, API_SECRET);
	
	$auth = array(user_id=>'test@example.com');
	$sessionKey;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Example 3 - Setting up a session cookie</title>
    </head>
    <body>
		<h1>Example 3</h1>
		<div>
			<b>Create a new session using ProfileRequestScriptSessionKey and set cookie</b>
		</div>
		<?php
			try{
				$API->ProfileRequestScriptSessionKey($auth, null, null, null, true, $sessionKey);
				setCookie("fatsecret_session_key", $sessionKey); 
				print '<div>session_key: ' . $sessionKey . '</div><br />';
				print '<div style="width:500px"><script src="' . API_URL . 'key=' . API_KEY . '&auto_load=true"></script></div>';
			}
			catch(FatSecretException $ex)
			{
				print '<div>Error: ' . $ex->getCode() . ' - ' . $ex->getMessage() . '</div>';
			}
		?>
		<br />
		<a href="../index.html">Back</a>
    </body>
</html>