<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-19 12:41:15
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-07-16 20:25:51
 */

	require('inc/mysqli.php');
	require('inc/conf.php');
	require('inc/functions.php');
	$c = new Conf();
	$o = new MysqliDb($c->host,$c->username,$c->password,$c->db);
	$f = new Functions();
	$f->checkSession();
	$include = "<script src='js/jquery.js'></script>";
	$include .= "<script src='js/sweetalert.min.js'></script>";
	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$title = "Email Verification";

	$o->where("type","email");
	$o->where("code",$_GET['verify_token']);
	$k = $o->get("verifications");
	$error = 0;
	if ($o->count == 1)
	{
		$uid = $k[0]['uid'];
		$o->where("id",$uid);
		$data = Array(
			'verified_email'=>true
		);
		$o->update("users",$data);
		$o->where("id",$uid);
		$email = $o->get("users")[0]['email'];
		// Delete the verification code.
		$o->where("code",$_GET['verify_token']);
		$o->delete("verifications");
	} else {
		$error = 1;
	}

	require("header.php");
?>
<script type="text/javascript">
	<?php 
		if ($error)
		{
			echo 'swal({title:"Error!",text:"The verification code is invalid.",type:"error"},function(){window.location.href="index.php"});';
		} else {
			echo 'swal({title:"Thank You!",text:"Your email ('.$email.') has been verified. You may now log in on the next page. ",type:"success"}, function(){window.location.href="signin.php"});';
		}
	?>
</script>