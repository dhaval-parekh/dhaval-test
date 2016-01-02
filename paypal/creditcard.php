<?php
/**
 *	Title : paypal Integration
 *	
 *	References : tutorial : https://github.com/paypal/PayPal-PHP-SDK/wiki/Installation-Direct-Download
 *	SDK : https://github.com/paypal/PayPal-PHP-SDK/wiki/Installation
 *	
 */
error_reporting(-1);
function display($object){ echo '<pre>'; print_r($object); echo '</pre>'; }

require __DIR__  . '/PayPal-PHP-SDK/autoload.php';

// After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Ac3ubeB_bXN-glkCknUvyWy5AWcSfNr93qwXP4G5JIwZik30QkIVNSc1zGScbfQKAZp_XYimZxeDJsvA',     // ClientID
        'EBzvyOprm24zHlQjdO_Je9lFYQj1jvpKRbjiwAvWzZp99D-Q49Mkiqi0jB7ud4JcruAKeTjkfNOLHpdU'      // ClientSecret
    )
);


// Step 2
$creditCard = new \PayPal\Api\CreditCard();
/*$creditCard->setType("visa")
    ->setNumber("4417119669820331")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setCvv2("012")
    ->setFirstName("Joe")
    ->setLastName("Shopper");
*/
/*
echo '<h1> Add Credit Card </h1>';
$creditCard->setType("visa")
    ->setNumber("4417119669820331")
    ->setExpireMonth("11")
    ->setExpireYear("2020")
    ->setCvv2("999")
    ->setFirstName("Nicolash1")
    ->setLastName("Smith");


try {
    $creditCard->create($apiContext);
    display($creditCard);
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // This will print the detailed information on the exception. 
    //REALLY HELPFUL FOR DEBUGGING
    display($ex->getData());
} 
*/


//  GET Credit card

echo '<h1>GET Credit Card</h1>';
try {
	// CArd id 2 => CARD-72U57472B3613723VKXFO5OA
	// Card id 3 => CARD-0Y723068NH051793HKXFO7ZA
    $creditCard = \PayPal\Api\CreditCard::get('CARD-0Y723068NH051793HKXFO7ZA', $apiContext);
} catch (Exception $ex) {
	display($ex);
 	//ResultPrinter::printError("Get Credit Card", "Credit Card", $card->getId(), null, $ex);
    exit(1);
}

 //ResultPrinter::printResult("Get Credit Card", "Credit Card", $card->getId(), null, $card); 
 
 display($creditCard);
 return $creditCard;
 