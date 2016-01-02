<?php
error_reporting(-1);
set_time_limit(0);
// References : https://twitteroauth.com/redirect.php
require "twitteroauth/vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
session_start();

define('CONSUMER_KEY', 'Q0Q5muQtJytZThD7w0Hk0eTTz');
define('CONSUMER_SECRET', 'WCQp9fGwVEpBrIProsijdreXSXoZ28r8Ep3j0XcvUJB7f5qbw0');

define('ACCESS_TOKEN','3912902479-1qqzQ9HDBmFhMvdzdXG09PCpFVXdV1RLg61AYxZ');
define('ACCESS_TOKEN_SECRET','o6qEc32o1AIjPIXD2GVGhaf9gpvrOFT0Ay0t3JaCzfpWr');

define('OAUTH_CALLBACK','http://whiteorangesoftware.com/test/twitter.php');// getenv('OAUTH_CALLBACK')