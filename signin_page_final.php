<?php 

	$title = "Signup";

	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="new_signup/jquery-1.9.1.min.js" type="text/javascript"></script>';
	$include .= '<script src="new_signup/jquery.easing.min.js" type="text/javascript"></script>';
	$include .= '<script src="new_signup/script.js" type="text/javascript"></script>';
	$include .= '<link rel="stylesheet" type="text/css" href="new_signup/style.css">';


	require 'inc/conf.php';
	require 'inc/mysqli.php';
	require 'inc/functions.php';
	// $include = file_get_contents('new_signup/signup_include.php');

	$f = new Functions();
	$f->checkSession();

	if ($f->checkLogin())
	{
		header("Location: main.php");
	} else {
		require 'header.php';
	}  
?>


<style type="text/css">
	body
	{
		background:url("img/landing_bg.jpg");
		background-size:100%;
		background-position: center center; 
	}
	.overlay{
		position: absolute;
		top:0;
		left:0;
		width: 100%;
		height: 100%;
		background:rgba(0,0,0,0.6);
		z-index:+3;
	}
.about
	{

  position: fixed;
  top: 30%;
  left: 50%;

		transform:translate(-50%,-50%);
		-webkit-transform:translate(-50%,-50%);
		-moz-transform:translate(-50%,-50%);
		-o-transform:translate(-50%,-50%);
		z-index:+9;

	}

</style>
<center>
<div class="overlay"></div>

<div class="about">
<form id="msform">
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active">Account Setup</li>
		<li>User Type</li>
		<li>Personal Details</li>
	</ul>
	<!-- fieldsets -->
		<fieldset>
		<h2 class="fs-title">Create your account</h2>
		<h3 class="fs-subtitle">It's about time you signed up!</h3>
		<div class="fs-error"></div>
		<input type="text" name="email" id="email" placeholder="Email" />
		<input type="password" name="pass"  id="pass" placeholder="Password" />
		<input type="password" name="cpass"  id="cpass" placeholder="Confirm Password" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
 
	
	<fieldset>
		<h2 class="fs-title">Host or store?</h2>
		<h3 class="fs-subtitle">Don't worry, you can always change later!</h3>

		<div class="tooltip">
			<button type="button" id="storee" class="sa_button storee" onclick="getElementById('storeeValue').value = 0" style="font-size: 14pt;">Storee</button>
			<span class="tooltiptext">
				A Storee is someone looking to store their belongings
			</span>
		</div>

		<div class="tooltip">
			<button type="button" id="ally" class="sa_button ally" onclick="getElementById('storeeValue').value = 1" style="font-size: 14pt;">Ally</button>
			<span class="tooltiptext" style="right:0%; left: 110%;">
				An Ally is someone willing to host someone’s belongings
			</span>
		</div>

			<input type="hidden" default="0" name="storeeValue" id="storeeValue"/>

			<br>

		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>



	<fieldset>

		<h2 class="fs-title">Personal Details</h2>
		<h3 class="fs-subtitle">You're almost done!</h3>
			<div class="fs-error"></div>
		<input type="text" name="fname" id="fname" placeholder="First Name" />
		<input type="text" name="lname" id="lname" placeholder="Last Name" />
		<input type="text" name="phone" id="phone" placeholder="Phone (123-123-1234)" />
		<input type="text" name="pcode" id="pcode" placeholder="Postal Code (X1X 1X1)" />
		<textarea name="address" id="address" placeholder="Street [optional appartment #], City, Country"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="submit" name="submit" class="submit action-button" value="Submit" />
	
	</fieldset>
	
</form>



</div>
</center>
<?php require('footer.php'); ?>