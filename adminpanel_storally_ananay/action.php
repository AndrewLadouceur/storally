<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-21 02:45:44
@Last modified by:   ananayarora
@Last modified time: 2016-08-19T01:29:45+05:30
 */
	require("../inc/conf.php");
	require("../inc/mysqli.php");
	require("../inc/functions.php");

	$f = new Functions();

	if ($_GET['action'] == "accept") {
		$f->o->where("id",$_GET['accept_id']);
		$data = Array(
			'verified_photo_id'=>'true'
		);
		$f->o->update('users',$data);
		$f->o->where("id",$_GET['accept_id']);
		$k = $f->o->get("users");
		$f->sendEmail($k[0]['email'],"Photo ID Accepted","<center><img src='https://storally.com/img/logo_black.png' style='width:100px;'></img><h1>Your Photo ID has been accepted!</h1><br /><p>Congratulations, your ID has been accepted by Storally. You can now send and receive requests</p>");
		echo "success";
	}

	if ($_GET['action'] == "reject") {
		$f->o->where("id",$_GET['reject_id']);
		$data = Array(
			'verified_photo_id'=>'rejected'
		);
		$f->o->update('users',$data);
		$f->o->where("id",$_GET['reject_id']);
		$k = $f->o->get("users");
		$f->sendEmail($k[0]['email'],"Photo ID Rejected","<center><img src='https://storally.com/img/logo_black.png' style='width:100px;'></img><h1>Your Photo ID has been rejected!</h1><br /><p>Sorry, your ID was not accepted by Storally. Please upload a valid ID. You cannot send or recieve requests until you upload a valid ID. </p>");
		echo "success";
	}

	if ($_GET['action'] == "remove") {
		$f->o->where("id",$_GET['id']);
		$f->o->delete("users");
		$f->o->where("user_id",$_GET['id']);
		$f->o->delete("ally");
		echo "success";
	}
?>
