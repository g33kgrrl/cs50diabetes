<?php
    require_once('../lib/FatSecretAPI.php');
	require_once('../lib/config.php');
	
	$API = new FatSecretAPI(API_KEY, API_SECRET);
	
	$token;
	$secret;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Example 2 - Create a new profile with user_id 'test@example.com'</title>
    </head>
    <body>
		<h1>Example 2</h1>
		<div>
			<b>Create a new profile with user_id 'test@example.com' using ProfileCreate</b>
		</div>
		<?php
			try{
				$API->ProfileCreate('test@example.com', $token, $secret);
				
				print '<div>Success</div>';
			}
			catch(Exception $ex)
			{
				print '<div>Error: ' . $ex->getCode() . ' - ' . $ex->getMessage() . '</div>';
			}
		?>
		<br />
		<div>
			<b>Get the auth details for profile with user_id 'test@example.com' using ProfileGetAuth</b>
		</div>
		<?php
			try{
				$API->ProfileGetAuth('test@example.com', $token2, $secret2);
				print '<div>auth_token: ' . $token2 . '</div>';
				print '<div>auth_token: ' . $secret2 . '</div>';
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