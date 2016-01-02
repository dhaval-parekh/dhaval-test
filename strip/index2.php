<?php
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
require_once('sdk/vendor/autoload.php');
define('STRIPE_PRIVATE_KEY', 'sk_test_pbqQkMXjItzU13bUDs6gpQ0A');
define('STRIPE_PUBLIC_KEY', 'pk_test_3Ci2I2B1R5q9apb3qmKPGWQx');
// Sandbox
$secret_key = 'sk_test_pbqQkMXjItzU13bUDs6gpQ0A';
$publishable_key = 'pk_test_3Ci2I2B1R5q9apb3qmKPGWQx';

// Live
//$secret_key = 'sk_live_zPVJOX2UywSRfhS6B65o5ZHW';
//$publishable_key = 'pk_live_ICx3aJ2F26uZkWnb9xdTVvR9';

\Stripe\Stripe::setApiKey("sk_test_ymbv8DRuL0sOy8IVwGSSliZ1");

// Get the credit card details submitted by the form
$token = 'tok_16zMf5EGgNccUNBMufWoXMey';//$_POST['stripeToken'];
$amount = 1000;
$email = 'test2dh@gmail.com';
// Create the charge on Stripe's servers - this will charge the user's card
/*try {
  $charge = \Stripe\Charge::create(array(
    "amount" => 10000, // amount in cents, again
    "currency" => "usd",
    "source" => $token,
    "description" => "Example charge"
    ));
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}*/
try {

	// Include the Stripe library:
	// Assumes you've installed the Stripe PHP library using Composer!

	// set your secret key: remember to change this to your live secret key in production
	// see your keys here https://manage.stripe.com/account
	\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);

	// Charge the order:
	$charge = \Stripe\Charge::create(array(
		"amount" => $amount, // amount in cents, again
		"currency" => "usd",
		"source" => $token,
		"description" => $email
		)
	);

	// Check that it was paid:
	if ($charge->paid == true) {

		// Store the order in the database.
		// Send the email.
		// Celebrate!

	} else { // Charge was not paid!
		echo '<div class="alert alert-error"><h4>Payment System Error!</h4>Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction. You can try again or use another card.</div>';
	}

} catch (\Stripe\Error\Card $e) {
    // Card was declined.
	$e_json = $e->getJsonBody();
	$err = $e_json['error'];
	$errors['stripe'] = $err['message'];
} catch (\Stripe\Error\ApiConnection $e) {
    // Network problem, perhaps try again.
} catch (\Stripe\Error\InvalidRequest $e) {
    // You screwed up in your programming. Shouldn't happen!
} catch (\Stripe\Error\Api $e) {
    // Stripe's servers are down!
} catch (\Stripe\Error\Base $e) {
    // Something else that's not the customer's fault.
}
echo '<pre>';
	print_r($_POST);
	print_r($_SERVER);
	print_r($_SESSION);
echo '</pre>';