<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-31 22:27:32
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-06-01 01:41:17
 */
	require '../inc/conf.php';
	require '../inc/mysqli.php';
	require '../inc/functions.php';
	
	$f = new Functions();
	$f->checkSession();

	if (isset($_POST['email']))
	{
		if ($f->getBetaAcceptance($_POST['email']))
		{
			echo "already";
		} else {
			$data = array(
				'email'=>$_POST['email'],
				'approved'=>1,
			);
			$f->o->insert("invites",$data);
			echo "success";
		}
	} else {
		echo "false";
	}

?>