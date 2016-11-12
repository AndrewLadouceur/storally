<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-07 12:41:17
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-08 19:03:44
 */

	if (isset($_GET['id']) && isset($_GET['lat']) && isset($_GET['lon']))
	{
		$id = $_GET['id'];
		$lat = $_GET['lat'];
		$lon = $_GET['lon'];
	} else {
		header('Location: index.php');
	}

	$title = "Storally";
	$include = '<link rel="stylesheet" type="text/css" href="css/view_ally.css">';
	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/view_ally.js"></script>';
	require "inc/conf.php";
	require "inc/mysqli.php";
	require "inc/functions.php";

	$f = new Functions();
	$f->checkSession();
	

	if (!$f->checkLogin())
	{
		header("Location: signin.php");
	}
	$f->o->where("id",$f->o->escape($id));
	$o = $f->o->get("ally")[0];
	if ($f->o->count != 1)
	{
		header("Location: index.php");
	}
	require "header.php";
?>
<div class="box">
	<center>
		<div class="ally_pictures">
			<!-- <img src="http://lorempixel.com/200/200">
			<img src="http://lorempixel.com/200/200">
			<img src="http://lorempixel.com/200/200">
			<img src="http://lorempixel.com/200/200">
			<img src="http://lorempixel.com/200/200"> -->
		</div>
		<br>
		<div class="ally_name">
			<?php 
				echo stripslashes($o['name']);
			?>
		</div>
		<br />
		<br />
		<div class="ally_distance">
			<?php 
				$d = $f->getDistance($lat,$lon,$o['latitude'],$o['longitude']);
				if ($d > 1000)
				{
					echo "<i class='fa fa-location-arrow fa-2x'></i>&nbsp;&nbsp;&nbsp;".number_format((float)($d / 1000), 2, '.', '') . " km";
				} else {
					echo "<i class='fa fa-location-arrow fa-2x'></i>&nbsp;&nbsp;&nbsp;".number_format((float)$d, 2, '.', '') . " m";
				}
			?>
		</div>
		<br />
		<div class="ally_price">
			<?php 
				echo "<i class='fa fa-money fa-2x'></i>&nbsp;&nbsp;&nbsp;$".stripslashes($o['weeklyprice']) . " / week<br />";
				echo "<i class='fa fa-money fa-2x'></i>&nbsp;&nbsp;&nbsp;$".stripslashes($o['monthlyprice']) . " / month";
			?>
		</div>
		<br>
		<br>
		<div class="info">
			<?php 
				echo "<i class='fa fa-phone fa-2x'></i> &nbsp; &nbsp;" . $f->getPhoneNumber($id) . "<br /><br />";
				echo "<i class='fa fa-envelope fa-2x'></i> &nbsp; &nbsp;" . $f->getEmail($id);
			?>
		</div>
	</center>
</div>