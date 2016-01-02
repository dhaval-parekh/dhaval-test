<?php
require_once('function.php');
require_once('sdk/vendor/autoload.php');
define('SITE_URL', 'http://localhost/work/reach/');
// After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AY_WvE4xZOUXLJKLW0sG0CijfhToPVJNZuUr9XpyedhJWEU81tYoWMhQgmxYnm_F-5BZWfEBP2QzuXA6',     // ClientID
		'EMEjgxK4lsdgAYL0OAQvzAQ2adyxO9tyD-Ib_7exG2AvQmVX_noXeN_IoQjQK3wxAWbma6jFoA9cCm_3'      // ClientSecret
	)
);

/* Payment with paypal */ 
use \PayPal\Api\Amount; 
use \PayPal\Api\Details; 
use \PayPal\Api\Item; 
use \PayPal\Api\ItemList; 
use \PayPal\Api\Payer; 
use \PayPal\Api\Payment; 
use \PayPal\Api\RedirectUrls; 
use \PayPal\Api\Transaction;

$Phone = '12312312312';
$Amount = 20;
$Method = 'p';
/*
/* Payment with paypal */ 
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");

		$item1 = new Item();
		$item1->setName('Reach Reachrage')
			->setCurrency('USD')
			->setQuantity(1)
			->setSku("123") // Similar to `item_number` in Classic API
			->setPrice($Amount);

		$itemList = new ItemList();
		$itemList->setItems(array($item1));	
		
		$details = new Details();
		$details->setShipping(0)
			->setTax(0)
			->setSubtotal($Amount);
		
		$amount = new Amount();
		$amount->setCurrency("USD")
			->setTotal($Amount)
			->setDetails($details);
			
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription("Reach Credit Recharge")
		    ->setInvoiceNumber(uniqid());
		    
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(SITE_URL."getDetail.php?action=makePaypalPayment&success=true")
				->setCancelUrl(SITE_URL."getDetail.php?action=makePaypalPayment&success=false");
				
		$payment = new Payment();
		$payment->setIntent("sale")
			->setPayer($payer)
			->setRedirectUrls($redirectUrls)
			->setTransactions(array($transaction));
			
		try {
			$payment->create($apiContext);
		display($payment);
		} catch (Exception $ex) {
			display($ex);
			$response['message'] = $ex->getMessage(); //'Can Not Connect Paypal with secoure Connection. Please try again after some time';
			die(json_encode($response));
		}	
		$response['status']  = 200;
		$response['message'] = 'ok';
		$response['payload'] = $approvalUrl;
		$approvalUrl = $payment->getApprovalLink();
		header('Location: '.$approvalUrl);
		echo (json_decode($response))."<br>";

die();

// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.
$payer = new Payer();
$payer->setPaymentMethod("paypal");

// ### Itemized information
// (Optional) Lets you specify item wise
// information
$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
	->setCurrency('USD')
	->setQuantity(1)
	->setSku("123123") // Similar to `item_number` in Classic API
	->setPrice(7.5);

$item2 = new Item();
$item2->setName('Granola bars')
	->setCurrency('USD')
	->setQuantity(5)
	->setSku("321321") // Similar to `item_number` in Classic API
	->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(1.2)
	->setTax(1.3)
	->setSubtotal(17.50);
	
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20)
    ->setDetails($details);
    
// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());
   /*
// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());
*/
// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
$baseUrl =  'http://localhost/work/test/paypal/rest'; //getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");
    

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));

// For Sample Purposes Only.
$request = clone $payment;

// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
try {
    $payment->create($apiContext);
    
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    display('erorr');
    display($ex);
 	//ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
    exit(1);
}

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();
echo  "<a href='$approvalUrl' >$approvalUrl</a>";
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 //ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);
display($payment);
return $payment;
