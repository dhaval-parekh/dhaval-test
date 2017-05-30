<?php

echo '<pre>';
//$test = '';
if ( is_array($test) ) {
	echo 'yest : ';
} else {
	echo 'not : ';
}

$string = 'a:7:{i:0;i:194;i:1;i:192;i:2;i:190;i:3;i:188;i:4;i:186;i:5;i:184;i:6;i:182;}';
$array = unserialize($string);

echo '<br>';
print_r( $array );
array_shift( $array );
print_r( $array );
//$array = array_map('strval',$array);
//$json = json_encode($array);
//print_r( $json );

//print_r(get_loaded_extensions());

 /*



Array
(
    [0] => 194
    [1] => 192
    [2] => 190
    [3] => 188
    [4] => 186
    [5] => 184
    [6] => 182
)

[194,192,190,188,186,184,182]


*/