﻿<html>
	<head>
		<title></title>
	</head>
	<body>
		<h1>My Theater</h1>


		<div id="mainContainer"></div>
		<input type="button" value="Add Item" id="butAddItem" />
		<script type="text/template" id="tmplt-Movies">
			<ul>
			</ul>
		</script>
		<script type="text/template" id="tmplt-Movie">
        <div>*******************************************************</div>
		<div><%= Id %> </div>
		<div><%= Name %> </div>
		<div><%= AverageRating %> </div>
		<div><%= ReleaseYear %> </div>
		<div><%= Url %> </div>
		<div><%= Rating %> </div>
		</script>

		<!--<script src="js/jquery.js" type="text/javascript"></script>-->
		<script src="js/jquery-1.7.1.js" type="text/javascript"></script>
		<script src="js/underscore.js" type="text/javascript"></script>
		<script src="js/backbone.js" type="text/javascript"></script>
		<script src="js/app.js" type="text/javascript"></script>
	</body>
</html>


