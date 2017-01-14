<?php session_start();
	$title = "Signup";
	require("inc/conf.php");
	require("inc/mysqli.php");
//	$landing = "true";
	$include = file_get_contents('include.php');
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/signup.js"></script>';
	require("header.php");

?>

<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-15 01:28:54
@Last modified by:   ananayarora
@Last modified time: 2016-08-23T02:21:29+05:30
 */
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
<body style="overflow-y:hidden; position: absolute;">
<div style="overflow:auto; position:absolute; top: 0px; left:0px; right:0px; bottom:0px">
	<div class="welcome" style="overflow-y:hidden; position: absolute;">
	<br>
	<br>
	<br>
		<div class="overlay"></div>
		<br>
	<br>
	<br>
			<div class="testimonials_signup" style="opacity: 1;">
		<br>
	<h1>Testimonials</h1>
				<br />
				<h2 class="quote"></h2>
				<br />
				<span class="quote_author"></span>
			</div>
			<br>
		<img src="https://storally.com/img/logo_white.png" class="logo">
		<br>
		<div class="divider"></div>
		<div class="slogan">Storally helps you find a host for your belongings while you are away.</div>
		<br />
	</div>
<br>
<!-- <div class="find_text">
		<div class = "box">
		<center>
			<form id="signup_form">
				<div class="field">
					<span class="label">Email</span>
					<br>
					<br>
					<div class="textbox">
						<input required name="email" type="email" class="new_text" size="50">
					</div>
				</div>
				</div>
				</div> 
				</center>-->
<form id="signup_form" method="post">
	<div class="field">
		<div class="find_text_new">
			Email
			<div class="textbox">
				<input required name="email" type="email" size="40" style="font-size: 20pt">	
			</div>
		</div>
		<div class="submit_button_new" id="email_continue" name="submit_email">Sign up</div>
	</div>
</div>

		 <!--  <input type="submit" name="submit" value="Create Subject" /> -->


	<!-- 	<div class="textbox">
						<input required name="email" type="email" class="text" size="50">
					</div>
		<br>
		</div>
		<center>
			<div class="field">
					<span class="slogan">Email</span>
					<div class="textbox">
						<input required name="email" type="email" class="text" size="50">
					</div>
				</div>
				</center>


 -->
<!-- <center>
	<div class="signup">
			<div class="overlay"></div>
			<div class="box">
			<h1 class="box_title">Sign up</h1>
			<div class="error">

				</div>
			<br />
			<br />
			<form id="signup_form">
				<div class="field">
					<span class="label">Email</span>
					<div class="textbox">
						<input required name="email" type="email" class="text" size="50">
					</div>
				</div>
				<br>
				<br>
				<div class="submit_button">Signup</div>
			</form>
		</div>
	</div>
</center> -->

	
	<?php require("footer.php"); ?>
</body>
</html>
<!-- display: block;
    margin-top: 0px;
    position: fixed;
    top: 50%;
    height: 87%;
    width: 57%;
    left: 67%;
    transform: translate(-50%,-50%); -->
