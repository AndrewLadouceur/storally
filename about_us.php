<?php 
	$include = "";
	$title = "About us";
	require("inc/conf.php");
	require("inc/mysqli.php");
	require("header.php");
?>
<style type="text/css">
	body
	{
		background:url("img/co_founders.jpg");
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
.box {
  position: absolute;
  top:45%;
  left: 22%;
  opacity: 0.5;
  width: 56%;
  height: relative;
  background: #16a085;
  display: middle;
  align-self: middle;
}
.about
	{
		position: absolute;
		background: rgba(22,160,133,0.5);
		padding: 15px 20px 15px 20px;
		font-size: 24pt;
		text-transform: uppercase;
		top:70%;
		left: 50%;
		transform:translate(-50%,-50%);
		-webkit-transform:translate(-50%,-50%);
		-moz-transform:translate(-50%,-50%);
		-o-transform:translate(-50%,-50%);
		color:#333;
		z-index:+9;
		color:#fff;
	}
.about .body
	{
		display: inline;
		font-size: 16pt;
		text-transform: none;

	}

</style>
<center>
<div class="overlay"></div>
<div class="about">
	About us
	<br>
	<br>
	<div class="body">
Founded in 2016 on the beautiful Vancouver campus of UBC, Storally is an online platform that connects space owners with people in need of space to store their belongings temporarily. We accomplish this by utilizing the extra space in people’s homes and offices. Storally has organically grown to help find people a place to store their belongings. Trust and human connection are the two values that we focus on. We believe that the world is more interconnected than ever before and we want to be facilitators in this sharing economy.
</div>
</div>
</center>
<?php require("footer.php"); ?>