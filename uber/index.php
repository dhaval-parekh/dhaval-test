<?php
$client_id     = 'pnZfiRA6DCpc5udv1awKC0Un5KBNRZBe';
$client_secret = 'qj6x2FteQS2QVL6ArIyzva-U-mTzLWJziaIcvPrf';
$server_token  = 'QgTWQBxL8FDWZp8-ma_WJVwWLZfu0OI_cV2yWH2U';
$code          = 'XvKbSIZwOTt7qymIIVsh5H60wbvXjq';

// Utility functions.
function display( $object ) {
	echo '<pre>';
	print_r( $object );
	echo '</pre>';
}


// Login
$redirect_uri = 'http://localhost:8888/dhaval-web/dhaval-test/uber/';
$login_url = "https://login.uber.com/oauth/v2/authorize?client_id=$client_id&response_type=code&redirect_uri=$redirect_uri";
//$response  = file_get_contents( $login_url );
print_r( $login_url );