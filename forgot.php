<?php
	require("inc/conf.php");
	require("inc/mysqli.php");
	require("inc/functions.php");
	
	$f = new Functions();
	$f->checkSession();
	$title = "Forgot Passsword";	
	$include = "<link href='css/sweetalert.css' rel='stylesheet' type='text/css' />";
	$include .= "<script src='js/jquery.js'></script>";
	$include .= "<script src='js/sweetalert.min.js'></script>";
	require("header.php");
?>
<script>
	$(document).ready(function(){
		$(".btn").click(function(){
			swal("Please Wait","Sending the recovery email","info");
			var data = "email="+$("#email").val();
			if ($("#email").val() == "")
			{
				swal("Input an email please!","Put in an email in the box!","error");
			} else {	
				$.post('process_forgot.php?action=sendforgot', data, function(r)
				{
					console.log(r);
					if (r == "error")
					{
						swal("Error","No such email exists. Please make sure you have entered your email correctly.","error");
					} else {
						swal("Recovery Email Sent","Please check your email for a recovery email. This will be used to recover your account.","success");	
					}
				});
			}
		});
	});
</script>
<style type="text/css" media="screen">
	body
	{
		background:#f4f4f4;
	}
	.content
	{
		margin-top:10%;
	}
	.btn
	{
		width: 200px;
		padding: 10px;
		background: #16a085;
		color: #fff;
		font-family: "Varela Round", "Segoe Ui", "Helvetica Neue";
		cursor: pointer;
	}
	.text
	{
		 padding: 10px;
		 text-align: left;					   		
		 margin: 5px;			
		 width:300px;			   		
		 border-radius: 3px;				   		
		 border: 1px solid rgba(0, 0, 0, 0.3);		
	}										
</style>
<center>
<div class='content'>
	<h1>Forgot Password</h1>
	<br />
	<br />
	<br />
	<input type="text" class="text" id="email" placeholder="Enter email here"/>
	<br />
	<br />
	<div class="btn">Reset Password</div>
</div>
</center>
