<?php

define('BASE_PATH', dirname(dirname(__FILE__)));

define('API_KEY', 'app_secreat_key');

define('PASSWORD','aw-098@#@Q_Ckpawe94');
define('SALT','S%#)(vcds;ldWEas@#@');


define('INDEX', 'index.php');
define('DS', DIRECTORY_SEPARATOR);

define('DIR_CONFIG',BASE_PATH.DS.'config');
define('DIR_APP',BASE_PATH.DS.'app');
define('DIR_SYS',BASE_PATH.DS.'sys');
define('DIR_CONTROLLER',DIR_APP.DS.'controllers');
define('DIR_MODAL',DIR_APP.DS.'modals');
define('DIR_VIEW',DIR_APP.DS.'views');
define('DIR_LIBRARY',BASE_PATH.DS.'lib');

date_default_timezone_set('UTC');

// Database
define('DB_SCRIPT_PATH', BASE_PATH.DS.'db'.DS.'database.sql');
define('DB_NAME', 'testdb.db');
define('DB_PATH', BASE_PATH.DS.'test'.DS);
define('DATABASE', DB_PATH.DB_NAME);


define('CACHE_EXPIRY_TIME',100*60); // time in second // 15 minute
error_reporting(-1);
//error_reporting(-1 & ~E_DEPRECATED);
//error_reporting(0);

session_start();

// Load Libraries 
require_once(DIR_LIBRARY.DS.'twitteroauth'.DS.'vendor'.DS.'autoload.php');
// Import Files
require_once(DIR_SYS.DS.'classes'.DS.'class.database-access-sqllite.php');
require_once(DIR_SYS.DS.'classes'.DS.'class.url.php');
require_once(DIR_SYS.DS.'classes'.DS.'class.input.php');

require_once(DIR_SYS.DS.'helpers'.DS.'helper.app.php');
require_once(DIR_SYS.DS.'helpers'.DS.'helper.url.php');
require_once(DIR_SYS.DS.'helpers'.DS.'helper.debug.php');

require_once(DIR_SYS.DS.'core'.DS.'controller.php');
require_once(DIR_SYS.DS.'core'.DS.'modal.php');

/**/

require_once(BASE_PATH.DS.'config'.DS.'route.php');

define('TWEETER_CONSUMER_KEY', '8Co2Ja7LNKSaQouJD93xbveKS');
define('TWEETER_CONSUMER_SECRET', '5f75uq96vapBGiQvsU8qyarfw2znQBTZDzCbancDoCOrXX78Mx');

define('TWEETER_ACCESS_TOKEN','3912902479-jwbCn5vQrIJ5FMKTCDvkRsK98t6AUpURpauuTo5');
define('TWEETER_ACCESS_TOKEN_SECRET','h302OJBjutaoIqyT9CEoU4RBlA5zM3rCgfZOVUEDjc5h7');
