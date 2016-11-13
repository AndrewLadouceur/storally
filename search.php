<?php
	/**
	 * @Author: ananayarora
	 * @Date:   2016-04-24 01:19:01
	 * @Last Modified by:   ananayarora
	 * @Last Modified time: 2016-05-15 19:00:52
	 */

	require("inc/conf.php");
	require("inc/mysqli.php");
	$title = "Search";
	$include = "<link href='css/search.css' rel='stylesheet' type='text/css' />";
	$include .= "<link href='css/sweetalert.css' rel='stylesheet' type='text/css' />";
	$include .= "<script src='js/jquery.js'></script>";
	$include .= "<script src='js/maplace.min.js'></script>";
	$include .= "<script src='js/sweetalert.min.js'></script>";
	$include .= '<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDCobO4v0gsYoPKsodPJvgwuVLAi2rkM6A&libraries=places"></script>';
	$include .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">';
	$include .= '<script src="js/locationpicker.jquery.js"></script>';
	$include .= "<script src='js/jquery.googlemap.js'></script>";
	require("header.php");
?>
<center>
<div class="sidepanel">
	<h3 class="title">Find Allies</h3>
	<br />
	<form id="search_form">
	<div class = "subtitle">Address</div>
	<br />
		<input value="<?php echo $_GET['address']; ?>"  class="search_bar_home" type="text" name="address" placeholder="Address" id="address">
		<br /><br />
		<div class = "subtitle">Radius (in Kilometers)</div>
		<br />
		<input type="text" name="rad" value="2" placeholder="Radius (in Kilometers)" id="rad"><br /><br />
		<div class="submit_button">Search</div>
	</form>
	<div class="results">

	</div>
	<br />
	<br />
	<br />
	<br />
</div>
</center>

<input type="text" value="<?php echo $_GET['lat']; ?>" style="display:none;" name="lat" placeholder="Latitude" id="lat">
<input type="text" style="display:none;" value="<?php echo $_GET['lon']; ?>" name="lon" placeholder="Longitude" id="lon">

<div id="us2" style="display:none;"></div>
<div id="us2-lat" style="display:none;"></div>
<div id="us2-lon" style="display:none;"></div>
<div id="map"></div>
<script src='js/search.js'></script>
