<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cokkies</title>
</head>
<body>
<?php
	$cookie_name = "user";
	$cookie_value = "John Doe";
	//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
	var_dump($_COOKIE); 
	
?>
<input type="button" id="btnCokkies" name="btnCokkies" value="Cokkies">
<br/>
<input type="button" id="btnGetCokkies" name="btnGetCokkies" value="Get Cokkies">
</body>

<script type="text/javascript">
	
	
	document.getElementById('btnCokkies').addEventListener('click',function(event){
		document.cookie = "username=John Doe; expires=Thu, 18 Dec 2015 12:00:00 UTC";
	},false);
	
	document.getElementById('btnGetCokkies').addEventListener('click',function(event){
		var x = document.cookie;
		alert(x);
		console.log(x);
		
	},false);
	
</script>

</html>