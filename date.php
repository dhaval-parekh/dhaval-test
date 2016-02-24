<script type="text/javascript">
	var date = new Date();
	console.log(date.getTime());
</script>
<?php
//var_dump(time());

// 7 days; 24 hours; 60 mins; 60 secs
//echo date('Y-m-d H:i:s T', time()) . "<br>\n";
date_default_timezone_set('UTC');
//echo date('Y-m-d H:i:s T', time()) . "<br>\n";
//$timezone = 'Asia/Kolkata';
//$timezone = '+5:30';
//$timezone = preg_replace('/[^0-9]/', '', $timezone) * 36;
//echo $timezone . "<br>\n";
//$timezone_name = timezone_name_from_abbr(null, $timezone, true);
//date_default_timezone_set($timezone_name);
//date_default_timezone_set($timezone_name);
//echo date('Y-m-d H:i:s T', time()) . "<br>\n";
//var_dump($timezone_name);
//var_dump(new DateTime);
$datetime1 = date_create('2009-10-11');
$datetime2 = date_create('2009-10-13');
$interval = date_diff($datetime1, $datetime2);
//var_dump($interval);
//echo $interval->format('%H  Hours %i Minute %s second');

$date = date('Y-m-d H:i:s',strtotime('2015-08-15 20:19:00')); //'2015-08-15 20:19:00';
echo '<br><pre>';
$last_expirey_time = new DateTime($date);
print_r($last_expirey_time);
//print_r(date_format($last_expirey_time,"Y/m/d H:i:s l"));
//print_r($last_expirey_time->format("Y/m/d H:i:s l"));
//$last_expirey_time->modify('-50 hours');
print_r($last_expirey_time); echo '<br>';
print_r($last_expirey_time->format("d"));
echo '<br>';
if($last_expirey_time->format("d") == date('d')){
	echo 'Today '.$last_expirey_time->format('H:i A l');
}elseif($last_expirey_time->format("d") == date('d')+1){
	echo 'Tomorrow '.$last_expirey_time->format('h:i A l');
}else{
	$day = strtolower($last_expirey_time->format('l'));
	//echo $day;
	switch($day){
		case 'sunday':
				$day = 'יוֹם רִאשׁוֹן';
			break;
		case 'monday':
				$day = 'יוֹם שֵׁנִי';
			break;
		case 'tuesday':
				$day = 'יוֹם שְׁלִישִׁי';
			break;
		case 'wednesday':
				$day = 'יום רביעי';
			break;
		case 'thursday':
				$day = 'יוֹם חֲמִישִׁי';
			break;
		case 'friday':
				$day = 'יוֹם שִׁישִׁי';
			break;
		case 'saturday':
				$day = 'יום שבת';
			break;
	}
	
	//echo $day;
	echo ''.$last_expirey_time->format('l h:i A');
}
echo '</pre><pre>';
/*$last_expirey_time->modify('-24 hours');

if(date('Y-m-d H:i:s') > $last_expirey_time->format('Y-m-d H:i:s') ){
	echo 'charge';
		
}else{
	echo 'no charge';	
}
//date('Y-m-d H:i:s');
//var_dump($last_expirey_time);

// date fromate
if(!function_exists("ChangeDateFormat")) {
    function ChangeDateFormat($date = '', $format = '') {
        if($date == '' or $date == '0000-00-00' or $date == '0000-00-00 00:00:00') {
            return '-';
        } else {
		  $current_date_format = "d/m/Y";
		  $d = date_create_from_format($current_date_format, $date); 
		  return date_format($d,$format);
        }
    }
}
echo '<pre>';
echo ChangeDateFormat('12/01/2015', 'Y-m-d');

*/