<?php


	$title = "Signup";
	require("inc/conf.php");
	require("inc/mysqli.php");
//	$landing = "true";
	$include = file_get_contents('include.php');
	$include .= '<script src="js/new_signup_box.js"></script>';
	$include .= '<script src="js/jquery.easing.1.3.js"></script>';
	$include = "<link href='css/new_signup_box.css' rel='stylesheet' type='text/css' />";

	require("header.php");

?>/
<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-15 01:28:54
@Last modified by:   ananayarora
@Last modified time: 2016-08-23T02:21:29+05:30
 */
?>

</style>

						<!-- multistep form -->
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
					<input type="text" name="email" placeholder="Email" />
					<input type="password" name="pass" placeholder="Password" />
					<input type="password" name="cpass" placeholder="Confirm Password" />
					<input type="button" name="next" class="next action-button" value="Next" />
				</fieldset>
				<fieldset>
					<h2 class="fs-title">Social Profiles</h2>
					<h3 class="fs-subtitle">Your presence on the social network</h3>
					<input type="text" name="twitter" placeholder="Twitter" />
					<input type="text" name="facebook" placeholder="Facebook" />
					<input type="text" name="gplus" placeholder="Google Plus" />
					<input type="button" name="previous" class="previous action-button" value="Previous" />
					<input type="button" name="next" class="next action-button" value="Next" />
				</fieldset>
				<fieldset>
					<h2 class="fs-title">Personal Details</h2>
					<h3 class="fs-subtitle">We will never sell it</h3>
					<input type="text" name="fname" placeholder="First Name" />
					<input type="text" name="lname" placeholder="Last Name" />
					<input type="text" name="phone" placeholder="Phone" />
					<textarea name="address" placeholder="Address"></textarea>
					<input type="button" name="previous" class="previous action-button" value="Previous" />
					<input type="submit" name="submit" class="submit action-button" value="Submit" />
				</fieldset>
			</form>

			<!-- jQuery -->
			<script src="http://thecodeplayer.com/uploads/js/jquery-1.9.1.min.js" type="text/javascript"></script>
			<!-- jQuery easing plugin -->
			<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>


	<?php require("footer.php"); ?>
</body>
</html>