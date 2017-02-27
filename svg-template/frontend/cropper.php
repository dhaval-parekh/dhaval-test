<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cropper.js</title>
  <link rel="stylesheet" href="../frontend/css/cropper.css">
  <style>
    .container {
      max-width: 640px;
      margin: 20px auto;
    }

    img {
      max-width: 100%;
    }

    /* Override Cropper's styles */
    .cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Crop a round image</h1>
    <h3>Image</h3>
    <div>
      <img id="image" src="../frontend/img/4-Nature-Wallpapers.jpg" alt="Picture">
    </div>
    <h3>Result</h3>
    <button type="button" id="button">Crop</button>
    <div id="result"></div>
  </div>
	<img src="../image/Triangle-2.svg" id="svgimg" />
  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.6/angular.min.js"></script>
  <script src="../frontend/js/fabric.js"></script>
		
  <script src="../frontend/dist/cropper.js"></script>
  <script>
    function getRoundedCanvas(sourceCanvas) {
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      var width = sourceCanvas.width;
      var height = sourceCanvas.height;
	  //var poly=[ 5,5, 100,50, 50,100, 10,90 ];
	  var poly=[150,850.5, 500,150.5, 850,850.5 ];
      canvas.width = width;
      canvas.height = height;
      context.beginPath();
	 
      context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI);
	  /*context.moveTo(poly[0], poly[1]);
		for( item=2 ; item < poly.length-1 ; item+=2 ){
			context.lineTo( poly[item] , poly[item+1] )
		}*/
      context.strokeStyle = 'rgba(0,0,0,0)';
      context.stroke();
      context.clip();
	  //var img = document.getElementById('svgimg');
	  //context.drawImage(img, 10, 10);*/
      context.drawImage(sourceCanvas, 0, 0, width, height);

      return canvas;
    }

    $(function () {
      var $image = $('#image');
      var $button = $('#button');
      var $result = $('#result');
      var croppable = false;

      $image.cropper({
        aspectRatio: 1,
        viewMode: 1,
        ready: function () {
          croppable = true;
        }
      });

      $button.on('click', function () {
        var croppedCanvas;
        var roundedCanvas;

        if (!croppable) {
          return;
        }

        // Crop
        croppedCanvas = $image.cropper('getCroppedCanvas');

        // Round
        roundedCanvas = getRoundedCanvas(croppedCanvas);
		
        // Show
        $result.html('<img src="' + roundedCanvas.toDataURL() + '">');
      });
    });
  </script>
</body>
</html>