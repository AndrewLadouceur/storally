<?php session_start();?>


<!DOCTYPE html>
<html>
<head>
<?php 
	$title = "Signup";
	require("inc/conf.php");
	require("inc/mysqli.php");

	$include = file_get_contents('include.php');
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/signup.js"></script>';
	$include .= '<script src="jquery-1.9.1.min.js" type="text/javascript"></script>';
	$include .= '<script src="jquery.easing.min.js" type="text/javascript"></script>';
	$include .= '<script src="script.js" type="text/javascript"></script>';
	$include .= '<link rel="stylesheet" type="text/css" href="style.css">';
	require("header.php");

?>
	<title>Sign up</title>
</head>
<body style="overflow-y:hidden; position: absolute;">
<div style="overflow:auto; position:absolute; top: 0px; left:0px; right:0px; bottom:0px">
	<div class="welcome" style="overflow-y:hidden; position: absolute;">
	<br>
	<br>
	<br>
		<div class="overlay"></div>
		<br>

	<form id="msform">
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active">Account Setup</li>
		<li>Social Profiles</li>
		<li>Personal Details</li>
	</ul>
	<!-- fieldsets -->
		<fieldset>
		<h2 class="fs-title">Create your account</h2>
		<h3 class="fs-subtitle">This is step 1</h3>
		<div class="fs-error"></div>
		<input type="text" name="email" id="email" placeholder="Email" />
		<input type="password" name="pass"  id="pass" placeholder="Password" />
		<input type="password" name="cpass"  id="cpass" placeholder="Confirm Password" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>

	
	<fieldset>
		<h2 class="fs-title">Social Profiles</h2>
		<h3 class="fs-subtitle">Your presence on the social network</h3>
			<!-- <button type="button" name="ally" id = "storee" value="FALSE" class="sa_button storee"><script>document.writeln(ally);</script></button> -->
			<button type="button" class="sa_button storee" onclick="getElementById('storeeValue').value = 1">Storee</button>
			<button type="button" class="sa_button ally" onclick="getElementById('storeeValue').value = 0">Ally</button>
			<input type="hidden" default="0" name="storeeValue" id="storeeValue"/>

			<br>
			<!-- <div id="tester"></div> -->
			<!-- <button type="button" onclick="ally_choice('FALSE')" name="ally" id = "ally" class="sa_button storee">Storee</button>
			<button type="button" onclick="ally_choice('TRUE')" name="ally" id = "storee" class="sa_button ally">Ally</button> -->

		<!-- <input type="text" name="twitter" placeholder="Twitter" />
		<input type="text" name="facebook" placeholder="Facebook" />
		<input type="text" name="gplus" placeholder="Google Plus" /> -->
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>



	<fieldset>

		<h2 class="fs-title">Personal Details</h2>
		<h3 class="fs-subtitle">We will never sell it</h3>
			<div class="fs-error"></div>
		<input type="text" name="fname" id="fname" placeholder="First Name" />
		<input type="text" name="lname" id="lname" placeholder="Last Name" />
		<input type="text" name="phone" id="phone" placeholder="Phone (123-123-1234)" />
		<textarea name="address" id="address" placeholder="Address"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="submit" name="submit" class="submit action-button" value="Submit" />
	
	</fieldset>

<?php require("footer.php"); ?>
</form>
</body>
</html>

