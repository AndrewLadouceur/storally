<?php
/**
 * @Author: ananayarora
 * @Date:   2016-03-31 12:03:51
@Last modified by:   ananayarora
@Last modified time: 2016-08-23T02:07:52+05:30
 * +
 * Added: session now holds $_SESSION[user_id]=users.id
 */

	$email = $_POST['email'];
	$password = $_POST['password'];

	require 'inc/mysqli.php';
	require 'inc/conf.php';
	require 'inc/functions.php';

	$c = new Conf();
	$o = new MysqliDb($c->host, $c->username, $c->password, $c->db);
	$f = new Functions();

	$o->where("fbid", "");
	$o->where("email",$email);
	$o->where("password",md5($password));

	$res = $o->get("users");
	if ($o->count){
		if ($f->isEmailVerified($email)) {
			session_start();
			$_SESSION['logged_in'] = true;
			$_SESSION['email'] = $email;
			$_SESSION['user_id'] = $res[0]['id'];
			echo "true";
		} else {
			echo "verifyemail";
		}
	} else {
		echo "false";
	}

?>
