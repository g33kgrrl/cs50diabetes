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
        <title>Example 4 - Setting up a session and appending to URL</title>
    </head>
    <body>
		<h1>Example 4</h1>
		<div>
			<b>Create a new session using ProfileRequestScriptSessionKey and append to URL</b>
		</div>
		<?php
			try{
				$API->ProfileRequestScriptSessionKey($auth, null, null, null, false, $sessionKey);
				print '<div>session_key: ' . $sessionKey . '</div><br />';
				print '<div style="width:500px"><script src="' . API_URL . 'key=' . API_KEY . '&auto_load=true&fatsecret_session_key=' . $sessionKey . '"></script></div>';
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