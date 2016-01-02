<?php # config.inc.php
// Created by Larry Ullman, www.larryullman.com, @LarryUllman
// Posted as part of the series "Processing Payments with Stripe"
// http://www.larryullman.com/series/processing-payments-with-stripe/
// Last updated April 14, 2015

// This page sets some global properties and defines one or more functions.
// This page is intended to be stored in a protected "includes" directory.

// Define useful constants:
//define('STRIPE_PRIVATE_KEY', 'las;dkjf2l3;nslkj');
//define('STRIPE_PUBLIC_KEY', 'Lln;4k2;(jas;ldfkj)');

define('STRIPE_PRIVATE_KEY', 'sk_test_pbqQkMXjItzU13bUDs6gpQ0A');
define('STRIPE_PUBLIC_KEY', 'pk_test_3Ci2I2B1R5q9apb3qmKPGWQx');

require_once('../sdk/vendor/autoload.php');