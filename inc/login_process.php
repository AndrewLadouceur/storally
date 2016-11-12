<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-03-31 12:03:51
 * @Last Modified by:   eavci
 * @Last Modified time: 2016-08-03 01:35:00
 * +
 * Added: session now holds user_id=users.id too.
 */

	$email = $_POST['email'];
	$password = $_POST['password'];

	require 'inc/mysqli.php';
	require 'inc/conf.php';

	$c = new Conf();
	$o = new MysqliDb($c->host, $c->username, $c->password, $c->db);

	$o->where("fbid", "");
	$o->where("email",$email);
	$o->where("password",md5($password));

	$o->get("users");
	if ($o->count){
		session_start();
		$_SESSION['logged_in'] = true;
		$_SESSION['email'] = $email;
		$_SESSION['user_id'] = $o[0]['id']
		echo "true";
	} else {
		echo "false";
	}

?>