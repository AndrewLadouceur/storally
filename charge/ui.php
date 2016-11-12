<?php

require_once('configuration.php');
require_once("../inc/functions.php");
require_once('../inc/lib_stripe/init.php');

class ChargeUI {

	public static function header() {
		$SITE_URL = SITE_URL;
		$STRIPE_PUBLIC_KEY = STRIPE_PUBLIC_KEY;

		$form = '$form'; # replaces $form => $form in EOT tags (sorry for horrible hack)

		return <<<EOT
<script type="text/javascript" src="{$SITE_URL}/js/jquery.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token ID form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken">').val(token));

    // Submit the form:
    $form.get(0).submit();
  }
};
Stripe.setPublishableKey('$STRIPE_PUBLIC_KEY');
$(function() {
  var $form = $('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});
</script>
EOT;
	}

	public static function generateToken() {
		$token = bin2hex(openssl_random_pseudo_bytes(20, $strength));
		if(!$strength) {
			list($usec, $sec) = explode(' ', microtime());
			$seed = (float) $sec + ((float) $usec * 100000);
			srand($seed);
			$token = rand(); // better generate something
		}
		return $token;
	}

	public static function csrf_generate_token($csrf_prefix="") {
		$token = ChargeUI::generateToken();
		if(!isset($_SESSION)) {
			@session_start();
		}
		$_SESSION[$csrf_prefix . '_csrf_token'] = $token;
		return $token;
	}

	public static function form($redirect) {

		$csrf_token = ChargeUI::csrf_generate_token("charge");
		$SITE_URL = SITE_URL;

		return <<<EOT
<form action="$SITE_URL/charge/charge.php?redirect=$redirect" method="POST" id="payment-form">
  <span class="payment-errors"></span>

  <div class="form-row">
    <label>
      <span>Card Number</span>
      <input type="text" size="20" data-stripe="number">
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>Expiration (MM/YY)</span>
      <input type="text" size="2" data-stripe="exp_month">
    </label>
    <span> / </span>
    <input type="text" size="2" data-stripe="exp_year">
  </div>

  <div class="form-row">
    <label>
      <span>CVC</span>
      <input type="text" size="4" data-stripe="cvc">
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>Card Holder Name:</span>
      <input type="text" size="20" data-stripe="name">
    </label>
  </div>

  <input type="hidden" name="csrf_token" value="$csrf_token" />

  <input type="submit" class="submit" value="Submit Payment">
</form>
EOT;
	}

	// checks user credentials, whether user logged in or not
	// if $csrf_token is provided it also checks for csrf
	public static function checkCredentials($csrf_token="", $csrf_prefix="") {
		if(!isset($_SESSION)) {
			@session_start();
		}

		if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
			@header("Location:".SITE_URL."/login.php");
		}

		if($csrf_token != "") {
			if(!isset($csrf_token) || $_POST['csrf_token'] != $_SESSION[$csrf_prefix . '_csrf_token']) {
				die('invalid form credentials');
			}
			unset($_SESSION[$csrf_token . '_csrf_token']); // delete csrf token to prevent double charges (1st step of double charge protection)
		}
	}

	public static function checkStripeID() {
		require_once('../inc/lib_stripe/init.php');
		require_once('../inc/functions.php');

		$user = new Functions;
		$customerID = $user->getField("stripe_id");
		if($customerID == "") {
			die('please register credit card!');
		} else {
			return $customerID;
		}
	}

	public static function validate($amount_in_cents, $desc="") {

		ChargeUI::checkCredentials($_POST['csrf_token'], "charge");

		if(!isset($_POST['stripeToken'])) {
			die('invalid form');
		}

		$stripeToken = $_POST['stripeToken'];

		require_once('../inc/lib_stripe/init.php');
		require_once('../inc/functions.php');
		$user = new Functions;

		\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$customerID = $user->getField("stripe_id");
		if($customerID == "") {
			// Create a Customer
			$customer = \Stripe\Customer::create(array(
				"source" => $stripeToken,
				"description" => "Created by Storally charging module",
				"email" => $user->getField('email'),
				"metadata" => array("user_id" => $_SESSION['user_id'])
			));
			$customerID = $customer->id;
			$user->updateField("stripe_id", $customerID);
			return $customer->default_source;
		} else {
			$customer = \Stripe\Customer::retrieve($customerID);
			return ChargeUI::createCard($stripeToken)->id;
		}

	}

	public static function getCustomer() {
		ChargeUI::checkCredentials();
		require_once('../inc/lib_stripe/init.php');
		require_once('../inc/functions.php');
		$user = new Functions;

		$stripeID = ChargeUI::checkStripeID();
		\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$customer = \Stripe\Customer::retrieve($stripeID);
		return $customer;
	}

	public static function createCard($stripeToken) {
		try {
			$credit_card = $customer->sources->create(array("source" => $stripeToken));
			return $credit_card;
		} catch(\Stripe\Error\Card $e) {
			$body = $e->getJsonBody();
			$err  = $body['error'];

			print('Status is:' . $e->getHttpStatus() . "\n");
			print('Type is:' . $err['type'] . "\n");
			print('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			print('Param is:' . $err['param'] . "\n");
		}
	}

	public static function deleteCard($card_id) {
		$customer = ChargeUI::getCustomer();
		$customer->sources->retrieve($card_id)->delete();
	}

	public static function changeDefaultSource($card_id) {
		$customer = ChargeUI::getCustomer();

		$customer->default_source = $card_id;
		$customer->save();
	}

	public static function payWithCard($card_id, $amount_in_cents, $currency, $desc="") {
		$customer = ChargeUI::getCustomer();
		// Create the charge on Stripe's servers - this will charge the user's card
		try {
			\Stripe\Charge::create(array(
				"amount" => $amount_in_cents, 
				"currency" => $currency,
				"customer" => $customer->id,
				"source" => $card_id,
				"description" => $desc
			), array(
				"idempotency_key" => $card_id . $customerID . ChargeUI::generateToken(), // 2nd step of preventing double charges (1st step is csrf token which is changed with everyform.)
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
	}

	public static function payWithDefaultCard($amount_in_cents, $desc="") {
		$customer = ChargeUI::getCustomer();
		ChargeUI::payWithCard($customer->default_source, $amount_in_cents, $desc);
	}

	public static function createAllyAccount() {
		$managedAccount = \Stripe\Account::create(
			array(
			"country" => "US",
			"managed" => true
			)
		);

		require_once("../inc/functions.php");
		$f = new Functions;
		$f->o->insert("managed_accounts", array("stripe_id" => $$managedAccount->id, "publishable_key" => $managedAccount->keys->publishable, "private_key" => $managedAccount->keys->private, "user_id" => $_SESSION["user_id"]));
		
	}

	public static function subscription_start($user_id, $payment_method, $renewal_interval, $ally_user_id, $amount, $currency, $message="", $reason="") {
		$f = new Functions;
		$f->o->insert("subscriptions",
			array(
				"user_id" => $user_id,
				"renewal_interval" => $renewal_interval,
				"next_payment" => time() + $renewal_interval,
				"payment_method" => $payment_method,
				"started" => time(),
				"message" => $message,
				"start_reason" => $reason,
				"amount" => $amount,
				"currency" => $currency,
				"ally_user_id" => $ally_user_id
			)
		);
	}

	public static function subscription_end($subscription_id) {
		$f = new Functions;
		\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$f->o->where("subscription_id", $subscription_id);
		$f->o->update("subscriptions", array("active" => 0));

		$f->o->where("subscription_id", $subscription_id);
		$sub = $f->o->getOne("subscriptions");

		$f->o->where("id", $sub["user_id"]);
		$storee = $f->o->getOne("users");

		\Stripe\Charge::create(array(
			"amount" => (int)((time() - $sub["last_payment"]) * $sub["amount"]/$sub["renewal_interval"]), 
			"currency" => $sub["currency"],
			"customer" => $storee["stripe_id"],
			"source" => $sub["payment_method"],
			"description" => "Payment to Storally"
		), array(
			"idempotency_key" => ChargeUI::generateToken(), // 2nd step of preventing double charges (1st step is csrf token which is changed with everyform.)
		));

		$f->o->where("user_id", $sub["ally_user_id"]);
		$ally = $f->o->getOne("ally2");

		\Stripe\Transfer::create(array(
		  "amount" => (int)((time() - $sub["last_payment"]) * $sub["amount"]/$sub["renewal_interval"]) * 0.9,
		  "currency" => $sub["currency"],
		  "destination" => $ally["stripe_id"],
		  "description" => "Transfer from Storally"
		));
	}

}

?>