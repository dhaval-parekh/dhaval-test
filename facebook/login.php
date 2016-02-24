<?php
require_once('config.php');




$fb = new Facebook\Facebook([
	'app_id' => FB_APP_ID,
	'app_secret' => FB_APP_SECRET,
	'default_graph_version' => FB_API_VERSION,
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'user_likes']; // Optional permissions
$loginUrl = $helper->getLoginUrl(BASE_URL.'fb-callback.php', $permissions);

//echo htmlspecialchars($loginUrl);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';