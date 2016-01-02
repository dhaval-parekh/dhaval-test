<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
<?php echo '<pre>'; print_r($_POST); echo '</pre>';?>	

<input type="number" id="amount" value="10"><br/>
<button type="button" id="btn">Click Me</button>
<div id="temp"></div>

<!--<form action="" method="POST"><script src="https://checkout.stripe.com/checkout.js" class="stripe-button"  data-key="pk_test_3Ci2I2B1R5q9apb3qmKPGWQx"  data-amount="2000"  data-name="Demo Site" data-description="2 widgets ($20.00)" data-image="/128x128.png" data-locale="auto"> </script> </form>-->

<script type="text/javascript">
	document.getElementById('btn').addEventListener('click',function(event){
		
		var amount = document.getElementById('amount').value;
		var strip = '<form action="" id="frm" method="POST"><script src="https://checkout.stripe.com/checkout.js" class="stripe-button"  data-key="pk_test_3Ci2I2B1R5q9apb3qmKPGWQx"  data-amount="'+amount+'"  data-name="Demo Site" data-description="2 widgets ($20.00)" data-image="/128x128.png" data-locale="auto"> ';
		strip += '<'+'/'+'script> <'+'/'+'form>';
		console.log(strip);
		document.getElementById('temp').innerHTML = strip;
		//document.getElementById('frm').submit();
		
	},false);
</script>

</body>
</html>