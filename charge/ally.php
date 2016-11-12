<?php
if(!isset($_SESSION)) {
	@session_start();
}

if(!isset($_SESSION["user_id"]) or $_SESSION["user_id"] == "") {
	die("invalid credentials");
}

require_once('configuration.php');
require_once("./inc/lib_stripe/init.php");
require_once("./inc/functions.php");
$f = new Functions;
class Ally {

	public static function updateInformation($column_name) {

	}

	public static function getInformation($user_id) {
		$user = Functions::$f;
		$user->o->where("user_id", $user_id);
		return $user->o->getOne("ally2");
	}
	
	public static function create($country="", $state="", $city = "", $postal_code="", $addr1="", $addr2="", $personal_id_number="") {
		\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$user = Functions::$f;

		$allyInformation = Ally::getInformation($_SESSION["user_id"]);
		if($country == "US") {
			$stripeAccount = \Stripe\Account::create(array(
					  "managed" => true,
					  "country" => $country,
					  "email" => $user->getField("email"),
					  "tos_acceptance" => array(
					  	"date" => time(),
					  	"ip" => $_SERVER["REMOTE_ADDR"]
					  ),
					  "legal_entity" => array(
					  	"type" => "individual",
					  	"first_name" => $user->getField("first_name"),
					  	"last_name" => $user->getField("last_name"),
					  	"dob" => array(
					  		"day" => $user->getField("birth_day"),
					  		"month" => $user->getField("birth_month"),
					  		"year" => $user->getField("birth_year")
					  	),
					  	"address" => array(
					  		"city" => $city,
					  		"line1" => $addr1,
					  		"line2" => $addr2,
					  		"postal_code" => $postal_code,
					  		"state" => $state
					  	),
					  	"ssn_last_4" => $personal_id_number
					  )
			));
		} else {
			$stripeAccount = \Stripe\Account::create(array(
					  "managed" => true,
					  "country" => $country,
					  "email" => $user->getField("email"),
					  "tos_acceptance" => array(
					  	"date" => time(),
					  	"ip" => $_SERVER["REMOTE_ADDR"]
					  ),
					  "legal_entity" => array(
					  	"type" => "individual",
					  	"first_name" => $user->getField("first_name"),
					  	"last_name" => $user->getField("last_name"),
					  	"dob" => array(
					  		"day" => $user->getField("birth_day"),
					  		"month" => $user->getField("birth_month"),
					  		"year" => $user->getField("birth_year")
					  	),
					  	"address" => array(
					  		"city" => $city,
					  		"line1" => $addr1,
					  		"line2" => $addr2,
					  		"postal_code" => $postal_code,
					  		"state" => $state
					  	),
					  	"personal_id_number" => $personal_id_number
					  )
			));
		}

		$user->o->insert("ally2", array(
			"user_id" => $_SESSION["user_id"],
			"stripe_id" => $stripeAccount->id,
			"private_key" => $stripeAccount->keys->secret,
			"public_key" => $stripeAccount->keys->publishable
		));
	}

	public static function update($state="", $city = "", $postal_code="", $addr1="", $addr2="", $personal_id_number="") {
		\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$allyInformation = Ally::getInformation($_SESSION["user_id"]);
		$account = \Stripe\Account::retrieve($allyInformation["stripe_id"]);
		$account->legal_entity->address->state = $state;
		$account->legal_entity->address->city = $city;
		$account->legal_entity->address->postal_code = $postal_code;
		$account->legal_entity->address->line1 = $addr1;
		$account->legal_entity->address->line2 = $addr2;
		if($personal_id_number != "") {
			$account->legal_entity->personal_id_number = $personal_id_number;
		}
		$account->save();
	}

