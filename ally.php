<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-24 08:51:39
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-15 18:10:42
 */

	require 'inc/conf.php';
	require 'inc/mysqli.php';
	require 'inc/functions.php';

	$f = new Functions();
	$f->checkSession();
	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}
	if (!$f->isPhoneVerified())
	{
		header("Location: verify.php");
	}
	if ($f->isAlly())
	{
		$title = "Ally Info";
	} else {
		$title = "Become an Ally";
	}
	$include = "";
	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<link href="css/ally.css" type="text/css" rel="stylesheet">';
	$include .= '<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDCobO4v0gsYoPKsodPJvgwuVLAi2rkM6A"></script>';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/locationpicker.jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/ally.js"></script>';
	require 'header.php';
?>

<center>
	<div class="intro">
	<?php
		if ($f->isAlly())
		{
			echo "<br /><br /><br /><br /><p class='msg'>Hello Ally, You can update info about your space here.</p>";
		} else {
			echo "<br /><br /><br /><br /><p class='msg'>Hello, List your space here.</p><p class='msg2'>Storally let's you add your space to the listings so that people can use your place to store their items.</p>";
		}
	?>
	</div>
	<div class="wrap">
		<br />
		<br />
		<div class="pickup_type">
			<div class="title">Can you pickup / deliver the storee's stuff?</div>
			<br>
			<ul id="select_pickup_type">
				<li id="option_yes" class="pickup_type_option selected">Yes</li>
				<li id="option_no"class="pickup_type_option">No</li>
			</ul>
			<br /><br />
		</div>
		<br />
		<br />
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( You can charge more if you do! )</p>
		<br>
		<br>
		<?php
/*
		<div class="description">
			<div class="title">Description</div>
			<br>
			<textarea cols="400" placeholder="Describe your space."></textarea>
		</div>
*/
		?>
		<br>
		<br>
		<div class="price">
			<div class="title">Price</div>
			<br>
			$&nbsp;<select class="weekly">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
				<option>13</option>
				<option>14</option>
				<option>15</option>
			</select> / Week per 4.4 cubic feet
			<br /><br />
			$<input type="text" value="4" class="text monthly" maxlength="6"> / Month (You can offer a discount to encourage longer storage)
		</div>
		<br>
		<br>
		<div class="area">
			<div class="title">Area</div>
			<br />
			<div class="box">
				<a style='cursor:pointer; text-align:right; float:right; color:#39c;' onclick='swal("How do I use the map?","Storally automatically sets your current location as the default one. If you need to change the location, Type an address into the Address / City box and select an option from the suggestions. To be more precise on the location, you can adjust the marker on the map or change the latitude and longitude values.")'>
					How do I use this?
				</a>
				<br>
				<br>
				Address / City: <br /><br /><input type="text" id="us2-address" style="width: 400px"/><br /><br />
				<a style="cursor:pointer; text-align:right; text-decoration:none; color:#39c;" id="mylocation">Use my location</a>
				<br>
				<br>
				<div id="us2" style="width: 500px; height: 400px;"></div><br />
				Lat.: <input type="text" id="us2-lat"/><br /><br />
				Long.: <input type="text" id="us2-lon"/><br />
			</div>
		</div>
		<br />
		<br />
		<br>
		<div class="submit_button update_button">Update</div>
	</div>
</center>
