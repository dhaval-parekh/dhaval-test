<?php
require_once('config.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$access_token = $_SESSION['access_token'] ;
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$screen_name = 'wostest2dh';
$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $screen_name));

echo '<div class="twitter-bubble">';
if(isset($my_tweets->errors))
{          
    echo 'Error :'. $my_tweets->errors[0]->code. ' - '. $my_tweets->errors[0]->message;
}else{
    echo makeClickableLinks($my_tweets[0]->text);
}
echo '</div>';

//echo '<pre>'; print_r($my_tweets); echo '</pre>';
//function to convert text url into links.
function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target="blank" rel="nofollow" href="$1" target="_blank">$1</a>', $s);
}


echo '<h4>Follower</h4>';
$followers = $connection->get('followers/ids', array('screen_name' => $screen_name)); // , 'cursor' => 9999999999
echo '<pre>'; print_r($followers); echo '</pre>';


echo '<h4>Another Twiiter<h4>';
$screen_name = 'saaraan';
$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $screen_name));
echo '<pre>'; print_r($my_tweets); echo '</pre>';