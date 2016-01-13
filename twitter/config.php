<?php
error_reporting(-1);
set_time_limit(0);
// References : https://twitteroauth.com/redirect.php
// https://twitteroauth.com/redirect.php
// https://dev.twitter.com/rest/public
require "twitteroauth/vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
session_start();

define('CONSUMER_KEY', '8Co2Ja7LNKSaQouJD93xbveKS');
define('CONSUMER_SECRET', '5f75uq96vapBGiQvsU8qyarfw2znQBTZDzCbancDoCOrXX78Mx');

define('ACCESS_TOKEN','3912902479-jwbCn5vQrIJ5FMKTCDvkRsK98t6AUpURpauuTo5');
define('ACCESS_TOKEN_SECRET','h302OJBjutaoIqyT9CEoU4RBlA5zM3rCgfZOVUEDjc5h7');

//define('OAUTH_CALLBACK','http://whiteorangesoftware.com/test/twitter/twitter.php');// getenv('OAUTH_CALLBACK')
define('OAUTH_CALLBACK','http://whiteglovesme.com/test/twitter/twitter.php');// getenv('OAUTH_CALLBACK')

