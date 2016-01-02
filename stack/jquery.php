<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
	<div id="main">
		
	</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(e) {
		jQuery('#main').change(function(e) {
			console.log('changes ');
			//if(jQuery('#btn')){
				jQuery('#btn').click(function(e) {
					alert('Btn click by jquery');
				});
				
				document.getElementById('btn').addEventListener('click',function(event){
					alert('btn click bt Javascript')
				},false);
			//}
		});
			
	});
	
	
</script>
</html>