<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-28 06:27:35
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-03 13:49:41
 */

	require("../../inc/conf.php");
	require("../../inc/mysqli.php");
	require("../../inc/functions.php");
	
	$f = new Functions();
	$f->checkSession();

	if ($f->isAlly())
	{
		echo stripslashes($f->getAllyField($_GET['field']));
	} else {
		echo "false";
	}

?>