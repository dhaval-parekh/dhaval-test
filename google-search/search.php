<?php
function display($obj){ echo '<pre>'; print_r($obj); echo '</pre>';}
$query = 'dmparekh';
$query = urlencode($query);
$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".$query;
display($url);
$body = file_get_contents($url);

$json = json_decode($body);
display($json);
for($x=0;$x<count($json->responseData->results);$x++){

echo "<b>Result ".($x+1)."</b>";
echo "<br>URL: ";
echo $json->responseData->results[$x]->url;
echo "<br>VisibleURL: ";
echo $json->responseData->results[$x]->visibleUrl;
echo "<br>Title: ";
echo $json->responseData->results[$x]->title;
echo "<br>Content: ";
echo $json->responseData->results[$x]->content;
echo "<br><br>";

}

