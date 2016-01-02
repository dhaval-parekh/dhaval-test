<?php
require_once('function.php');
require_once('sdk/vendor/autoload.php');
// After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AY_WvE4xZOUXLJKLW0sG0CijfhToPVJNZuUr9XpyedhJWEU81tYoWMhQgmxYnm_F-5BZWfEBP2QzuXA6',     // ClientID
		'EMEjgxK4lsdgAYL0OAQvzAQ2adyxO9tyD-Ib_7exG2AvQmVX_noXeN_IoQjQK3wxAWbma6jFoA9cCm_3'      // ClientSecret
	)
);

// After Step 2
$creditCard = new \PayPal\Api\CreditCard();
$creditCard->setType("visa")
		->setNumber("4417119669820331")
		->setExpireMonth("11")
		->setExpireYear("2019")
		->setCvv2("012")
		->setFirstName("Joe")
		->setLastName("Shopper");
		
		
// Step 2.1 : Between Step 2 and Step 3
$apiContext->setConfig(
	array(
		'log.LogEnabled' => true,
		'log.FileName' => 'PayPal.log',
		'log.LogLevel' => 'FINE'
	)
);
// After Step 3
try {
	$creditCard->create($apiContext);
	
	display($creditCard);
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
	// This will print the detailed information on the exception. 
	//REALLY HELPFUL FOR DEBUGGING
	display($ex->getData());
}
