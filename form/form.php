<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
<?php
echo '<pre>';
$input = urldecode(file_get_contents('php://input'));
$input = json_decode($input);
print_r($input);
print_r($_POST);
echo '</pre>';
?>
<form id="form" enctype="application/json" method="post" onSubmit="return false;">
	<p><input type="text"  name="name" id="name"></p>
	<p><input type="email"  name="email" id="email"></p>
	<p><input type="number"  name="number" id="number"></p>
	<p><input type="submit"  name="submit" id="submit"></p>
</form>

<script>
	jQuery(document).ready(function(e) {
		$('#submit').click(function(e) {
			var data_value = new Object();
			//var From = document.getElementById('form');
			
			$('input',$('#form')).each(function(index, element) {
				data_value[$(this).attr('id')] = $(this).val();	
			});
			
			data_value = JSON.stringify(data_value);
			jQuery.ajax({
				//url:'http://leclient.ciphersoul.com/index.php/api/index',
				url:"http://localhost/work/test/form/form.php",
				type:'POST',
				contentType:"application/json",
				data:data_value,
				success: function(data){
					console.log(data);
				},
				error: function(data){
					console.log('error');
				}
			});
		});
		return false;
	});
</script>
</body>
</html>
