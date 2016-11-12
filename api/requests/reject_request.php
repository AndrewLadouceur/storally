<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-09 03:18:12
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-09 19:30:06
 */

	
	require '../../inc/conf.php';
	require '../../inc/mysqli.php';
	require '../../inc/functions.php';

	$f = new Functions();
	$f->checkSession();

	$id = $_GET['reqid'];

	if (!$f->checkLogin())
	{
		header("Location: 404.php");
	} else {
		$f->o->where("id",$id);
		$sender = $f->o->get("requests");
		// Delete the request
		$f->o->where("id",$id);
		$f->o->delete("requests");
	}
?>