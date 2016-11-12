<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-04-27 13:51:54
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-04-28 12:18:42
 */

	require '../../inc/conf.php';
	require '../../inc/mysqli.php';
	require '../../inc/functions.php';
	$f = new Functions();
	$f->checkSession();
	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}
	if ($f->isAlly())
	{
		$arr = Array();
		foreach ($_POST as $key => $value) {
			$arr[$key] = $f->o->escape(stripslashes($value));
		}
		$id = $f->getField("id");
		$f->o->where("user_id",$id);
		$f->o->update("ally",$arr);

	} else {
		if (isset($_SESSION['fbid']))
		{
			$f->o->where("fbid",$_SESSION['fbid']);
			$data = Array('ally'=>'true');
			$f->o->update("users",$data);
		} elseif (isset($_SESSION['logged_in']) && isset($_SESSION['email'])) {
			$f->o->where("email", $_SESSION['email']);
			$data = Array('ally'=>'true');
			$f->o->update("users", $data);
		}
		foreach ($_POST as $key => $value) {
			$arr[$key] = $f->o->escape(stripslashes($value));
		}
		$id = $f->getField("id");
		$arr['user_id'] = $id;
		$f->o->insert("ally",$arr);
	}

?>
