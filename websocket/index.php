<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Web Socket</title>

<script type="text/javascript">
	var connection = new WebSocket('ws://html5rocks.websocket.org/echo', ['soap', 'xmpp']);
	
	//http://localhost/work/test/websocket/socket.php
	//var connection = new WebSocket('ws://localhost/work/test/websocket/socket.php');
	console.log(connection);
	// When the connection is open, send some data to the server
	connection.onopen = function () {
		connection.send('Ping'); // Send the message 'Ping' to the server
	};
	// Log errors
	connection.onerror = function (error) {
		console.log('WebSocket Error ' + error);
		console.log(error);
	};
	
	// Log messages from the server
	connection.onmessage = function (e) {
		console.log(e);
		alert(e.data);
		console.log('Server: ' + e.data);
	};
</script>
</head>
<body>
<?php 
		echo gethostbyname("google.com");
	
?>

</body>
</html>
