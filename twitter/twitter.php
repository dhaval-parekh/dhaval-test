<?php
require_once('config.php');
use Abraham\TwitterOAuth\TwitterOAuth;
/*/
$_SESSION['oauth_token']= 't_MdRQAAAAAAjeQmAAABUed56rE';
$_SESSION['oauth_token_secret']= 'OL41cl7HUNnOLci5MJ0P8LCoIA7HN89h';
$_SESSION['oauth_callback_confirmed']= 'true';
/**/
echo '<pre>';
	print_r($_POST);
	print_r($_GET);
	print_r($_SESSION);
echo '</pre>';
$request_token = $_SESSION;
if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    // Abort! Something is wrong.
    
    die('Something Wrong Goto : login.php');
}

// We've got everything we need

// TwitterOAuth instance, with two new parameters we got in twitter_login.php
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
echo '<pre>'; print_r($access_token); echo '</pre>';
$_SESSION['access_token'] = $access_token;


// Third Step
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$user = $connection->get("account/verify_credentials");
$_SESSION['twitter_user'] = $user;
echo '<pre>'; print_r($user); echo '</pre>';

echo '<h1>Get Twitter</h1>';
$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => 'wostest2dh', 'count' => 1));

echo '<div class="twitter-bubble">';
if(isset($my_tweets->errors))
{          
    echo 'Error :'. $my_tweets->errors[0]->code. ' - '. $my_tweets->errors[0]->message;
}else{
    echo makeClickableLinks($my_tweets[0]->text);
}
echo '</div>';

//function to convert text url into links.
function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target="blank" rel="nofollow" href="$1" target="_blank">$1</a>', $s);
}