<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-13 02:20:07
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-13 04:41:14
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

	if (!isset($_POST['phone_number']))
	{
		header("Location: index.php");
		// print_r($_POST);
	}

	// Update the phone number in the database

	$f->o->where("id",$f->getField('id'));
	$data = Array('phone'=>base64_decode($_POST['phone_number']), 'country_code'=>base64_decode($_POST['country_code']), 'verified_phone'=>'false');
	$f->o->update("users",$data);

	$code = $f->generateRandomCode(base64_decode($_POST['phone']));

	// Delete any old pending verifications
	$f->o->where("uid",$f->getField("id"));
	$f->o->where("type","phone");
	$f->o->delete("verifications");

	// Add it to the verification table
	$data = Array(
		'uid'=>$f->getField('id'),
		'type'=>'phone',
		'code'=> $code
	);

	$f->o->insert("verifications", $data);
	$f->sendRandomCode("+".base64_decode($_POST['country_code']) . base64_decode($_POST['phone_number']),$code);

?>
