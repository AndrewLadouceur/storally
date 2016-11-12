<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-04-20 06:05:47
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-04-20 12:54:58
 */

require('inc/mysqli.php');
require('inc/conf.php');
require('inc/functions.php');
$f = new Functions();
$f->checkSession();
$c = new Conf();
$o = new MysqliDb($c->host, $c->username, $c->password, $c->db);
if ($f->checkLogin())
{
	if (isset($_POST)) 
	{
		$updateArray = Array();
		foreach ($_POST as $key => $value) 
		{
			$updateArray[$key] = $o->escape(stripslashes($value));
			if (isset($_SESSION['fbid']))
			{
				$o->where("fbid",$_SESSION['fbid']);
				$o->update("users",$updateArray);
			}
		}
	} else {
		echo "false";
	}
} else {
	echo "false";
}
?>
