<?php
error_reporting(-1);

function display($object){ echo '<pre>'; print_r($object); echo '</pre>'; }

require_once('braintree/lib/Braintree.php');
require_once('braintree/vendor/autoload.php');

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('r3gx8s4r2jrzx623');
Braintree_Configuration::publicKey('rfs9nch8nck364gb');
Braintree_Configuration::privateKey('9ec0eef551cc36b32b345041f98f151a');


// Ganarate Client Token
echo($clientToken = Braintree_ClientToken::generate());

//	recie payment methd from client
//$nonce = $_POST["payment_method_nonce"];
// testin nonece
$nonce  = '5df6ad09-0cdd-4db2-8462-0291151e31ba';
display( $nonce );
/* Use payment method nonce here */

$result = Braintree_Transaction::sale([
  'amount' => '100.00',
  'paymentMethodNonce' => $nonce
]);

display($result);