	public static function addSpace($params) {
		$sizes = array("sm", "md", "lg", "xl");
		$sizeNames = array(
			"sm" => "Small",
			"md" => "Medium",
			"lg" => "Large",
			"xl" => "Extra Large"
		);
		$errors = array();
		$allowedSizes = array();
		$ratesW = array();
		$ratesM = array();
		$numberOfAvailableSizes = 0;
		foreach($sizes as $size) {
			if(@$_POST[$size."_item_size"] == "on") {
				$numberOfAvailableSizes++;
				$allowedSizes[$size] = true;
				if($_POST["weekly_storage_".$size] == "on") {
					if(@$_POST["weekly_rate_int_".$size] == "" or !is_numeric($_POST["weekly_rate_int_".$size])) {
						$errors[] = "Weekly rate of ".$sizeNames[$size]." must be numeric.";
					} else {
						$user_price = explode(".", $_POST["weekly_rate_int_".$size]);
						if(count($user_price) > 2) {
							$errors[] = "Invalid formatting in weekly rate of ".$sizeNames[$size];
						} else {
							if(count($user_price) == 1) {
								$dec = "0";
								$int = $user_price[0];
							} else {
								$int = $user_price[0];
								$dec = $user_price[1];
								if(strlen($dec) == 1) {
									$dec .= "0";
								}
							}
							$ratesW[$size."_price_weekly"] = intval($int) * 100 + intval(substr($dec, 0, 2));
							if($ratesW[$size."_price_weekly"] <= 0) {
								$errors[] = "Weekly rate of ".$sizeNames[$size]." must be bigger than zero.";
							}
						}
					}
				} else {
					$ratesW[$size] = 0;
				}

				if($_POST["monthly_storage_".$size] == "on") {
					if($_POST["monthly_rate_int_".$size] == "" or !is_numeric($_POST["monthly_rate_int_".$size])) {
						$errors[] = "Monthly rate of ".$sizeNames[$size]." must be numeric.";
					} else {
						$user_price = explode(".", $_POST["monthly_rate_int_".$size]);
						if(count($user_price) > 2) {
							$errors[] = "Invalid formatting in monthly rate of ".$sizeNames[$size];
						} else {
							if(count($user_price) == 1) {
								$dec = "0";
								$int = $user_price[0];
							} else {
								$int = $user_price[0];
								$dec = $user_price[1];
								if(strlen($dec) == 1) {
									$dec .= "0";
								}
							}
							$ratesM[$size."_price_monthly"] = intval($int) * 100 + intval(substr($dec, 0, 2));
							if($ratesM[$size."_price_monthly"] <= 0) {
								$errors[] = "Monthly rate of ".$sizeNames[$size]." must be bigger than zero.";
							}
						}
					}
				} else {
					$ratesM[$size] = 0;
				}
			} else {
				$allowedSizes[$size] = false;
				$ratesW[$size."_price_weekly"] = 0;
				$ratesM[$size."_price_monthly"] = 0;
			}
		}

		if($numberOfAvailableSizes == 0) {
			$errors[] = "You must allow one of the available sizes for storage.";
		}

		if($_POST["pickup_type"] == "y") {
			if($_POST["pickup_charge_int"] == "" or !is_numeric($_POST["pickup_charge_int"])) {
				$errors[] = "Pickup charge must be numerşc.";
			} else {
				$user_price = explode(".", $_POST["pickup_charge_int"]);
				if(count($user_price) > 2) {
					$errors[] = "Invalid formatting in pickup charge";
				} else {
					if(count($user_price) == 1) {
						$dec = "0";
						$int = $user_price[0];
					} else {
						$int = $user_price[0];
						$dec = $user_price[1];
						if(strlen($dec) == 1) {
							$dec .= "0";
						}
					}
					$pickupCharge = intval($int) * 100 + intval(substr($dec, 0, 2));
					if($pickupCharge <= 0) {
						$errors[] = "Pickup charge must be bigger than zero.";
					}
				}
			}
		} else {
			$pickupCharge = 0;
		}

		if($_POST["deliver_type"] == "y") {
			if($_POST["deliver_charge_int"] == "" or !is_numeric($_POST["deliver_charge_int"])) {
				$errors[] = "Delivery charge must be integer.";
			} else {
				$user_price = explode(".", $_POST["deliver_charge_int"]);
				if(count($user_price) > 2) {
					$errors[] = "Invalid formatting in delivery charge";
				} else {
					if(count($user_price) == 1) {
						$dec = "0";
						$int = $user_price[0];
					} else {
						$int = $user_price[0];
						$dec = $user_price[1];
						if(strlen($dec) == 1) {
							$dec .= "0";
						}
					}
					$deliveryCharge = intval($int) * 100 + intval(substr($dec, 0, 2));
					if($deliveryCharge <= 0) {
						$errors[] = "Delivery charge must be bigger than zero.";
					}
				}
			}
		} else {
			$deliveryCharge = 0;
		}

		if($_POST["us2-address"] == "") {
			$errors[] = "Please enter an address, or find it in the map.";
		}

		if(!isset($_POST["currency"]) or $_POST["currency"] == "") {
			$errors[] = "Invalid currency";
		}

		if(!is_numeric($_POST["us2-lat"]) or !is_numeric($_POST["us2-lon"])) {
			$errors[] = "Coordinates must be numbers, please find your place in the map and it will automatically generate coordinates.";
		}

		if($_POST["liable_box"] != "on") {
			$errors[] = "Before becoming ally you need to confirm you are liable for the Storee's belongings for the storage time period.";
		}

		if(count($errors) > 0) {
			return array(false, $errors);
		} else {
			$user = Functions::$f;

			$user->o->insert("spaces", array_merge(array(
				"user_id" => $_SESSION["user_id"],
				"address" => $_POST["us2-address"],
				"address_details" => $_POST["address-detail"],
				"latitude" => $_POST["us2-lat"],
				"longitude" =>  $_POST["us2-lon"],
				"pickup_charge" => $pickupCharge,
				"delivery_charge" => $deliveryCharge,
				"added" => time(),
				"currency" => $_POST["currency"]
			), $ratesW, $ratesM));
			return array(true, array("Space is succesfully added."));
		}
	}

}