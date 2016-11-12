<?php

require_once("ui.php");
require_once('../inc/lib_stripe/init.php');

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$f = new Functions;
$f->o->where("next_payment", time(), "<=");
$f->o->where("active", 1);

$subscriptions = $f->o->get("subscriptions");

foreach($subscriptions as $sub) {
	$f->o->where("subscription_id", $sub["subscription_id"]);
	$f->o->update("subscriptions", array(
		"next_payment" => time() + $sub["renewal_interval"],
		"last_payment" => time(),
		"total_paid" => $sub["total_paid"] + $sub["amount"]
	));

	$f->o->where("id", $sub["user_id"]);
	$storee = $f->o->getOne("users");

	$offset = 0;
	if($sub["renewal_interval"] <= 7 * 24 * 60 * 60) {
		$offset = 150; // ad 1.5$ if subscription renewal interval is less than or equal to a week
	}

	try{
		\Stripe\Charge::create(array(
			"amount" => $sub["amount"] + $offset, 
			"currency" => $sub["currency"],
			"customer" => $storee["stripe_id"],
			"source" => $sub["payment_method"],
			"description" => "Payment to Storally"
		), array(
			"idempotency_key" => ChargeUI::generateToken(), // 2nd step of preventing double charges (1st step is csrf token which is changed with everyform.)
	));
	} catch(\Stripe\Error\Card $e) {
		// Since it's a decline, \Stripe\Error\Card will be caught
		$body = $e->getJsonBody();
		$err  = $body['error'];

		print('Status is:' . $e->getHttpStatus() . "\n");
		print('Type is:' . $err['type'] . "\n");
		print('Code is:' . $err['code'] . "\n");
		// param is '' in this case
		print('Param is:' . $err['param'] . "\n");
		print('Message is:' . $err['message'] . "\n");
	} catch (\Stripe\Error\RateLimit $e) {
		// Too many requests made to the API too quickly
		die('too many requests are being made please wait and try again');
	} catch (\Stripe\Error\InvalidRequest $e) {
		// Invalid parameters were supplied to Stripe's API
		die('invalid parameters are given please try again');
	} catch (\Stripe\Error\Authentication $e) {
		// Authentication with Stripe's API failed
		// (maybe you changed API keys recently)
		die('unexpected error please try again');
	} catch (\Stripe\Error\ApiConnection $e) {
		// Network communication with Stripe failed
		die('unexpected error please try again');
	} catch (\Stripe\Error\Base $e) {
		// Display a very generic error to the user, and maybe send
		// yourself an email
		die('unexpected error please try again');
	} catch (Exception $e) {
		// Something else happened, completely unrelated to Stripe
		die('unexpected error please try again');
	}

	$f->o->where("user_id", $sub["ally_user_id"]);
	$ally = $f->o->getOne("ally2");

	if($ally["first_transaction"] == 0) {
		$f->o->where("ally_id", $ally["ally_id"]);
		$f->o->update("ally2", array("first_transaction" => 1));
	}

	\Stripe\Transfer::create(array(
	  "amount" => $sub["amount"] * 0.9,
	  "currency" => $sub["currency"],
	  "destination" => $ally["stripe_id"],
	  "description" => "Transfer from Storally"
	));

}

?>