<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JSON</title>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/ecmascript" src="js/print_r.js"></script>
<script type="text/javascript">
var xmlhttp = new XMLHttpRequest();
//var url = "https://datauniq.azurewebsites.net/api/TradeManager.svc/Login";
var url = "http://localhost/Work/Test/api/index.json";
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
	   
        //myFunction(myArr);
	  //$('#id01').html(myArr);
    }
}
//xmlhttp.open("POST", url, true);
//xmlhttp.send();


$.getJSON( "api/logout/struct.json", function( data ) {
	
	 $.each(data, function(i, field){
      	$("#id01").append(field + " ");
    	});
	
});

function main(){
	alert('main start');
	function sub1(){
		alert('Sub 1');
	}
	
	function sub2(){
		alert('Sub 2');
	sub1();
	}

	alert('main end');
}
main();

</script>
</head>
<body>
<pre id="id01"></pre>
</body>
</html>