<?php
/**
 * @Author: ananayarora
 * @Date:   2016-03-30 02:20:56
@Last modified by:   ananayarora
@Last modified time: 2016-08-19T01:21:14+05:30
 */
	require 'inc/conf.php';
	require 'inc/mysqli.php';
	require 'inc/functions.php';

	$f = new Functions();
	$f->checkSession();

	$c = new Conf();
	$o = new MysqliDb($c->host,$c->username,$c->password,$c->db);


	if (isset($_SESSION['logged_in'])){
		header("Location: main.php");
	}
	require("inc/autoload.php");
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\Entities\AccessToken;
	use Facebook\HttpClients\FacebookCurlHttpClient;
	use Facebook\HttpClients\FacebookHttpable;
	FacebookSession::setDefaultApplication("1524117797897661","58a833ba2e8b4cc9194c5d33bbf7df7a");
	$helper = new FacebookRedirectLoginHelper("http://storally.com/facebook_login.php");
	try {
		$session = $helper->getSessionFromRedirect();
	} catch( FacebookRequestException $ex ) {
  		// When Facebook returns an error
	} catch( Exception $ex ) {
	  // When validation fails or other local issues
	}
	if (isset($session)){
		$request = new FacebookRequest($session, 'GET', '/me?fields=id,name,gender,email');
		$response = $request->execute();
		$graphObject = $response->getGraphObject();
		$fbid = $graphObject->getProperty('id');
		$fbfullname = $graphObject->getProperty('name');
		$femail = $graphObject->getProperty('email');
		// check if a normal user exists with the same email
		$o->where("email",$femail);
		$o->where("fbid","");
		$o->get("users");
		if ($o->count == 1)
		{
			header("Location: error.php?type=normalexists");
		} else {
			// insert into db if not exists
			$o->where("email",$femail);
			$o->get("users");
			if ($o->count == 0)
			{
				$data = array(
					'fbid'=>$fbid,
					'fullname'=>$fbfullname,
					'email'=>$femail,
					'ip'=>$_SERVER['REMOTE_ADDR'],
					'regtime'=>time(),
					'first_name'=>explode(' ',$fbfullname)[0],
					'last_name'=>explode(' ',$fbfullname)[1],
					'verified_email'=>true
				);
				$o->insert("users",$data);
				$f->sendEmail($femail, "Welcome to Storally","<center><img src='https://storally.com/img/logo_black.png' style='width:100px;'/></center><br /><br /><p>Welcome to Storally! <br /><p>Storally helps you find a host for your belongings while you are away. <br /><a href='https://storally.com'>Get started here</a></p>");
			}
			$_SESSION['fbid'] = $fbid;
			$_SESSION['fullname'] = $fbfullname;
			$_SESSION['email'] =  $femail;
			$_SESSION['logged_in'] = true;
			$o->where("email", $femail);
			$user = $o->getOne("users");
			$_SESSION["user_id"] = $user["user_id"];
			header("Location: main.php");
		}
	} else {
		$loginURL = $helper->getLoginUrl(array('scope'=>'email'));
		header("Location: ".$loginURL);
	}
?>
