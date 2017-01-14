<?php


	$title = "Signup";
	require("inc/conf.php");
	require("inc/mysqli.php");
//	$landing = "true";
	$include = file_get_contents('include.php');
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/signup.js"></script>';
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
		<div class="overlay"></div>
		<div class="logo">
			<div class = "left">
				<div style="font-size: 35pt;">Storee</div>
				<br>
				<div style="font-style: italic;">
					I want to store my belongings
				</div>	
				<br>
				<br>
				<br>
				<div class="continue_storee">Become a Storee</div>
			</div>
			
		</div>
			<div class="divider"></div>
			<div class="slogan">
			<div class="right">
				<div style="font-size: 35pt;">Ally</div>
				<br>
				<div style="font-style: italic;">
					I want to host other people's belongings
				</div>	
				<br>
				<br>
				<br>
				<div class="continue_ally">Become an Ally</div>
				</div>
				
			</div>
			<br />
			<div class = "clear"></div>
		</div>
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
