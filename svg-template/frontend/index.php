<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Fabric JS demo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.6/angular.min.js"></script>
		<script src="../frontend/js/fabric.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 

    </head>
    <body>
        <div id="bd-wrapper" ng-controller="CanvasControls">
			<h2><span>Fabric.js demos</span> &middot; Dynamic patterns</h2>

			<style>
				p { display: inline-block; width: 200px; vertical-align: top; }
				input[type=checkbox] { display: block; }
			</style>

			<form id="editform">

				<p>
					<label>Pattern image width</label>
					<input type="range" min="50" max="1000" value="0" id="img-width">
				</p>
				<p>
					<label>Pattern left offset</label>
					<input type="range" min="0" max="500" value="0" id="img-offset-x">
				</p>
				<p>
					<label>Pattern top offset</label>
					<input type="range" min="0" max="500" value="0" id="img-offset-y">
				</p>
				<br>
				<p>
					<label>Pattern image angle</label>
					<input type="range" min="-90" max="90" value="0" id="img-angle">
				</p>
				<p>

					<input type="button" value="Done" id="img-submit" />
				</p>

				<table border="1">
					<tr>
						<th> Height </th>
						<th> Width </th>
						<th> Top </th>
						<th> Left </th>
						<th> Angle </th>
					</tr>
					<tr>
						<td class="gImageWidth">
							<input id="gImageWidth" type="text" name="gImageWidth" id="" value="" readonly="readonly" />
						</td>
						<td class="gImageHeight">
							<input id="gImageHeight" type="text" name="gImageHeight" id="" value="" readonly="readonly" />
						</td>
						<td class="gImagetop">
							<input id="gImagetop" type="text" name="gImagetop" id="" value="" readonly="readonly" />
						</td>
						<td class="gImageleft">
							<input id="gImageleft" type="text" name="gImageleft" id="" value="" readonly="readonly" />
						</td>
						<td class="gImageAngle">
							<input id="gImageAngle" name="gImageAngle" type="text" id="" value="" readonly="readonly" />
						</td>

					</tr>
				</table>

			</form>

			<canvas id="c" width="612" height="612"></canvas>
			<div id="output"></div>
    </body>
	<script type="text/javascript">
		(function () {
			var canvas = this.__canvas = new fabric.Canvas('c');
			fabric.Object.prototype.transparentCorners = false;

			var $scale_width = canvas.getWidth() / 2;

			console.log($scale_width);
			document.getElementById('img-width').value = $scale_width;

			var padding = 0;

			fabric.Image.fromURL('../frontend/img/4-Nature-Wallpapers.jpg', function (img) {

				img.scaleToWidth($scale_width);

				var patternSourceCanvas = new fabric.StaticCanvas();
				patternSourceCanvas.add(img);

				var pattern = new fabric.Pattern({
					source: function () {
						patternSourceCanvas.setDimensions({
							width: img.getWidth() + padding,
							height: img.getHeight() + padding
						});
						return patternSourceCanvas.getElement();
					},
					repeat: 'no-repeat'
				});
				canvas.renderAll();
				/*canvas.add(new fabric.Polygon([{ x: 150, y: 850.5 }, { x:500, y: 150.5 },{ x: 850, y: 850.5} ], {
				 left: 10,
				 top: 10,
				 angle: 0,
				 fill: pattern,
				 objectCaching: false,
				 hasControls: false,
				 selectable: false,
				 
				 }));*/
				var group = [];
				fabric.loadSVGFromURL("../image/Star.svg", function (objects, options)
				{
					var loadedObjects = new fabric.Group(group);
					loadedObjects.set({
						left: 0,
						top: 0,
						fill: pattern,
						objectCaching: false,
						hasControls: false,
						selectable: false
					});
					canvas.add(loadedObjects);
					canvas.renderAll();
				},
						function (item, object) {
							object.set('id', item.getAttribute('id'));
							group.push(object);
						});


				document.getElementById('img-width').onchange = function () {
					img.scaleToWidth(parseInt(this.value, 10));
					getimageDimesnsions(img, canvas, pattern);
					canvas.renderAll();
				};
				document.getElementById('img-angle').onchange = function () {
					img.setAngle(this.value);
					getimageDimesnsions(img, canvas, pattern);
					canvas.renderAll();
				};

				document.getElementById('img-offset-x').onchange = function () {
					pattern.offsetX = parseInt(this.value, 10);
					getimageDimesnsions(img, canvas, pattern);
					canvas.renderAll();
				};
				document.getElementById('img-offset-y').onchange = function () {
					pattern.offsetY = parseInt(this.value, 10);
					getimageDimesnsions(img, canvas, pattern);
					canvas.renderAll();
				};
				getimageDimesnsions(img, canvas, pattern);

			});

		})();

		function getimageDimesnsions(img, canvas, pattern) {

			document.getElementById('gImageHeight').value = img.getHeight();
			document.getElementById('gImageWidth').value = img.getWidth();
			document.getElementById('gImagetop').value = pattern.offsetY;
			document.getElementById('gImageleft').value = pattern.offsetX;
			document.getElementById('gImageAngle').value = img.getAngle();

		}

		var request;

// Bind to the submit event of our form
		$(document).on('click', "#img-submit", function (event) {

			// Prevent default posting of form - put here to work in case of errors
			event.preventDefault();

			// Abort any pending request
			if (request) {
				request.abort();
			}
			// setup some local variables
			var $form = $("#editform");

			// Let's select and cache all the fields
			var $inputs = $form.find("input, select, button, textarea");

			// Serialize the data in the form
			var serializedData = $form.serialize();
			console.log(serializedData);
			// Let's disable the inputs for the duration of the Ajax request.
			// Note: we disable elements AFTER the form data has been serialized.
			// Disabled form elements will not be serialized.
			$inputs.prop("disabled", true);

			// Fire off the request to /form.php
			request = $.ajax({
				url: "/ezway-template/php-svg-genration.php",
				type: "post",
				data: serializedData
			});

			// Callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR) {
				// Log a message to the console
				console.log(response);
				$("#output").html(response);
			});

			// Callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown) {
				// Log the error to the console
				console.error(
						"The following error occurred: " +
						textStatus, errorThrown
						);
			});

			// Callback handler that will be called regardless
			// if the request failed or succeeded
			request.always(function () {
				// Reenable the inputs
				$inputs.prop("disabled", false);
			});

		});
	</script>

</html>
