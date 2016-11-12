<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-03-31 00:11:59
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-04-20 16:46:46
 */

	session_start();
	unset($_SESSION);
	session_destroy();
	header("Location: index.php");
?>