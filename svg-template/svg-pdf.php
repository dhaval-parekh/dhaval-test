<?php

require_once 'php-svg/autoloader.php';

use JangoBrick\SVG\SVGImage as SVGImage;
use JangoBrick\SVG\Nodes\Shapes\SVGRect as SVGRect;
use JangoBrick\SVG\Nodes\Shapes\SVGCircle as SVGCircle;
use JangoBrick\SVG\Nodes\Shapes\SVGEllipse as SVGEllipse;
use JangoBrick\SVG\Nodes\Shapes\SVGLine as SVGLine;
use JangoBrick\SVG\Nodes\Shapes\SVGPolygon as SVGPolygon;
use JangoBrick\SVG\Nodes\Shapes\SVGPolyline as SVGPolyline;
use JangoBrick\SVG\Nodes\Shapes\SVGPath as SVGPath;

function get_svg_path( $frame ) {
	$response = array();
	$svgimage = SVGImage::fromFile( $frame );

	$svgdoc = $svgimage->getDocument();
	$svg_viewbox = $svgdoc->getAttribute( 'viewBox' );
	$svg_viewbox_params = explode( ' ', $svg_viewbox );
	if ( $svg_viewbox_params ) {
		$svg_poistion_x = $svg_viewbox_params[0];
		$svg_poistion_y = $svg_viewbox_params[1];
		$width = $svg_viewbox_params[2];
		$height = $svg_viewbox_params[3];

		$response['x'] = $svg_poistion_x;
		$response['y'] = $svg_poistion_y;
		$response['width'] = $width;
		$response['height'] = $height;
	}

	$child_count = $svgdoc->countChildren();

	$pngimage = new SVGImage( $width, $height );
	$pngdoc = $pngimage->getDocument();
	$pngdoc->setAttribute( 'viewBox', $svg_viewbox );


	for ( $i = 0; $i < $child_count; $i++ ) {

		$child = $svgdoc->getChild( $i );
		$element_type = $child->getName();


		switch ( $element_type ) {

			case 'path':

				$childpath = $child->getAttribute( 'd' );
				$path = new SVGPath( $childpath );
				break;

			case 'circle':

				$position_x = $child->getAttribute( 'cx' );
				$position_y = $child->getAttribute( 'cy' );
				$radius = $child->getAttribute( 'r' );

				$path = new SVGCircle( $position_x, $position_y, $radius );
				break;

			case 'rect':

				$position_x = $child->getAttribute( 'x' );
				$position_y = $child->getAttribute( 'y' );
				$height = $child->getAttribute( 'height' );
				$width = $child->getAttribute( 'width' );
				$radius_x = $child->getAttribute( 'rx' );
				$radius_y = $child->getAttribute( 'ry' );

				$path = new SVGRect( $position_x, $position_y, $width, $height );
				break;

			case 'polyline':
				$points = $child->getPoints();
				$points = array_map( 'array_filter', $points );
				$points = array_filter( $points );

				$path = new SVGPolyline( $points );
				break;

			case 'polygon':
				$points = $child->getPoints();
				$points = array_map( 'array_filter', $points );
				$points = array_filter( $points );

				$path = new SVGPolygon( $points );
				break;

			case 'line':
				$position_x1 = $child->getAttribute( 'x1' );
				$position_y1 = $child->getAttribute( 'y1' );
				$position_x2 = $child->getAttribute( 'x2' );
				$position_y2 = $child->getAttribute( 'y2' );

				$path = new SVGLine( $position_x1, $position_y1, $position_x2, $position_y2 );
				break;

			case 'ellipse':

				$position_x = $child->getAttribute( 'cx' );
				$position_y = $child->getAttribute( 'cy' );
				$radius_x = $child->getAttribute( 'rx' );
				$radius_y = $child->getAttribute( 'ry' );

				$path = new SVGEllipse( $position_x, $position_y, $radius_x, $radius_y );
				break;

			default:
				//_e('Failed to load element, please use only grpahic elementnts','ezway');
				break;
		}
		$response['path'][] = $path->getAttribute( 'd' )->__toString();
//		print_r($path);
		if ( !empty( $element_type ) && in_array( $element_type, array( 'path', 'circle', 'rect', 'polyline', 'polygon', 'line', 'ellipse' ) ) ) {
			$path->setStyle( 'fill', '#000' );
			$path->setStyle( 'stroke', '#000' );
			$path->setStyle( 'stroke-width', '1px' );
			$pngdoc->addChild( $path );
		}
	}
//	print_r( $pngdoc );
	return $response;
}

