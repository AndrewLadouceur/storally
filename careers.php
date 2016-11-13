<?php 
	$include = "";
	$title = "Careers";
	require("inc/conf.php");
	require("inc/mysqli.php");
	require("header.php");
?>
<style type="text/css">
	body
	{
		background:url("img/careers.jpg");
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
	.careers
	{
		font-size: 20pt;
		text-transform: uppercase;
		position: absolute;
		top:50%;
		left: 50%;
		transform:translate(-50%,-50%);
		-webkit-transform:translate(-50%,-50%);
		-moz-transform:translate(-50%,-50%);
		-o-transform:translate(-50%,-50%);
		color:#333;
		z-index:+9;
		color:#fff;
	}
	.careers .email
	{
		display: inline;
	}

a:link { color: #fff; text-decoration: none;}
a:hover { color: #16a085; text-decoration: underline;}

</style>
<div class="overlay"></div>
<div class="careers">
	Want to join us in the storage revolution? We'll be happy to talk!
	<br />
	<br />
	Drop us an email at 
	<div class="email">
		<a href="mailto:careers@storally.com">careers@storally.com
		</a>	
	</div>
</div>
<?php require("footer.php"); ?>