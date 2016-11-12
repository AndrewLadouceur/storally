<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-08 12:12:51
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-08 13:47:00
 */

	require __DIR__.'/../../inc/conf.php';
	require __DIR__.'/../../inc/mysqli.php';
	require __DIR__.'/../../inc/functions.php';

	$f = new Functions();
	$f->checkSession();
	if (!$f->checkLogin())
	{
		header("Location: 404.php");
	}

	if (isset($_GET['id']))
	{
		if ($f->getAcceptance($_GET['id']))
		{
			echo "true";
		} else {
			echo "false";
		}

	} else {
		header("Location: 404.php");
	}

?>