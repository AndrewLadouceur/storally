<?php
	/**
	 * @Author: ananayarora
	 * @Date:   2016-04-23 23:50:18
	 * @Last Modified by:   ananayarora
	 * @Last Modified time: 2016-06-22 20:14:00
	 */
	require 'inc/conf.php';
	require 'inc/mysqli.php';
	$include = '
	<link rel="stylesheet" type="text/css" href="css/signin.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/sweetalert.min.js"></script>
	<script type="text/javascript" src="js/login.js"></script>';
	$title = "Sign In";
	require("inc/functions.php");
	$f = new Functions();
	$f->checkSession();
	if ($f->checkLogin())
	{
		header("Location: main.php");
	} else {
		require 'header.php';
	}

?>
<div class="overlay"></div>
<div class="header_">Sign in to Storally</div>
	<div class="login_form">
		<!-- Login with Facebook -->
		<a href="facebook_login.php"><button class="facebook_login_button"><i class="fa fa-facebook"></i>&nbsp;&nbsp;&nbsp;Login with Facebook</button></a>
		<!-- Normal Login form -->
		<form id="the_login_form">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
   				<input required type="email" id="email" name="email" placeholder="Email">
  			</div>
  			<br>
  			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
   				<input type="password" id="password" name="password" placeholder="Password">
  			</div>
  			<br />
  			<br />
  			<!-- Submit Button -->
  			<div class="submit_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
  				Sign In
  			</div>
  			 <div class="forgot"><a href="contact.php">Forgot your password?</a></div>
		</form>
	</div>
</div>
<br />
<br />
<br />
<?php require("footer.php"); ?>
