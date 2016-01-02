<?php
require 'Cloudinary.php';
require 'Uploader.php';
require 'Api.php';

\Cloudinary::config(array( 
	"cloud_name" => "test2dh", 
	"api_key" => "941329182588371", 
	"api_secret" => "RxrcLdgjserd-xwZYd_sQvkwZZo" 
));

$response = \Cloudinary\Uploader::upload("http://whiteglovesme.com/pics/driver/doc/11366088760744.png");
var_dump($response);
//echo cl_image_tag("ezoe1y1z6ltvsxuyrsgu.png");



