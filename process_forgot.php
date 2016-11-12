<?php
	require("inc/conf.php");
	require("inc/mysqli.php");
	require("inc/functions.php");
	
	$f = new Functions();
	$f->checkSession();
	
	if ($_GET['action'] == "sendforgot")
	{
		$code = $f->generateRandomToken($_POST['email']);
		// 	Put the verification code in the database
		$f->o->where("email",$_POST['email']);
		$id = $f->o->get("users");
		if ($f->o->count == 1)
		
		{
			$data = Array(
				'uid'	=>	$id[0]['id'],
				'code'	=>	$code,
				'type'	=> 	"forgot",
				);
			$f->o->insert("verifications",$data);
// 			Send the email.
			$f->sendEmail($_POST['email'],"Password Reset Email","<img src='https://storally.com/img/logo_black.png' width='400px'></img><br /><h2>Forgot Password</h2><br /><p>Hello, <br /> Please <a href='https://storally.com/process_forgot.php?reset_token=".$code."'>Click here</a> to recover your account. <br /> Regards, <br /> Team Storally");
		} else {
//			There was no such user found. Throw an error. 
			echo "error";
		}
	} else if (isset($_GET['reset_token'])) {
		$f->o->where("code",$f->o->escape($_GET['reset_token']));
		$k = $f->o->get("verifications");
		if ($f->o->count == 1)
		{
// 			Show the new password dialog
			$include = "<script src='js/jquery.js'></script>";
			$include .= "<script src='js/sweetalert.min.js'></script>";
			$include .= "<link href='css/sweetalert.css' type='text/css' rel='stylesheet' />";
			$title = "Forgot Password";
			require("header.php");
			echo "<script>
					swal({
						type:'input',
						title:'Input new password',
						text: 'Enter your new password',
						html: true,
						inputPlaceholder: 'Enter Password here',
						inputType:'password'
					}, function(input)
					{
						if (input == '')
						{
							swal.showInputError('You need to enter a password');
							return false;
						} else {
							var data = 'newpassword='+input+'&token=". $f->o->escape($_GET['reset_token']) . "';
							swal('Please Wait','Your password is being changed','info');
							$.post('process_forgot.php?action=change_password', data, function(r){
								if (r == 'success')
								{
									swal({title:'Success!',text:'Your password has been reset',type:'success'}, function(){
										window.location.href='signin.php';	
									});	
								}
							});
						}
					});
			</script>";
		} else {
			$include = "<script src='js/jquery.js'></script>";
			$include .= "<script src='js/sweetalert.min.js'></script>";
			$include .= "<link href='css/sweetalert.css' type='text/css' rel='stylesheet' />";
			$title = "Forgot Password";
			require("header.php");
			echo "<script>
					swal('Error!','The token you entered is invalid.','error');
			</script>";
		}
	} else if ($_GET['action'] == "change_password") {
		if (isset($_POST['newpassword']) && $_POST['newpassword'] != "" && isset($_POST['token']) && $_POST['token'] != "")
		{
// 			Change the password and delete the token
			$f->o->where("code",$_POST['token']);
			$id = $f->o->get("verifications");
			if ($f->o->count == 1)
			{
				$uid = $id[0]['uid'];
				$f->o->where("id",$uid);
				$data = Array('password'=>md5($_POST['newpassword']));
				$f->o->update("users",$data);
				$f->o->where("code",$f->o->escape($_POST['token']));
				$f->o->delete("verifications");
				echo "success";
			} else {
				echo "error";
			}
		} else {
			echo "error";
		}
	} else {
		echo "error";
	}
?>