//echo '<pre>';
$url = 'http://localhost:8888/dhaval-web/dhaval-test/svg-template/frontend/img/4-Nature-Wallpapers.jpg';
$url = 'http://localhost:8888/rtcamp/snapbox/wp-content/uploads/2016/12/17572553041481019585.jpg';
//$url = 'http://localhost:8888/rtcamp/snapbox/wp-content/uploads/2017/02/bg-e1458463428912.jpg';
$url = 'image/dare-9.jpg';
//$url = 'image/b7seR.png';
//$url = 'image/bg.jpg';

// svg detail 
$file = 'image/Example.svg';
$svg_info = get_svg_path( $file );
$path_data = $svg_info['path'];

// image process
$image = new \Imagick( $url );
//$image->cropthumbnailimage($svg_info['width'], $svg_info['height']);
$image->thumbnailimage( $svg_info['width'], $svg_info['height'], false );

//header('Content-type: image/jpg');
//die($image->getimageblob());
//
//$data = file_get_contents( $url );
$data = base64_encode( $image->getimageblob() );
$data = 'data:image/jpg;base64,' . $data;
$image_detail = getimagesize( $url );


//$image_attr = $image_detail[3];
$image_attr = 'width="' . $svg_info['width'] . '" height="' . $svg_info['height'] . '"';
//$image_attr = 'width="100%" height="100%"';
//$image_attr = '';

$svg = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
$svg .= '<svg version="1.1" id="root" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="' . $svg_info['width'] . '" height="' . $svg_info['height'] . '" x="' . $svg_info['x'] . 'px" y="' . $svg_info['x'] . 'px"  style="enable-background:new ' . $svg_info['x'] . ' ' . $svg_info['y'] . ' ' . $svg_info['width'] . ' ' . $svg_info['height'] . ';" xml:space="preserve">' . PHP_EOL;
//$svg .= '<rect ' . $image_attr . ' style="fill:rgb(0,0,255);">' . PHP_EOL;
//$svg .= '</rect>' . PHP_EOL;
//$svg .= '<image overflow="visible" enable-background="new" ' . $image_attr . ' xlink:href="' . $data . '" ></image>' . PHP_EOL;
$paths = '';
foreach ( $path_data as $path ) {
	$paths .= $path;
//	$svg .= '<path d="' . $path . '" fill="none" stroke-miterlimit="10" stroke="#000"></path>' . PHP_EOL;
}
$svg .= '<path d="' . $paths . '" fill="none" stroke-miterlimit="10" stroke="#000"></path>' . PHP_EOL;
$svg .= '</svg>' . PHP_EOL;

//die( $svg );
/* ======= SVG ======== */
$svg_output = 'output.svg';
$file = fopen( $svg_output, 'w' );
fwrite( $file, $svg );
fclose( $file );
die( $svg );

/* ===== PDF ===== */
require_once('TCPDF/config/tcpdf_config.php');
$tcpdf_include_dirs = array(
	realpath( 'TCPDF/tcpdf.php' ),
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ( $tcpdf_include_dirs as $tcpdf_include_path ) {
	if ( @file_exists( $tcpdf_include_path ) ) {
		require_once($tcpdf_include_path);
		break;
	}
}
$pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );

$pdf->setPrintHeader( false );
$pdf->setPrintFooter( false );

$pdf->AddPage();
$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );

$pdf->ImageSVG( $svg_output, 0, 0, 210, 210, '', '', '', 0, false );
$pdf->Output( __DIR__ . '/format12.pdf', 'f' );
