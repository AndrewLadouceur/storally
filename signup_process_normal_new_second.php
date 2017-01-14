<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-21 11:26:59
@Last modified by:   ananayarora
@Last modified time: 2016-08-22T01:27:59+05:30
 */
	require('inc/mysqli.php');
	require('inc/conf.php');
	require('inc/functions.php');

	$c = new Conf();
	$o = new MysqliDb($c->host,$c->username,$c->password,$c->db);
	$f = new Functions();


	if (isset($_POST))
	{
		$o->where('email', $_POST['email']);
		$o->get('users');
		if ($o->count >= 1)
		{
			echo "inuse";
		} else {
			$data = Array(
				//'fullname'=>$o->escape(stripslashes($_POST['fullname'])),
				'email'=>$o->escape(stripslashes($_POST['email'])),
				//'password'=>$o->escape(stripslashes(md5($_POST['password']))),
				'ip'=>$_SERVER['REMOTE_ADDR'],
				//'first_name'=>$o->escape(stripslashes(explode(' ',$_POST['fullname'])[0])),
				//'last_name'=>$o->escape(stripslashes(explode(' ',$_POST['fullname'])[1])),
				'ally'=>'false',
				'regtime'=>time()
			);
			$id = $o->insert("users", $data);
			$token = $f->generateRandomToken($_POST['email']);
			$data = Array(
				'uid'=>$id,
				'type'=>'email',
				'code'=>$token
			);
			$o->insert('verifications', $data);
			$f->sendEmail($o->escape(stripslashes($_POST['email'])),"Email Verification","<center><img src=\"https://storally.com/img/logo_black.png\" style=\"width:300px;\"></img><br /><h3>Welcome to Storally</h3><p>Please confirm your email by clicking the confirmation link below.</p><br /><br /><a href=\"https://storally.com/verify_email.php?verify_token=".$token."\">Confirm Mail</a></center>");
			echo "success";
		}
	} else {
		echo "403";
	}

?>
