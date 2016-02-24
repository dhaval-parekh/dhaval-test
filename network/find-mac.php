<?php
ob_start();  
system('ipconfig /all');  
$mycomsys=ob_get_contents();  
// Clean (erase) the output buffer  
ob_clean();  
echo '<pre>';
//print_r($mycomsys);


$find_mac = "Physical"; 
//find the "Physical" & Find the position of Physical text  

$pmac = strpos($mycomsys, $find_mac);  
// Get Physical Address  

$macaddress=substr($mycomsys,($pmac+36),17);  
//Display Mac Address  

//echo $macaddress;  
//print_r($_SERVER['REMOTE_ADDR']);
$ip  = $_SERVER['REMOTE_ADDR'];
$x = shell_exec('arp -a ' . escapeshellarg($ip));
echo $x;
