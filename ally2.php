<?php
/**
 * @Author: eavci
 * @Date:   2016-08-12
 * @Last Modified by:   eavci
 * @Last Modified time: 2016-08-12
 */

	require_once 'inc/conf.php';
	require_once 'inc/mysqli.php';
	require_once 'inc/functions.php';

	function show_form_value($fieldName, $else="") {
		if(isset($_POST[$fieldName])) {
			echo htmlspecialchars($_POST[$fieldName]);
		} else {
			echo $else;
		}
	}

	$f = new Functions();
	$f->checkSession();
	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}
	if (!$f->isPhoneVerified())
	{
		header("Location: verify.php");
	}
	if ($f->isAlly())
	{
		$title = "Ally Info";
	} else {
		$title = "Become an Ally";
	}

	$pages = array(
		"general_view" => "General View",
		"update_ally" => "Update Ally Information",
		"update_payment" => "Update Payment Information",
		"add_space" => "Add Space",
		"spaces" => "Spaces",
		"show_requests" => "Requests for Storage",
		"stored_items" => "Stored Items"
	);

	$include = "";
	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<link href="css/ally.css" type="text/css" rel="stylesheet">';
	$include .= '<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/locationpicker.jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/ally.js"></script>';

$f->o->where("user_id", $_SESSION["user_id"]);
if($f->o->getOne("ally2") == NULL) {
	$err_msg = "";
	if(isset($_GET["act"]) and $_GET["act"] == "submit_ally") {
		if($_POST["agreement_box"] != "on") {
			$err_msg .= "Before becoming ally you need to read and agree to the terms.";
		}
		if($err_msg == "" and (isset($_POST["country"]) and ($_POST["country"] == "CA" or $_POST["country"] == "US"))) {
			require_once("charge/ally.php");
			try {
				Ally::create($_POST["country"], $_POST["state"], $_POST["city"], $_POST["postal_code"], $_POST["addr1"], $_POST["addr2"], $_POST["personal_id"]);
				/* redirecting new ally page since there are no errors.. */
				@header("Location:ally2.php?act=new_ally");
			} catch (\Stripe\Error\InvalidRequest $e) {
				$body = $e->getJsonBody();
				$err_msg .= $body['error']['message'];
			} catch (Exception $e) {
				$err_msg = "Unexpected error happened, please try again.";
				// log it in the future if it becomes necessary.
			}
		}
	}

		$include .= <<<EOT
<script type="text/javascript">

function countrySelected() {
	var country_value = document.getElementById("country_select").value;
	document.getElementById("country-specific-fields").innerHTML = document.getElementById("country-specific-fields-" + country_value).innerHTML;
	document.getElementById("ally-submit-button").disabled = false;
	var country_x = document.getElementById("country_select_x");
	country_x.parentNode.removeChild(country_x);
}

</script>
EOT;
	if($err_msg != "") {
		if($err_msg == "Not a valid day") {
			$err_msg = "Not a valid birthday, please update your birthday information.";
		}

		$include .= '
<script type="text/javascript">
window.onload = function() {
	sweetAlert("", "'.$err_msg.'", "error");
	document.getElementById("country_select_'. $_POST["country"] .'").selected = "selected";
	countrySelected();
	$("#state").val("'.$_POST["state"].'");
}
</script>
';
	}
	require_once 'header.php';

?>

<center>
<div id="ally-registration-intro" class="intro">
	<br /><br /><br /><br /><p class='msg'> Ally Registration </p>
</div>
<div id="ally-registration-wrap" class="wrap">
	<form method="POST" action="ally2.php?act=submit_ally" onsubmit='sweetAlert({title:"We are creating your ally account.", text:"", type:"info",  showConfirmButton: false});'>
		<div id="ally-registration-country">
			<div id="ally-registration-country-title">Country:</div>
			<select id="country_select" name="country" class="weekly" onchange="countrySelected();">
				<option id="country_select_x" value="-">-</option>

				<option id="country_select_CA" value="CA">Canada</option>
				<option id="country_select_US" value="US">USA</option>
			</select>
		</div>
		<br />
		<div id="common-fields">
			<div id="ally-registration-common-field-info">(If the credentials below are incorrect, please update them under <a href="profile.php">profile</a>)</div>
			<div id="ally-registration-common-field-fn">First Name: <br /> <?php echo $f->getField("first_name") ?></div>
			<div id="ally-registration-common-field-ln">Last Name: <br /> <?php echo $f->getField("last_name") ?></div>
			<div id="ally-registration-common-field-dob">Date of Birth (D / M / Y): <br /> <?php echo $f->getField("birth_day") . " / " . $f->getField("birth_month") . " / " . $f->getField("birth_year") ?> </div>
		</div>
		<br />
		<div id="country-specific-fields">
		</div>
		<div id="ally-submit">
			<div id="ally-registration-submit-city">City: <br /> <input name="city" type="text" class="text monthly" value="<?php show_form_value("city") ?>" /> </div>
			<br />
			<div id="ally-registration-submit-postal-code">Postal Code: <br /> <input name="postal_code" type="text" class="text monthly" value="<?php show_form_value("postal_code") ?>" /> </div>
			<br />
			<div id="ally-registration-submit-address">Address: <br /> <input name="addr1" type="text" class="text monthly" value="<?php show_form_value("addr1") ?>" /> <br /> <input name="addr2" type="text" class="text monthly" value="<?php show_form_value("addr2") ?>" /> </div>
			<br />
			<input type="checkbox" name="agreement_box" id="agreement_box" /> <label for="agreement_box">  I have read and agree to the <a href="agreement.php" target="_blank">Terms and Conditions</a> </label>
			<br />
			<input id="ally-submit-button" type="submit" class="submit_button " disabled="true"/>
		</div>
	</form>
		<div id="country-specific-fields-CA" style="display:none">
				<div id="country-specific-field-pid">Personal ID Number <a style="color:#39c; text-decoration:none; cursor:pointer;" onclick="swal({title:'SSN / SIN / ITIN', text:'We use <a href=\'https://stripe.com\' target=\'blank_\'>Stripe</a> for our payment infrastructure and part of their responsibilities to their financial partners involves verifying your identity and confirming your legitimacy as an Ally. Collecting this information enables them to automate parts of this process so that you can start running charges immediately.<br/>Please enter your 9 digit SIN.*<br />*STORALLY DOES NOT STORE THIS INFORMATION ON ITS SERVERS OR USE THIS INFORMATION FOR ANY OTHER PURPOSE. WE TAKE YOUR PRIVACY AND THE SECURITY OF YOUR DATA VERY SERIOUSLY.', html:true, type:'info'});">[?]</a> :<br /> <input name="personal_id" type="text" class="text monthly" value="<?php show_form_value("personal_id") ?>" maxlength="9"/> </div>	<br />
			<div id="country-specific-fields-ca-province">Province: <br />
				<select id="state" name="state" class="weekly">
					<option value="AB">Alberta</option>
					<option value="BC">British Columbia</option>
					<option value="MB">Manitoba</option>
					<option value="NB">New Brunswick</option>
					<option value="NL">Newfoundland and Labrador</option>
					<option value="NS">Nova Scotia</option>
					<option value="ON">Ontario</option>
					<option value="PE">Prince Edward Island</option>
					<option value="QC">Quebec</option>
					<option value="SK">Saskatchewan</option>
					<option value="NT">Northwest Territories</option>
					<option value="NU">Nunavut</option>
					<option value="YT">Yukon</option>
				</select>
			</div>
			<br />
		</div>
		<div id="country-specific-fields-US" style="display:none">
			<div id="country-specific-field-pid">Last 4 Digits of SSN: <a style="color:#39c; text-decoration:none; cursor:pointer;" onclick="swal({title:'SSN / SIN / ITIN', text:'We use <a href=\'https://stripe.com\' target=\'blank_\'>Stripe</a> for our payment infrastructure and part of their responsibilities to their financial partners involves verifying your identity and confirming your legitimacy as an Ally. Collecting this information enables them to automate parts of this process so that you can start running charges immediately.<br/>Please enter the last four digits of your SSN/ITIN.*<br />*STORALLY DOES NOT STORE THIS INFORMATION ON ITS SERVERS OR USE THIS INFORMATION FOR ANY OTHER PURPOSE. WE TAKE YOUR PRIVACY AND THE SECURITY OF YOUR DATA VERY SERIOUSLY.', html:true, type:'info'});">[?]</a> :<br /> <input name="personal_id" type="text" class="text monthly" value="<?php show_form_value("personal_id") ?>" maxlength="4"/> </div>
			<div id="country-specific-fields-us-state"> 
				State: <br />
				<select id="state" class="weekly" name="state">
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>
			</div>
			<br />
		</div>
	</form>
</div>
</center>
<?php
} else {
		require_once 'charge/ally.php';
	
	$f->o->where("user_id", $_SESSION["user_id"]);
	$allyAccount = $f->o->getOne("ally2");
	\Stripe\Stripe::setApiKey($allyAccount["private_key"]);
	$balance = \Stripe\Balance::retrieve();
	$balanceHistory = \Stripe\BalanceTransaction::all(array("limit" => 10));
	\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
	$stripeAccount = \Stripe\Account::retrieve($allyAccount["stripe_id"]);


	if(@$_GET['act'] == "new_ally" or @$_GET['act'] == "submit_ally") {
				$include .= '
<script type="text/javascript">
window.onload = function() {
	sweetAlert("Your ally account has been created.", "You can control your ally account in this page. ", "success");
}
</script>';
	}
	$include .= '
<style>
.verified {
	color:#78AB46;
}

.pending {
	color:#BE2625;
}
</style>
';

	if(isset($_GET['act']) && @$_GET["act"] == "update_ally") {
		$err_msg = "";
		$include .= '<script type="text/javascript">$(document).ready(function(){document.getElementById("country-specific-fields").innerHTML = document.getElementById("country-specific-fields-'.$stripeAccount->country.'").innerHTML;$("#state-'.$stripeAccount->country.'").val("'.$stripeAccount->legal_entity->address->state.'"); });</script>';
		if(isset($_POST["country"]) and ($_POST["country"] == "CA" or $_POST["country"] == "US")) {
			try {
				if( $_POST["personal_id"] == "*" ) {
					$personal_id = "";
				} else {
					$personal_id =  $_POST["personal_id"];
				}
				Ally::update($_POST["state"], $_POST["city"], $_POST["postal_code"], $_POST["addr1"], $_POST["addr2"], $personal_id);
				/* redirecting new ally page since there are no errors.. */
				$include .= "<script>$(document).ready(function(){swal('Updated!', 'Your information updated successfully.', 'success');});</script>";
			} catch (\Stripe\Error\InvalidRequest $e) {
				$body = $e->getJsonBody();
				$err_msg = $body['error']['message'];
			} catch (Exception $e) {
				$err_msg = "Unexpected error happened, please try again.";
				// log it in the future if it becomes necessary.
			}
				$include .= '
<script type="text/javascript">
window.onload = function() {
	'. ($err_msg == "" ? "" : 'sweetAlert("", "'.$err_msg.'", "error");') . '
	document.getElementById("country_select_'. (isset($_POST["country"]) ? $_POST["country"] : $stripeAccount->country) .'").selected = "selected";
	countrySelected();
	$("#state").val("'. (isset($_POST["state"]) ? $_POST["state"] : $stripeAccount->legal_entity->address->state) .'");
}
</script>
';
		}
	} else if(@$_GET["act"] == "update_payment") {
		$include .= '<script type="text/javascript" src="https://js.stripe.com/v2/"></script>';
		$include .= '<script type="text/javascript">
Stripe.setPublishableKey("'.STRIPE_PUBLIC_KEY.'");
function stripeResponseHandler(status, response) {
    if (response.error) {
        // re-enable the submit button
        $(\'.submit-button\').removeAttr("disabled");
        // show the errors on the form
        console.log(response.error);
        $(".payment-success").html("");
        $(".payment-errors").html(response.error.message);
        swal.close();
    } else {
        var $form = $("#bank-account-form");
        // token contains id, last4, and card type
        var token = response[\'id\'];
        // insert the token into the form so it gets submitted to the server
        $form.append("<input type=\'hidden\' name=\'stripeToken\' value=\'" + token + "\' />");
        // and submit
        $form.get(0).submit();
        $(".payment-errors").html("");
        $(".submit-button").removeAttr("disabled");
    }
}
$(document).ready(function () {
    $("#bank-account-form").submit(function (event) {
        // disable the submit button to prevent repeated clicks
        $(".submit-button").attr("disabled", "disabled");
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        Stripe.bankAccount.createToken({
            country: "'. $stripeAccount->country .'",
            currency: $(".currency").val(),
            routing_number: $(".routing-number").val(),
            account_number: $(".account-number").val(),
        		account_holder_name: $(".account-holder-name").val(),
            account_holder_type: "individual"
        }, stripeResponseHandler);
        return false; // submit from callback
    });
});
</script>';
		if(@$_POST["stripeToken"] != "") {
			$err_msg = "";
			try {
				$stripeAccount->external_account = $_POST["stripeToken"];
				$stripeAccount->save();
			} catch (Exception $e) {
				$err_msg = "Unexpected error happened, please try again.";
			}
			if($err_msg != "") {
				echo '<script type="text/javascript"> $(document).ready(function(){sweetAlert("'.$err_msg.'", "", "error");}); </script>';
			}
		}
	} else if(@$_GET["act"] == "add_space") {
		$include .= '<script type="text/javascript">
function priceSizeManager(obj) {
	var size = obj.id.substr(0, 2);
	var relatedObject = document.getElementById("size_price_" + size)
	if(obj.checked) {
		relatedObject.style.display = "block";
	} else {
		relatedObject.style.display = "none";
	}
}

function timeIntervalController(obj) {
	var time = obj.id.substr(0, 1) == "w" ? "weekly" : "monthly";
	var size = obj.id.substr(obj.id.length - 2, 2);
	var relatedObject = document.getElementById(time + "_rate_con_" + size);
	if(obj.checked) {
		relatedObject.style.display = "block";
	} else {
		relatedObject.style.display = "none";
	}
}

function pickupForm(o, t, s) {
	var tO = document.getElementById(t + "_container");
	if(o.checked){
		tO.style.display = s;
	}
}
</script>
<style>
input.ally_rate {
	width:100px;
	font-size:14pt;
	border:2px solid #000;
}
input.ally_rate_dec {
	text-align:right;
}
</style>
';
		if(isset($_POST["form_submit"])) {
			list($status, $errors) = Ally::addSpace($_POST);

			if(!$status) {
				$err_msg = "";
				foreach($errors as $error) {
					$err_msg .= $error . '<br />';
				}
				$include .= '
	<script>
	$(document).ready(function() {
		swal({title: "There are following problems in information you provided:",   text: "'.$err_msg.'",   html: true, type:"error" })
	});
	</script>
	';
			} else {
				header("Location:ally2.php?act=spaces&ns=y");
			}
		}
	} else if($_GET["act"] == "spaces") {
		if(isset($_GET["ns"]) and $_GET["ns"] == "y") {
			$include .= '
<script>
$(document).ready(function(){
	swal("Space added!", "", "success");
});
</script>
';
		} else if($_GET["ns"] == "d" && isset($_GET["sid"]) && is_numeric($_GET["sid"])) {
			$f->o->where("space_id", $_GET["sid"]);
			$f->o->where("user_id", $_SESSION["user_id"]);
			$f->o->delete("spaces");
						$include .= '
<script>
$(document).ready(function(){
	swal("Space removed!", "", "success");
});
</script>
';
		}

		$include .= '<script>
function deleteSpace(id) {
	swal({title: "Are you sure to delete this space?",
		text: "You will not be able to recover space information.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		closeOnConfirm: false
	},
	function(){ 
		document.location = "ally2.php?act=spaces&ns=d&sid=" + id;
	});
}</script>
';
	}
	require_once 'header.php';
?>

<center>
<div id="ally-cp-intro" class="intro">
	<br /><br /><br /><br /><p class='msg'> Ally Control Panel - You can manage your Ally account in here. </p>
</div>
<div id="ally-c-wrap" class="wrap">
	<div id="control-links" style="float:left;width:250px;border-right:3px solid #16a085">
		<ul>
			<?php
				foreach($pages as $pid => $page) {
					if($_GET["act"] == $pid) {
						echo '<li style="padding:5px;">'.$page.'</li>';
					} else {
						echo '<li style="padding:5px;"><a href="?act='.$pid.'">'.$page.'</a></li>';
					}
				}
			?>
		</ul>
	</div>
	<div id="control-information" style="float:left;padding-left:5px;width:600px;">
		<?php 
		if(!isset($_GET["act"]) or $_GET["act"] == "general_view" or $_GET["act"] == "new_ally" or $_GET["act"] == "submit_ally" or $_GET["act"] == "") {
		?>
		<h2>Balance: <?php echo number_format($balance["available"][0]["amount"] / 100, 2)." ".strtoupper($balance["available"][0]["currency"]); // dividing by 100 may not be safe because of floating point representation?></h2>
		<hr />
		<h4>Verifications: <span class="<?php echo $f->getField("verified_phone") == "true" ? 'verified' : 'pending'?>">Account</span> - 
			<span class="<?php echo $stripeAccount->legal_entity->verification->status; ?>">Identity</span> - 
			<span class="<?php echo $stripeAccount->transfers_enabled ? 'verified' : 'pending'?>">Transaction</span></h4>
		<hr />
		<div id="ally-cp-account-info">
			<?php
			if(!$stripeAccount->transfers_enabled) {
				if($stripeAccount->disabled_reason != null) {
					echo "This account disabled because of the following reasons: <br />";
					echo "<ul style='margin-left:35px;'>";
					foreach($stripeAccount->disabled_reason as $reason) {
						echo "<li>";
						if($reason == "rejected.fraud") {
							echo "This account is rejected due to suspected fraud or illegal activity.";
						} else if($reason == "rejected.terms_of_service") {
							echo "This account is rejected due to suspected terms of service violations.";
						} else if($reason == "rejected.listed") {
							echo "This account is rejected due to a match on a third party prohibited persons or companies list (such as financial services provider or government).";
						} else if($reason == "rejected.other") {
							echo "This account is rejected for some other reason.";
						} else if($reason == "fields_needed") {
							echo "Additional verification information is required in order to enable transfer or charge capabilities on this account.";
						} else if($reason == "listed") {
							echo "This account might be a match on a prohibited persons or companies list. Stripe will investigate and either reject or reinstate the account appropriately.";
						} else if($reason == "other") {
							echo "This account is not rejected but disabled for other reasons.";
						}
						echo "</li>";
					}
					echo "</ul>";
				}
				if(count($stripeAccount->verification->fields_needed) > 0) {
					echo "To enable transaction following information(s) needed:";
					echo "<ul style='margin-left:35px;'>";
					foreach($stripeAccount->verification->fields_needed as $fields) {
						echo "<li>";
						if($fields == "external_account") {
							echo "Bank account information (can be updated using <a href='ally2.php?act=update_payment'>Update Payment Information</a>)";
						} else if($fields == "legal_entity.verification.document") {
							echo "Photo ID";
						}
						echo "</li>";
					}
					echo "</ul>";
				}
			} else {
			?>
			<div id="ally-cp-transfer-schedule" class="title">Transfer Schedule: <?php echo $stripeAccount->transfer_schedule->delay_days ?> Days.  <a style="color:#39c; text-decoration:none; cursor:pointer;" onclick="swal('Transfer Schedule','Transfer schedule indicates how often this Ally account’s balance is automatically paid out to its bank account.');">[?]</a></div>
			<?php 
			}
			?>
		</div>
		<?php // add balance history in the future
		} else if($_GET["act"] == "update_ally") {
?>
	<form method="POST" action="ally2.php?act=update_ally" onsubmit='sweetAlert({title:"We are updating your ally information.", text:"", type:"info",  showConfirmButton: false});'>
		<div id="ally-cp-update-country">
			<div id="ally-cp-update-country-title">Country (Cannot change):</div>
			<?php echo $stripeAccount->country == "US" ? "USA" : "Canada"; ?>
		</div>
		<div id="common-fields">
			<div id="ally-update-common-fields-info">(If the credentials below are incorrect, please update them under <a href="profile.php">profile</a>)</div>
			<div id="ally-update-common-fields-fn">First Name: <br /> <?php echo $f->getField("first_name") ?></div>
			<div id="ally-update-common-fields-ln">Last Name: <br /> <?php echo $f->getField("last_name") ?></div>
			<div id="ally-update-common-fields-dob">Date of Birth (D / M / Y): <br /> <?php echo $f->getField("birth_day") . " / " . $f->getField("birth_month") . " / " . $f->getField("birth_year") ?> </div>
			<br />
		</div>
		<div id="country-specific-fields">
		</div>
		<div id="ally-submit">
			<div id="ally-update-submit-city">City: <br /> <input name="city" type="text" class="text monthly" value="<?php show_form_value("city", $stripeAccount->legal_entity->address->city) ?>" /> </div>
			<br />
			<div id="ally-update-submit-postal-code">Postal Code: <br /> <input name="postal_code" type="text" class="text monthly" value="<?php show_form_value("postal_code", $stripeAccount->legal_entity->address->postal_code) ?>" /> </div>
			<br />
			<div id="ally-update-submit-address">Address: <br /> <input name="addr1" type="text" class="text monthly" value="<?php show_form_value("addr1", $stripeAccount->legal_entity->address->line1) ?>" /> <br /> <input name="addr2" type="text" class="text monthly" value="<?php show_form_value("addr2", $stripeAccount->legal_entity->address->line2) ?>" /> </div>
			<br />
			<input id="ally-submit-button" type="submit" class="submit_button "  disabled="true"/>
		</div>
	</form>
		<div id="country-specific-fields-CA" style="display:none">
			<div id="country-specific-field-pid">Personal ID Number <a style="color:#39c; text-decoration:none; cursor:pointer;" onclick="swal({title:'SSN / SIN / ITIN', text:'We use <a href=\'https://stripe.com\' target=\'blank_\'>Stripe</a> for our payment infrastructure and part of their responsibilities to their financial partners involves verifying your identity and confirming your legitimacy as an Ally. Collecting this information enables them to automate parts of this process so that you can start running charges immediately.<br/>Please enter your 9 digit SIN.*<br />*STORALLY DOES NOT STORE THIS INFORMATION ON ITS SERVERS OR USE THIS INFORMATION FOR ANY OTHER PURPOSE. WE TAKE YOUR PRIVACY AND THE SECURITY OF YOUR DATA VERY SERIOUSLY.', html:true, type:'info'});">[?]</a> :<br /> <input name="personal_id" type="text" class="text monthly" value="<?php show_form_value("personal_id") ?>" maxlength="9"/> </div>	<br />
			<div id="country-specic-fields-ca-province">Province: <br />
				<select id="state-CA" name="state" class="weekly">
					<option value="AB">Alberta</option>
					<option value="BC">British Columbia</option>
					<option value="MB">Manitoba</option>
					<option value="NB">New Brunswick</option>
					<option value="NL">Newfoundland and Labrador</option>
					<option value="NS">Nova Scotia</option>
					<option value="ON">Ontario</option>
					<option value="PE">Prince Edward Island</option>
					<option value="QC">Quebec</option>
					<option value="SK">Saskatchewan</option>
					<option value="NT">Northwest Territories</option>
					<option value="NU">Nunavut</option>
					<option value="YT">Yukon</option>
				</select>
			</div>
			<br />
		</div>
		<div id="country-specific-fields-US" style="display:none">
			<div id="country-specific-field-ssn4">Last 4 Digits of SSN: <a style="color:#39c; text-decoration:none; cursor:pointer;" onclick="swal({title:'SSN / SIN / ITIN', text:'We use <a href=\'https://stripe.com\' target=\'blank_\'>Stripe</a> for our payment infrastructure and part of their responsibilities to their financial partners involves verifying your identity and confirming your legitimacy as an Ally. Collecting this information enables them to automate parts of this process so that you can start running charges immediately.<br/>Please enter the last four digits of your SSN/ITIN.*<br />*STORALLY DOES NOT STORE THIS INFORMATION ON ITS SERVERS OR USE THIS INFORMATION FOR ANY OTHER PURPOSE. WE TAKE YOUR PRIVACY AND THE SECURITY OF YOUR DATA VERY SERIOUSLY.', html:true, type:'info'});">[?]</a> :<br /> <input name="personal_id" type="text" class="text monthly" value="<?php show_form_value("personal_id") ?>" maxlength="4"/> </div>
			<div id="country-specific-fields-us-state"> 
				State: <br />
				<select id="state-US" class="weekly" name="state">
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>
			</div>
			<br />
		</div>
	</form>
<?php
		} else if($_GET["act"] == "update_payment") {
			if($stripeAccount->external_accounts->total_count == 0) {
				echo "You need to provide bank information to enable us to transfer money.";
				$routing_number = "";
				$holder_name = $f->getField("fullname");
			} else {
				echo "<h3>Current bank information</h1>";
				$currentBank = $stripeAccount->external_accounts->data[0];
				echo "Bank Name: <br />". $currentBank->bank_name . "<br />";
				echo "Account Holder Name: <br />". $currentBank->account_holder_name . "<br />";
				echo "Routing Number: <br />". $currentBank->routing_number . "<br />";
				echo "Last 4 digits of the Account Number: <br />". $currentBank->last4 . "<br />";
				echo "<br /> <br /><h4><b>If you want to update your bank information, please use following form.</b></h4>";
				$routing_number = $currentBank->routing_number;
				$holder_name = $currentBank->account_holder_name;
			}
?>
<span class="payment-errors"></span>
<form action="?act=update_payment" method="POST" id="bank-account-form" onsubmit="sweetAlert({title:'We are updating your banking information...', text:'', type:'info',  showConfirmButton: false});">
    <div  id="ally-payment-update-country-title" class="form-row">
        Country: <?php echo $stripeAccount->country ?>
        <br />
    </div>
    <div id="ally-payment-update-currency-title" class="form-row">
        <label for="currency">Currency</label>
        <select class="currency">
            <option value="USD">US Dollar</option>
            <option value="CAD">Canadian Dollar</option>
        </select>
    </div>
    <br />
    <div id="ally-payment-update-routing-title" class="form-row">
        <label for="routing-number">Routing Number:</label> <br />
        <input type="text" class="routing-number" value="<?php echo $routing_number ?>" />
    </div>
    <br />
    <div id="ally-payment-update-account-number-title" class="form-row">
        <label for="account-number">Account Number:</label> <br />
        <input type="text" class="account-number" value="" />
    </div>
    <br />
    <div id="ally-payment-update-account-holder-name-title" class="form-row">
        <label for="account-holder-name">Account Holder Name:</label> <br />
        <input type="text" class="account-holder-name" value="<?php echo $holder_name ?>" />
    </div>
    <br />
    <button type="submit" class="submit-button submit_button" style="width:200px;float:left;">Update Banking Information</button>
</form>

<?php
		} else if($_GET["act"] == "add_space") {
			if(@$_POST["form_submit"] != "" && !$status) {
				echo "<div id='ally-add-space-error' style='text-weight:strong;'><div id='ally-add-space-encountered-problems'>Encountered problems:</div><div id='ally-add-space-problems-list' style='padding-left:10px;'>";
				echo $err_msg;
				echo "</div></div><br /><hr /><br />";
			}
?>
		<div id="ally-add-space-price-title" class="price">
			<form method="post" action="?act=add_space">
			<span class="title">Allowed Item Size: </span> <br />
			<input type="checkbox" name="sm_item_size" id="sm_item_size" onchange="priceSizeManager(this);" <?php if(isset($_POST["sm_item_size"]) or !isset($_POST["form_submit"])) { echo 'checked="checked"'; } ?>> <label for="sm_item_size"> Small ( 0 - 2.5 cu/ft ) </label> &nbsp;
			<input type="checkbox" name="md_item_size" id="md_item_size" onchange="priceSizeManager(this);" <?php if(isset($_POST["md_item_size"])) { echo 'checked="checked"'; } ?>> <label for="md_item_size"> Medium ( 2.5 - 6 cu/ft )</label> &nbsp; 
			<input type="checkbox" name="lg_item_size" id="lg_item_size" onchange="priceSizeManager(this);" <?php if(isset($_POST["lg_item_size"])) { echo 'checked="checked"'; } ?>> <label for="lg_item_size"> Large ( 6 - 8 cu/ft )</label> &nbsp; <br />
			<input type="checkbox" name="xl_item_size" id="xl_item_size" onchange="priceSizeManager(this);" <?php if(isset($_POST["xl_item_size"])) { echo 'checked="checked"'; } ?>> <label for="xl_item_size"> Extra Large ( 8+ cu/ft )</label> &nbsp;
			<a href="img/catalog.pdf" target="_blank">Rate Catalog for Sizes</a>
			<br /> <br />
			<hr />
			<div id="size_price">
			<?php
				$sizes = array("Small", "Medium", "Large", "Extra Large");
				$size_codes = array("sm", "md", "lg", "xl");
				$recommended_rates_wk = array("$5 - $8", "$8 - $12", "10$ - 15$", "$12 - $18");
				$recommended_rates_mt = array("$5 - $15", "$10 - 20$", "15$ - 25$", "20$ - 30$");
				$i = 0;
				while($i < count($sizes)) { ?>
				<div id="size_price_<?php echo $size_codes[$i] ?>" style="display:<?php echo ( ($size_codes[$i] == "sm" and !isset($_POST["form_submitted"])) or isset($_POST[$size_codes[$i]."_item_size"])) ? "block" : "none"; ?>;">
					<br />
					<span class="title"><?php echo $sizes[$i] ?> Size Rates</span> <br />
					<span class="">Allow for;</span> <br />
					<input type="checkbox" name="weekly_storage_<?php echo $size_codes[$i] ?>" id="weekly_storage_<?php echo $size_codes[$i] ?>" checked="checked" onchange="timeIntervalController(this);"/> <label for="weekly_storage_<?php echo $size_codes[$i] ?>">Weekly Storage</label> &nbsp; &nbsp;
					<input type="checkbox" name="monthly_storage_<?php echo $size_codes[$i] ?>" id="monthly_storage_<?php echo $size_codes[$i] ?>" checked="checked" onchange="timeIntervalController(this);"/> <label for="monthly_storage_<?php echo $size_codes[$i] ?>">Monthly Storage</label> <br /><br />
					<div id="weekly_rate_con_<?php echo $size_codes[$i] ?>">
						<span class="title" style="width:137px;height:45px;" >Weekly Rate:</span>
						<input type="text" name="weekly_rate_int_<?php echo $size_codes[$i] ?>" class="ally_rate ally_rate_dec" maxlength="5" value="<?php show_form_value('weekly_rate_int_'.$size_codes[$i]) ?>"/>
						<?php echo strtoupper($stripeAccount->default_currency); ?><br />
						<br />
					</div>
					<br />
					<div style="height:45px;" id="monthly_rate_con_<?php echo $size_codes[$i] ?>">
						<td style="width:137px;"><span class="title" style="width:137px;height:45px;" >Monthly Rate:</span></td>
						<input type="text" name="monthly_rate_int_<?php echo $size_codes[$i] ?>" class="ally_rate ally_rate_dec" maxlength="5" value="<?php show_form_value('monthly_rate_int_'.$size_codes[$i]) ?>" />
						<?php echo strtoupper($stripeAccount->default_currency); ?><br />
						<br />
					</div>
					<br />
					Weekly Recommended Rate: <?php echo $recommended_rates_wk[$i] ?> <br />
					Monthly Recommended Rate: <?php echo $recommended_rates_mt[$i] ?> <br />
					<br />
					<hr />
				</div>
			<?php
				$i++;
				}
			?>
			</div>
		</div>
		<br />
		<div id="ally-add-space-pickup-type" class="pickup_type">
			<div id="ally-add-space-pickup-type-title" class="title">Can you pickup storee's stuff?</div>
			<input type="radio" name="pickup_type" id="pickup_type_y" value="y" checked="checked" onchange="pickupForm(this, 'pickup', 'block');"/>
			<label for="pickup_type_y" checked="checked">Yes</label> &nbsp;
			<input type="radio" name="pickup_type" id="pickup_type_n" value="n" onchange="pickupForm(this, 'pickup', 'none');"/> 
			<label for="pickup_type_n">No</label> &nbsp;
			<br />
			<div id="pickup_container">
				<div id="pickup_container_charge" class="title">Pickup Charge: </div>
				<input type="text" name="pickup_charge_int" class="ally_rate ally_rate_dec" maxlength="5" value="<?php show_form_value('pickup_charge_int') ?>"/> <?php echo strtoupper($stripeAccount->default_currency); ?><br />
				Recommended Rate: $0 - $10
			</div>
		</div>
		<div id="ally-add-space-deliver-type" class="pickup_type">
			<div id="ally-add-space-deliver-type-title" class="title"><br />Can you deliver the storee's stuff?</div>
			<input type="radio" name="deliver_type" id="deliver_type_y" value="y" checked="checked" onchange="pickupForm(this, 'deliver', 'block');"/>
			<label for="deliver_type_y">Yes</label> &nbsp;
			<input type="radio" name="deliver_type" id="deliver_type_n" value="n" onchange="pickupForm(this, 'deliver', 'none');"/>
			<label for="deliver_type_n">No</label> &nbsp;
			<br />
			<div id="deliver_container">
				<div id="deliver_container_price" class="title">Delivery Charge: </div>
				<input type="text" name="deliver_charge_int" class="ally_rate ally_rate_dec" maxlength="5" value="<?php show_form_value('deliver_charge_int') ?>" /> <?php echo strtoupper($stripeAccount->default_currency); ?><br />
				Recommended Rate: $0 - $10
			</div>
		</div>
		<br />
		<br />
		<div id="ally-add-space-area" class="area">
			<div id="ally-add-space-area-title" class="title">Area</div>
			<br />
			<div id="ally-add-space-are-box" class="box">
				<a style='cursor:pointer; text-align:right; float:right; color:#39c;' onclick='swal("How do I use the map?","Storally automatically sets your current location as the default one. If you need to change the location, Type an address into the Address / City box and select an option from the suggestions. To be more precise on the location, you can adjust the marker on the map or change the latitude and longitude values.")'>
					How do I use this?
				</a>
				<br>
				<br>

				Address: <br /><br /><input type="text" name="us2-address" id="us2-address" style="width: 400px" value="<?php show_form_value('us2-address') ?>"/><br /><br />
				Address Details(if necessary): 
				<br /><br /><input type="text" name="address-detail" id="address-detail" style="width: 400px" value="<?php show_form_value('address-detail') ?>"/><br /><br />
				<a style="cursor:pointer; text-align:right; text-decoration:none; color:#39c;" id="mylocation">Use my location</a>
				<br>
				<br>
				<div id="us2" style="width: 500px; height: 400px;"></div><br />
				Lat.: <input type="text" name="us2-lat" id="us2-lat" value="<?php show_form_value('us2-lat') ?>"/><br /><br />
				Long.: <input type="text" name="us2-lon" id="us2-lon" value="<?php show_form_value('us2-lon') ?>"/><br />
				<br />
				<input type="checkbox" name="liable_box" id="liable_box" /> <label for="liable_box">  I understand that I am responsible and liable for the storee's belongings for the storage time period </label>
				<input type="hidden" name="currency" value="<?php echo $stripeAccount->default_currency; ?>" />
			</div>
		</div>
		<br />
		<br />
		<br>
		<input type="submit" name="form_submit" class="submit_button" value="Add Space" />
		</form>
<?php
		} else if($_GET["act"] == "spaces") {

			$f->o->where("user_id", $_SESSION["user_id"]);
			$f->o->orderBy("space_id");
			$spaces = $f->o->get("spaces");
			if(count($spaces) > 0) {
				echo "<table style='width:500px;'>";
				echo "<tr><td>Address</td><td></td><td></td></tr>";
				foreach($spaces as $space) {
					echo "<tr>";
					echo "<td>";
					echo substr($space["address"], 0, 100);
					echo "</td>";
					echo "<td>";
					echo "<a href='ally2.php?act=detail&sid=".$space["space_id"]."'>Details</a>";
					echo "</td>";
					echo "<td>";
					echo "<a href='#' onclick='deleteSpace(".$space["space_id"].");'>Remove</a>";
					echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "No space added yet. Please add a space using \"add space\"";
			}
		} else if($_GET["act"] == "detail") {
			if(!isset($_GET["sid"]) or !is_numeric($_GET["sid"])) {
				echo "Details are unavailable.";
			} else {
				$f->o->where("user_id", $_SESSION["user_id"]);
				$f->o->where("space_id", $_GET["sid"]);
				$space = $f->o->getOne("spaces");
				if($space == null) {
					echo "Details are unavailable.";
				} else {
					function showSpaceDetail($space, $column) {
						$detail = $space[$column];
						if($detail == null or $detail == "") {
							return "-";
						} else {
							return htmlspecialchars($detail);
						}
					}
?>
		<a href="ally2.php?act=spaces">Back</a>
		<div id="sapce_details">
			<div id="ally-details-address" class="title">Address:</div>
			<div id="ally-details-address-value" class="detail"><?php echo showSpaceDetail($space, "address"); ?></div>
			<div id="ally-details-address-details" class="title">Address Details:</div>
			<div id="ally-details-address-details-value" class="detail"><?php echo showSpaceDetail($space, "address_detail"); ?></div>
			<div id="ally-details-lat" class="title">Latitude:</div>
			<div id="ally-details-lat-value" class="detail"><?php echo showSpaceDetail($space, "latitude"); ?></div>
			<div id="ally-details-lon" class="title">Longitude:</div>
			<div id="ally-details-lon-value" class="detail"><?php echo showSpaceDetail($space, "longitude"); ?></div>
			<?php
				$sizes = array(
					"sm" => "Small",
					"md" => "Medium",
					"lg" => "Large",
					"xl" => "Extra Large"
				);
				foreach($sizes as $size => $sizeName) {
					$weekly = showSpaceDetail($space, $size."_price_weekly");
					if($weekly != "-") {
						$weekly = number_format($weekly/ 100, 2).' '.strtoupper(showSpaceDetail($space, "currency"));
					}

					$monthly = showSpaceDetail($space, $size."_price_monthly");
					if($monthly != "-") {
						$monthly = number_format($monthly/ 100, 2).' '.strtoupper(showSpaceDetail($space, "currency"));

					}

					echo '<div id="ally-details-weekly-rate-'.$size.'" class="title">'.$sizeName.' Weekly Rate:</div>';
					echo '<div id="ally-details-weekly-rate-'.$size.'-value" class="detail">'.$weekly.'</div>';
					echo '<div id="ally-details-monthly-rate-'.$size.'" class="title">'.$sizeName.' Monthly Rate:</div>';
					echo '<div id="ally-details-monthly-rate-'.$size.'-value" class="detail">'.$monthly.'</div>';
				}


				$pickupCharge = showSpaceDetail($space, "pickup_charge");
				if($pickupCharge != "-") {
					$pickupCharge = number_format($pickupCharge/ 100, 2).' '.strtoupper(showSpaceDetail($space, "currency"));
				}

				echo '<div id="pickup_charge_detail">
				<div  id="pickup_charge_detail_title" class="title">Pickup Charge:</div>
				<div id="pickup_charge_detail_value" class="details">'.$pickupCharge.'</div>
				</div>';

				$deliveryCharge = showSpaceDetail($space, "delivery_charge");
				if($deliveryCharge != "-") {
					$deliveryCharge = number_format($deliveryCharge/ 100, 2).' '.strtoupper(showSpaceDetail($space, "currency"));
				}

				echo '<div id="delivery_charge_detail">
				<div id="ally-details-delivery-charge" class="title">Delivery Charge:</div>
				<div id="ally-details-delivery-charge-value" class="details">'.$deliveryCharge.'</div>
				</div>';
			?>
		</div>
<?php
				}
			}
		} else if($_GET["act"] == "show_requests") {
			
		} else if($_GET["act"] == "stored_items") {
			
		} 
		?>

	</div>
</div>
</center>

<?php

}

?>