<?php 
	require("inc/conf.php");
	require("inc/mysqli.php");
	require("inc/functions.php");
	$f = new Functions();
	if (isset($_POST['email']))
	{
		$f->sendEmail("raghav.ubc@gmail.com","Contact Us Response","<b>From:</b> ".$_POST['email']."<br /><b>Name:</b>".$_POST['name']."<br /><b>Message:</b>".$_POST['message']."<br />");
	}
	$include = "<link href='css/sweetalert.css' rel='stylesheet' type='text/css' />";
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	require("header.php");
?>
<html>
<head>
	<title>Contact Us</title>
	<style type="text/css">
		*
		{
			margin:0;
			padding:0;
		}
		body
		{
			width: 100%;
			height: 100%;
			background:url(img/contact.jpeg);
			background-size:cover;
			background-position: center center;
		}
		.overlay
		{
			position: absolute;
			top:0;
			left:0;
			width: 100%;
			height: 100%;
			background:rgba(0,0,0,0.4);
		}
		.content
		{
			position: absolute;
			top:50%;
			left:50%;
			z-index: +8;
			color:#fff;
			transform:translate(-50%,-50%);
			-webkit-transform:translate(-50%,-50%);
			-moz-transform:translate(-50%,-50%);
			-o-transform:translate(-50%,-50%);
		}
		.footer
		{
			position: absolute;
			bottom:0;
			z-index: +7;
		}
		.submit
		{
			width: 100px;
  			padding: 10px;
  			background: #16a085;
  			color: #fff;
  			font-family: "Varela Round", "Segoe Ui", "Helvetica Neue";
  			cursor: pointer;
		}
		input[type="text"],textarea
		{
			font-size: 11pt;
			padding: 10px;
  			text-align: left;
  			margin: 5px;
  			width: 400px;
  			border-radius: 3px;
  			border: 1px solid rgba(0, 0, 0, 0.3);
		}
		textarea 
		{
			height: 200px;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".submit").click(function(){
				var data = "name="+$("#name").val()+"&email="+$("#email").val()+"&message="+$("#message").val();
				$.post("contact.php",data,function(r){
					swal("Thank you!","Thank you for contacting us. We will get back to you shortly.","success");
				});
			});
		});
	</script>
</head>
<body>
<div class="overlay"></div>
<div class="content">
	<center>
		<h1>Contact Us</h1>
		<br />
		<form>
			<input type="text" id="name" placeholder="Name"><br /><br />
			<input type="text" id="email" placeholder="Email"><br /><br />
			<textarea id="message" placeholder="Message"></textarea><br /><br />
			<div class="submit">Submit</div>
		</form> 
	</center>
</div>
</body>
</html>
<?php require("footer.php"); ?>