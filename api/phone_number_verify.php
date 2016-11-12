<?php
	/*
		@Author: ananayarora
		@Date:   2016-08-15T02:53:36+05:30
@Last modified by:   ananayarora
@Last modified time: 2016-08-15T02:55:13+05:30
	*/

	require ('../inc/conf.php');
	require ('../inc/mysqli.php');
	require ('../inc/functions.php');

	$f = new Functions();
	$f->checkSession();

	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}

	if (!isset($_POST['verification_code']))
	{
		header("Location: index.php");
	}

	$f->o->where("uid",$f->getField("id"));
	$f->o->where("code",$_POST['verification_code']);
	$f->o->where("type","phone");
	$k = $f->o->get("verifications");

	if ($k[0]['uid'] == $f->getField('id') && $k[0]['type'] == "phone" && $k[0]['code'] == $_POST['verification_code'])
	{
		// Delete the record from the verifications table.
		$f->o->where("id",$k[0]['id']);
		$f->o->delete("verifications");

		// Update the verified status for the user
		$f->o->where("id",$f->getField("id"));
		$data = Array('verified_phone'=>"true");
		$f->o->update("users",$data);
		echo "success";
	} else {
		echo "Oops! It seems like you entered the wrong verification code.";
	}

?>
