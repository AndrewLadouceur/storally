<?php
/**
 * @Author: ananayarora
 * @Date:   2016-03-30 01:06:22
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-04-26 19:55:05
 */
	header("Location: signin.php");
	session_start();
	if (isset($_SESSION['logged_in'])){
		header("Location: main.php");
	}
?>
<html>
<head>
	<title>Sign in to Storally</title>
	<meta charset='utf-8' />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
	<link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.light_blue-indigo.min.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/signin.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
	<div class="header">Sign in to Storally</div>
	<div class="login_form">
		<!-- Login with Facebook -->
		<a href="facebook_login.php"><button class="facebook_login_button"><i class="fa fa-facebook"></i>&nbsp;&nbsp;&nbsp;Login with Facebook</button></a>
		<!-- Normal Login form -->
		<form id="the_login_form">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
   				<input class="mdl-textfield__input" type="email" id="email" name="email">
  				<label class="mdl-textfield__label" for="email" style="color:#000;">Email</label>
  			</div>
  			<br>
  			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
   				<input class="mdl-textfield__input" type="password" id="password" name="password">
  				<label class="mdl-textfield__label" for="password" style="color:#000;">Password</label>
  			</div>
  			<br />
  			<br />
  			<!-- Submit Button -->
  			<div class="submit_button mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
  				Sign In
  			</div>
		</form>
	</div>
</body>
</html>
