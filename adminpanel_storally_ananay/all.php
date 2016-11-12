<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-20 14:52:06
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-07-16 20:33:22
 */
	require("../inc/conf.php");
	require("../inc/mysqli.php");
	require("../inc/functions.php");

	$f = new Functions();
	$k = $f->o->get("users");
	echo "<p>No. of users: ".$f->o->count." </p>";
	echo "<table align='center'>";
	echo "<tr>";
	echo "<div class='header'><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Is ally?</th><th>Photo ID</th><th>Email Verified?</th><th>Verified Phone?</th><th>Facebook User?</th><th>Verified Photo ID?</th><th>Delete</th></div>";
	foreach ($k as $key => $value)
	{
		echo "<center><tr align='center'>";
		echo "<td>".$value['fullname']."</td>";
		echo "<td>".$value['email']."</td>";  
		echo "<td>".$value['phone']."</td>";  
		echo "<td>".$value['address']."</td>";
		if ($value['ally'] == "false")
		{
			echo "<td>No</td>";	
		} else {
			echo "<td>Yes</td>";
		}
		echo "<td>".$value['photoid']."</td>";
		if ($value['verified_email'] == "false")
		{
			echo "<td>No</td>";	
		} else {
			echo "<td>Yes</td>";
		}
		if ($value['verified_phone'] == "false")
		{
			echo "<td>No</td>";	
		} else {
			echo "<td>Yes</td>";
		}
		if ($value['fbid'] == "" || $value['fbid'] == null || empty($value['fbid']))
		{
			echo "<td>No</td>";
		} else {
			echo "<td>Yes</td>";
		}
		if ($value['verified_photo_id'] == "false")
		{
			echo "<td>No</td>";	
		} else {
			echo "<td>Yes</td>";
		}
		echo "<td><a href='https://storally.com/adminpanel_storally_ananay/action.php?action=remove&id=".$value['id']."' target='_blank'>Delete</a>";
/*
		echo "<td>".$value['verified_phone']."</td>";
		echo "<td>".$value['verified_photo_id']."</td>";
*/
		echo "</tr></center>";
	}				
	echo "</table>";				  
?>

<style type="text/css" media="screen">
	*
	{
		font-family: "Open Sans","Helvetica Neue","Segoe Ui Light","sans-serif";
	}
	table,tr,td,th
	{
		border:1px solid #cdcdcd;
		border-collapse: collapse;
	}
	td
	{
		padding:20px;
	}
</style>