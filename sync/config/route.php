<?php
/*
 * Author: Dhaval Parekh 
 * Author Url: about.me/dmparekh
 * Company : 
 * Company Url : 
 * Description: route file
 *
 *
 *
 *
 *
 */
/*
 * NOTE: in Route the position of the route line will affect to actual Execution
 */

// /// Routes /////
$admin_route = array();
$route = array();
$route[''] = 'index/index';
$route['socket'] = 'socket/socketServer';
$route['about'] = 'index/about';

if (isset($_SESSION['access_token'])) :

	
else:

endif;

