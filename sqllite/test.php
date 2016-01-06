<?php

define('DS', DIRECTORY_SEPARATOR);
define('DATABASE','temp'.DS.'db1.db');
require_once('class.database-access-sqllite.php');
function display($obj){ echo '<pre>'; print_r($obj); echo '</pre>'; }

$con = new sqlLite_DatabaseAccess(DATABASE);
$con->Open();

// Create TABLE 
$query = "
CREATE TABLE IF NOT EXISTS  `test` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT NOT NULL
);
";
display($con->ExecuteNoneQuery($query));

// Insert 
$query = "INSERT INTO test (name) VALUES ('Dhaval');";
display($con->ExecuteNoneQuery($query));


// Featch Data

$query = 'SELECT * FROM test';
display($con->ExecuteQuery($query));
if(function_exists('mysql_connect')){ echo 'Y'; }else{ echo 'N'; }