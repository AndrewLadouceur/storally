<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-12 11:47:07
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-12 13:11:10
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
	$include = '<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />';
	$include .= '<script src="js/sweetalert.min.js"></script>';

	require("header.php");

?>
<br />
<br />
<br />
<br />
<center>
	<?php
		if ($f->getField('phone') == "")
		{
			echo "<script>swal({
					title: 'You cannot see this page.',
					text: 'You must add a phone number and verify it before you can see this page.',
					type: 'error'
				}, function(){
					window.location.href='profile.php#trust';
				});</script>";
		} else if (!$f->isPhoneVerified())
		{
			echo "<script>swal({
					title: 'You cannot see this page.',
					text: 'You must verify your phone number.',
					type: 'error'
				}, function(){
					window.location.href='profile.php#trust';
				});</script>";
		}

		if (!$f->isMailVerified())
		{
			echo "<script>swal({
					title: 'You cannot see this page.',
					text: 'You must verify your email.',
					type: 'error'
				}, function(){
					window.location.href='profile.php#trust';
				});</script>";
		}
	?>
	<p></p>
</center>
