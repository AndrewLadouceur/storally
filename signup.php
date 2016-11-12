<?php 

/**
 * @Author: ananayarora
 * @Date:   2016-04-20 17:20:56
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-19 13:42:30
 */

	$title = "Signup";
	$include = '<link rel="stylesheet" type="text/css" href="css/signup.css">';
	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/signup.js"></script>';

	require 'inc/conf.php';
	require 'inc/mysqli.php';
	require 'inc/functions.php';

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
.mdl-button{
	border: none;
    border-radius: 2px;
    color: #000;
    position: relative;
    height: 36px;
    margin: 0;
    min-width: 64px;
    padding: 0 16px;
    display: inline-block;
    font-family: "Roboto","Helvetica","Arial",sans-serif;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0;
    overflow: hidden;
    will-change: box-shadow;
    transition: box-shadow .2s cubic-bezier(.4,0,1,1),background-color .2s cubic-bezier(.4,0,.2,1),color .2s cubic-bezier(.4,0,.2,1);
    outline: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    line-height: 36px;
    vertical-align: middle;
}
</style>
<center>
	<div class="signup">
			<div class="box">
			<h1 class="box_title">Sign up</h1>
			<div class="error">

				</div>
			<br />
			<br />
			<!-- Login with Facebook -->
			<a href="facebook_login.php"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect facebook-button" style="background:#3b5998 !important;color:#fff;text-transform: capitalize;"><i class="fa fa-facebook"></i>&nbsp;&nbsp;&nbsp;Login with Facebook</button></a>
			<br />
			<br />
			<br />
			<form id="signup_form">
				<div class="field">
					<span class="label">Full Name</span>
					<div class="textbox">
						<input required name="fullname" type="text" class="text" size="50">
					</div>
				</div>

				<div class="field">
					<span class="label">Email</span>
					<div class="textbox">
						<input required name="email" type="email" class="text" size="50">
					</div>
				</div>

				<div class="field">
					<span class="label">Password</span>
					<div class="textbox">
						<input required id="pass" name="password" type="password" class="text" size="50">
					</div>
				</div>

				<div class="field">
					<span class="label">Confirm Password</span>
					<div class="textbox">
						<input name="confirm_password" id="confirmpass" type="password" class="text" size="50">
					</div>
				</div>
				<br>
				<br>
				<div class="submit_button">Signup</div>
			</form>
		</div>
	</div>
</center>
	</div>
<?php require("footer.php"); ?>
