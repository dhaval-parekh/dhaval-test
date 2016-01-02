<?php
$imgArray = array("header_1000x150_basnenaprani_3_o.png", "header_1000x150_basnenaprani_1_m.png", "header_1000x150_basnenaprani_1-zlatá.png");
// Path to where your images are stored
$hostDir = "http://myweb.com/wp-content/uploads/2015/10/"; // Don't forget that ending '/'

$imgArraySize = count($imgArray); // Store the size of the array (starts at 1)
$imgToShow = 0; // We'll default to always show the first image.

// Check to see if the cookie has already been created.
if ( isset($_COOKIE['imagerotate']) && $_COOKIE['imagerotate'] != "") {
  // The cookie existed
  $imgToShow = $_COOKIE['imagerotate'];
  if($imgToShow + 1 >= $imgArraySize) {
    // The image we were supposed to show next would have been out of bounds in the array.
    $imgToShow = 0;  // We'll show the first image
  }
  else  // The image to be shown is not out of bounds.
    $imgToShow++;  // Increment the image counter
}

// Write the new cookie with the new image we are showing
//setcookie ("imagerotate", $imgToShow, time()+5);
setcookie ("imagerotate", $imgToShow, time()+500);
//Print the image from the directory.
echo "<img src=\"".$hostDir.$imgArray[$imgToShow]."\" alt=\"An Image\" />";

?>