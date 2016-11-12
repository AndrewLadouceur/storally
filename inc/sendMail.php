<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-16 03:40:34
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-16 04:07:31
 */

	require('conf.php');
	require('mysqli.php');
	require('functions.php');
	$f = new Functions();
	$f->sendEmail("i@ananayarora.com","lol","lol");
?>
