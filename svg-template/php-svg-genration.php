<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//phpinfo();die;
require_once __DIR__ . '/php-svg/autoloader.php';

use JangoBrick\SVG\SVGImage;
use JangoBrick\SVG\Nodes\Shapes\SVGRect;
use JangoBrick\SVG\Nodes\Shapes\SVGCircle;
use JangoBrick\SVG\Nodes\Shapes\SVGEllipse;
use JangoBrick\SVG\Nodes\Shapes\SVGLine;
use JangoBrick\SVG\Nodes\Shapes\SVGPolygon;
use JangoBrick\SVG\Nodes\Shapes\SVGPolyline;
use JangoBrick\SVG\Nodes\Shapes\SVGPath;

//$xml = simplexml_load_file('image/Example.svg');
// image with 100x100 viewport

//$svgimage	 = SVGImage::fromFile( 'image/Example.svg' );
$svgimage			 = SVGImage::fromFile( 'image/Example_Wing.svg' );
$svgdoc		 = $svgimage->getDocument();
$svg_viewbox =$svgdoc->getAttribute('viewBox');
$svg_viewbox_params= explode(' ', $svg_viewbox);

if( $svg_viewbox_params ){
	$svg_poistion_x=$svg_viewbox_params[0];
	$svg_poistion_y=$svg_viewbox_params[1];
	$width=$svg_viewbox_params[2];
	$height=$svg_viewbox_params[3];
}

$child_count = $svgdoc->countChildren();

$pngimage	 = new SVGImage( $width, $height );
$pngdoc		 = $pngimage->getDocument();
$pngdoc->setAttribute( 'viewBox', $svg_viewbox );

//$pngimage->appendAttributes('viwebox',$svg_viewbox);

for ( $i = 0; $i < $child_count; $i++ ) {

	$child			 = $svgdoc->getChild( $i );
	$element_type	 = $child->getName();

	
	switch ( $element_type ) {
		
		case 'path':
			
			$childpath	 = $child->getAttribute( 'd' );
			$path		 = new SVGPath( $childpath );
			break;
		
		case 'circle':
			
			$position_x	 = $child->getAttribute( 'cx' );
			$position_y	 = $child->getAttribute( 'cy' );
			$radius		 = $child->getAttribute( 'r' );
			
			$path= new SVGCircle( $position_x, $position_y, $radius);
			break;

		case 'rect':
			
			$position_x	 = $child->getAttribute( 'x' );
			$position_y	 = $child->getAttribute( 'y' );
			$height		 = $child->getAttribute( 'height' );
			$width		 = $child->getAttribute( 'width' );
			$radius_x	 = $child->getAttribute( 'rx' );
			$radius_y	 = $child->getAttribute( 'ry' );
			
			$path= new SVGRect($position_x, $position_y, $width, $height);
			break;

		case 'polyline':
			$points	 = $child->getPoints();
			$points	 = array_map( 'array_filter', $points );
			$points	 = array_filter( $points );

			$path = new SVGPolyline( $points );
			break;
		
		case 'polygon':
			$points	 = $child->getPoints();
			$points	 = array_map( 'array_filter', $points );
			$points	 = array_filter( $points );

			/* echo '<pre>';
			  var_dump( $points );
			  echo '<pre>';
			  die; */
			//$points_string=trim( $points['points'] );

			$path = new SVGPolygon( $points );
			break;
		
		case 'line':
			$position_x1	 = $child->getAttribute( 'x1' );
			$position_y1	 = $child->getAttribute( 'y1' );
			$position_x2	 = $child->getAttribute( 'x2' );
			$position_y2	 = $child->getAttribute( 'y2' );
			
			$path	= new SVGLine($position_x1, $position_y1, $position_x2, $position_y2);
			break;

		case 'ellipse':
			
			$position_x	 = $child->getAttribute( 'cx' );
			$position_y	 = $child->getAttribute( 'cy' );
			$radius_x	 = $child->getAttribute( 'rx' );
			$radius_y	 = $child->getAttribute( 'ry' );
			
			$path= new SVGEllipse($position_x, $position_y, $radius_x, $radius_y);
			break;

		default:
			//_e('Failed to load element, please use only grpahic elementnts','ezway');
			break;
	}
	//var_dump($path);die;
	//$path->setStyle('stroke',"#000000");
	if( !empty($element_type ) && in_array( $element_type,array('path','circle','rect','polyline','polygon','line','ellipse') ) ){
		$path->setStyle( 'fill', 'none' );
		$path->setStyle( 'stroke', '#000' );
		$path->setStyle( 'stroke-width', '1px' );
		$pngdoc->addChild( $path );
	}
}
// blue 40x40 square at (0, 0)
//$square = new SVGRect(0, 0, 40, 40);
//$square->setStyle('fill', '#0000FF');
//$doc->addChild($square);

//header( 'Content-Type: image/svg+xml' );
//echo $pngimage;

// create new imagick object from image.jpg
/*$png = new Imagick();

$png->setBackgroundColor(new ImagickPixel("transparent"));
$png->readImageBlob($pngimage);
$png->setImageFormat("png");
$png->writeimage('output/to.png');*/
$rasterImage = $pngimage->toRasterImage($width, $height);

header('Content-Type: image/png');
imagepng($rasterImage,'output/to.png');

		// the image uploaded
		$base	 = new \Imagick( 'frontend/img/4-Nature-Wallpapers.jpg' );
		// mask image created
		$mask	 = new \Imagick( 'output/to.png' );
		// final output with white background
		$canvas=new Imagick();
		$imageheight= $_REQUEST['gImageHeight'];
		$imagewidth = $_REQUEST['gImageWidth'];
		
		$imageoffsetX= $_REQUEST['gImageleft'];
		$imageoffsetY= $_REQUEST['gImagetop'];
		$canvas->newImage($imagewidth, $imageheight, new ImagickPixel("transparent"));
		// set canvas image colorspace same as base image
		$canvas->setImageColorspace( $base->getImageColorspace() );
		
		// Setting same size for all images
		$base->resizeImage( $width, $height , \Imagick::FILTER_LANCZOS, 1,true );
		$mask->resizeimage( $width, $height, \Imagick::FILTER_LANCZOS, 1 ,true );
		//$canvas->resizeimage( $width, $height, \Imagick::FILTER_LANCZOS, 1 );
		// trun of image matte if not on 
		// @depercated function need to find alternate
		$base->setimagematte(true);
		// if its matte then use alpha channel nad composite destination in
		if ( $base->getImageMatte() ) {
			
			$base->compositeImage( $mask, \Imagick::COMPOSITE_DSTIN, $imageoffsetX, $imageoffsetY, \Imagick::CHANNEL_ALPHA );
			
		} else {
			// else composite copy mask
			$base->compositeImage( $mask, \Imagick::COMPOSITE_COPYOPACITY, 0, 0 );
			
		}
		// put base image on white background
		$canvas->compositeimage($base, Imagick::COMPOSITE_OVER, 0, 0);
		//write image for final output
		$canvas->writeImage( 'output/final.svg' );
		//retrun file
		
		header("Content-Type: image/svg+xml");
		echo $canvas;
		die;