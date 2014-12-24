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
        <title>Example 1 - Create a new profile</title>
    </head>
    <body>
		<h1>Example 1</h1>
		<div>
			<b>Create a new profile using ProfileCreate</b>
		</div>
		<?php
			try{
				$API->ProfileCreate(null, $token, $secret);

				print '<div>auth_token: ' . $token . '</div>';
				print '<div>auth_secret: ' . $secret . '</div>';
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