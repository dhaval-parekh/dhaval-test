<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript" src="../frontend/js/jquery.svg/jquery.svg.js"></script>


		<script type="text/javascript">
			$(document).ready(function () {
				$("#svgload").svg({
					onLoad: function ()
					{
						var svg = $("#svgload").svg('get');
						svg.load('../image/Star.svg', {addTo: true, changeSize: false});
						//getchilds(svg);
						add_pattern(svg);

					},
					settings: {}}
				);

				$('#btnTest').click(function () {
					var svg = $('#svgload').svg('get');
					console.log(svg);
					$('polygon', svg.root()).attr('fill', 'url("#img1")');
					resetSize(svg);
					var img = $('#img1 image', svg.root());
					var width = img.width();

					$('#img-width').val(width);
				});
				$('#btnUp').click(function () {
					var svg = $('#svgload').svg('get');
					var y = $('#img1', svg.root()).attr('y');
					y = parseFloat(y) - parseFloat(20);
					$('#img1', svg.root()).attr('y', y);
					console.log(y);
				});
				$('#btnDown').click(function () {
					var svg = $('#svgload').svg('get');
					var y = $('#img1', svg.root()).attr('y');
					y = parseFloat(y) + parseFloat(20);
					$('#img1', svg.root()).attr('y', y);
					console.log(y);
				});
				$('#btnLeft').click(function () {
					var svg = $('#svgload').svg('get');
					var svg = $('#svgload').svg('get');
					var x = $('#img1', svg.root()).attr('x');
					x = parseFloat(x) - parseFloat(20);
					$('#img1', svg.root()).attr('x', x);
					console.log(x);
				});
				$('#btnRight').click(function () {
					var svg = $('#svgload').svg('get');
					var x = $('#img1', svg.root()).attr('x');
					x = parseFloat(x) + parseFloat(20);
					$('#img1', svg.root()).attr('x', x);
					console.log(x);
				});
				$('#btntoSVG').click(function () {
					var svg = $('#svgload').svg('get');
					alert(svg.toSVG());

				});

				$('#img-width').change(function () {
					var svg = $('#svgload').svg('get');
					var pattren = $('#img1', svg.root());
					var img = $('#img1 image', svg.root());
					var height = img.height();
					var width = img.width();


					var $newHeight = GetHeight($(this).val(), height, width);
					var $newWidth = $(this).val();

					//pattren.attr('height',$newHeight);
					img.attr('height', $newHeight);

					//pattren.attr('width',$newWidth);
					img.attr('width', $newWidth);

					console.log($newWidth);
					console.log($newHeight);

				});

			});

			function GetHeight(newWidth, orginalHeight, originalWidth)
			{
				if (originalWidth == 0)
					return newWidth;
				var aspectRatio = orginalHeight / originalWidth;
				return newWidth * aspectRatio;
			}

			function resetSize(svg, width, height) {
				svg.configure({width: width || $(svg._container).width(),
					height: height || $(svg._container).height()});
			}

			function add_pattern(svg) {

				var d = svg.defs();
				//1600/2 = 800 X 900/2 = 450 is image width and height
				var p = svg.pattern(d, "img1", 0, 0, 1600, 900, {patternUnits: 'userSpaceOnUse'});
				//var img= svg.image( p, 0, 0, 1600, 900,'../frontend/img/4-Nature-Wallpapers.jpg' );
				var img = svg.image(p, 0, 0, 1600, 900, 'http://localhost:8888/dhaval-web/dhaval-test/svg-template/frontend/img/4-Nature-Wallpapers.jpg');

			}
			function getBase64Image(img) {
				// Create an empty canvas element
				var canvas = document.createElement("canvas");
				canvas.width = img.width;
				canvas.height = img.height;

				// Copy the image contents to the canvas
				var ctx = canvas.getContext("2d");
				ctx.drawImage(img, 0, 0);

				// Get the data-URL formatted image
				// Firefox supports PNG and JPEG. You could check img.src to guess the
				// original format, but be aware the using "image/jpg" will re-encode the image.
				var dataURL = canvas.toDataURL("image/png");

				return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
			}
			function readURL() {
				var file = document.getElementById("getval").files[0];
				var reader = new FileReader();
				reader.onloadend = function () {
					document.getElementById('mycontainer').style.backgroundImage = "url(" + reader.result + ")";
				}
				if (file) {
					reader.readAsDataURL(file);
				} else {
				}
			}
		</script> 
	</head>
	<body>

		<div id="svgload" style="width: 100%; height: 600px;"></div>

		<button id="upload">Upload</button>
		<button id="btnTest">Set Image</button>
		<button id="btnUp">Up</button>
		<button id="btnDown">Down</button>
		<button id="btnLeft">Left</button>
		<button id="btnRight">Right</button>
		<button id="btntoSVG">ToSVG</button>

<!--<input type="range" min="0" max="1600" value="800" id="img-width"/>-->
	</body>
</html>