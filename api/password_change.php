<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-04-30 04:31:27
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-13 02:10:38
 */

	require '../inc/conf.php';
	require '../inc/mysqli.php';
	require '../inc/functions.php';
	
	$f = new Functions();
	$f->checkSession();
	
	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}

	if (!isset($_POST))
	{
		echo "403";
		exit;
	}

	if (isset($_SESSION['fbid']))
	{
		echo "fb";
		exit;
	}

	if (isset($_POST))
	{
		$currentpass = $_POST['currentpass'];
		$newpass = $_POST['newpass'];
		$confirmnewpass = $_POST['confirmnewpass'];
		$password = $f->getField("password");
		if ($password !== md5($currentpass))
		{
			echo "oldwrong";
			exit;
		}
		if ($newpass == "" || $currentpass == "" || $confirmnewpass == "")
		{
			echo "empty";
			exit;
		}
		if ($newpass == $currentpass)
		{
			echo "sameasold";
		} elseif ($newpass !== $confirmnewpass) {
			echo "newnomatch";
		} else {
			$data = Array(
				'password'=>md5($f->o->escape($confirmnewpass))
			);
			$f->o->where("email",$_SESSION['email']);
			$f->o->update("users",$data);
			echo "success";
		}
	}

?>