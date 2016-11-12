<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-08 19:01:57
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-08 23:48:22
 */

	if (!isset($_GET['id']) && !isset($_GET['message']))
	{
		header("Location: 404.php");
	} else {
		$id = $_GET['id'];
	}

	require(__DIR__."/../../inc/conf.php");
	require(__DIR__."/../../inc/mysqli.php");
	require(__DIR__."/../../inc/functions.php");
	$f = new Functions();
	$f->checkSession();

	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}

	// Check if user is already added
	if ($f->getAcceptance($id))
	{
		echo "already";
	} else {
		// Check if the user's request is pending
		if ($f->getRequest($id))
		{
			echo "alreadyrequest";
		} else {
			// Send the request
			if ($f->isPhotoVerified()){
				$data = Array(
					'sender'=>$f->getField("id"),
					'receiver'=>$id,
					'message'=>$_GET['message'],
					'timeperiod'=>$_GET['timeperiod'],
					'time'=>$_GET['time'],
					'size'=>$_GET['size']
				);
				$f->o->insert("requests",$data);
				$f->o->where("id",$id);
				$allyData = $f->o->get("users")[0]; 
				$f->o->where("id",$f->getField('id'));
				$storeeData = $f->o->get("users")[0];
				$f->sendEmail($allyData['email'], "You have a new Storee request!","Hello ".$allyData['name']. ", <br /> You have a new Storee request from ".$storeeData['fullname'].". <br /><br /> <center> <a href='https://storally.com/ally_requests.php'>Click here to check your Storee requests</a> </center><br /><br />Regards, <br /> Team Storally");
			} else {
				echo "photoid";
			}
		}
	}
?>