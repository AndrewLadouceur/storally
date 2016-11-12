<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-16 15:35:56
 * @Last Modified by:   eavci
 * @Last Modified time: 2016-08-03
 * Added:
 * fixed getField function by looking with user_id since it is faster
 */
// if (!@require("conf.php") && !@require("mysqli.php"))
// {

// 	require('mysqli.php');
// 	require('conf.php');
// }
require(__DIR__."/hav.php");
require(__DIR__."/Twilio/Twilio.php");
require(__DIR__."/vendor/autoload.php");

class Functions
{
	var $c;
	var $o;
	var $hav;

	public function __construct()
	{
		$this->c = new Conf();
		$this->o = new MysqliDb($this->c->host, $this->c->username, $this->c->password, $this->c->db);
	}
	public function checkSession()
	{
		if (!isset($_SESSION))
		{
			session_start();
		}
	}
	public function getFieldByUserId($id, $field)
	{
		$this->o->where("id",$id);
		$k = $this->o->get("users");
		return $k[0][$field];
	}
	public function checkLogin()
	{
		$this->checkSession();
		if (isset($_SESSION['fbid']))
		{
			return true;
		} else if (isset($_SESSION['logged_in']) && isset($_SESSION['email'])) {
			return true;
		} else {
			return false;
		}
	}
	public function getUserImage()
	{
		if ($this->getField("profile_pic") == "")
		{
			if (isset($_SESSION['fbid']))
			{
				return "http://graph.facebook.com/".$_SESSION['fbid']."	/picture?type=large&width=100&height=100";
			} else {
				return 'img/user.png';
			}
		} else {
			return $this->getField("profile_pic");
		}
	}
	public function getUserImageById($id)
	{
		if ($id != '')
		{
			$this->o->where("id",$id);
			$k = $this->o->get("users");
			if ($k[0]['profile_pic'] == "")
			{
				if ($k[0]['fbid'] != "")
				{
					return "http://graph.facebook.com/".$k[0]['fbid']."/picture?type=large&width=100&height=100";
				} else {
					return 'img/user.png';
				}
			} else {
				return $k[0]['profile_pic'];
			}
		} else {
			return false;
		}
	}
	public function getUserFirstName()
	{
		if (isset($_SESSION['fbid'])) {
			$e = explode(' ',$_SESSION['fullname']);
			return $e[0];
		} else if (isset($_SESSION['logged_in']) && isset($_SESSION['email'])) {
			$e = explode(' ', $this->getField('fullname'));
			echo $e[0];
		}
	}
	public function getUserName()
	{
		if (isset($_SESSION['fbid'])) {
			return $_SESSION['fullname'];
		} else if (isset($_SESSION['logged_in']) && isset($_SESSION['email'])) {
			$this->getField("fullname");
		}
	}
	public function getField($field)
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			if (isset($_SESSION['fbid']))
			{
				$this->o->where("fbid",$_SESSION['fbid']);
				$k = $this->o->get("users");
				return $k[0][$field];
			} else if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])) { /* fixed since id is primary key it should be faster to query */
				$this->o->where("id", $_SESSION['user_id']);
				$k = $this->o->get("users");
				return $k[0][$field];
			}
		}
	}
	public function isAlly()
	{
		$this->checkSession();

		if ($this->checkLogin())
		{
			if ($this->getField('ally') == "false" || $this->getField('ally') == "")
			{
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	public function getAllyField($field)
	{
		if ($this->isAlly())
		{
			$logged_in_id = $this->getField('id'); //Get the ID
			$this->o->where("user_id",$logged_in_id);
			return $this->o->get("ally")[0][$field];
		}

	}
	public function getDistance($lat1, $lon1, $lat2, $lon2)
	{
		$user = new POI($lat1, $lon1);
		$endpoint = new POI($lat2, $lon2);
		$d = $user->getDistanceInMetersTo($endpoint);
		return $d;
	}
	public function getPhoneNumber($id)
	{
		if ($this->getAcceptance($id))
		{
			$this->o->where("id",$id);
			$k = $this->o->get("ally")[0]['user_id'];
			$this->o->where("id",$k);
			return $this->o->get("users")[0]['phone'];
		} else {
			return "<a class='ask_for_details'>This person has not shared their details with you. Click here to ask for details.</a>";
		}

	}
	public function getEmail($id)
	{
		if ($this->getAcceptance($id))
		{
			$this->o->where("id",$id);
			$k = $this->o->get("ally")[0]['user_id'];
			$this->o->where("id",$k);
			return $this->o->get("users")[0]['email'];
		} else {
			return "<a class='ask_for_details'>This person has not shared their details with you. Click here to ask for details.</a>";
		}

	}
	public function getUserById($id)
	{
		$this->o->where("id",$id);
		return $this->o->get("users")[0];
	}
	public function getAllyById($id)
	{
		$this->o->where("id",$id);
		return $this->o->get("ally")[0];
	}
	public function getAcceptance($id)
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			$accepted = json_decode(($this->getField("accepted") == "") ? "{}": $this->getField('accepted'), true);
			if (array_search($id, $accepted) !== false)
			{
				return true;
			} else {
				return false;
			}
		}
	}
	public function accept($id,$allyID)
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			$accepted = json_decode(($this->getUserById($id)['accepted'] == "") ? "{}": $this->getUserById($id)['accepted'], true);
			$accepted[sizeof($accepted) + 1] = $allyID;
			$update = Array('accepted'=>json_encode($accepted));
			$this->o->where("id",$id);
			$this->o->update("users",$update);
		}
	}
	public function getRequest($id)
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			$this->o->where("sender",$this->getField("id"));
			$this->o->where("receiver",$id);
			$this->o->get("requests");
			if ($this->o->count)
			{
				echo "true";
				return true;
			} else {
				echo "false";
				return false;
			}
		}
	}
	public function isMailVerified()
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			if ($this->getField("verified_email") == "true")
			{
				return true;
			} else {
				// return false;
				return true;
			}
		}
	}
	public function isPhoneVerified()
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			if ($this->getField("verified_phone") == "true")
			{
				return true;
			} else {
				return false;
			}
		}
	}
	public function sendTextMessage($dest,$message)
	{

		$sid = "AC04c6d06348a76bb63d848e817c5b17fa";
		$token = "8f2fb64e320bb2266be863d7089efa50";

		$number = "5097036980";

		$client = new Services_Twilio($sid, $token);
		$message = $client->account->messages->sendMessage($number,$dest,$message);
		echo $message->id;

	}
	public function generateRandomCode($number)
	{
		$sms_code = substr(strrev(md5("storally".$number.round(microtime(true) * 1000))), 0, 6);
		return $sms_code;
	}
	public function generateRandomToken($email)
	{
		$email_code = strrev(sha1(md5("storally_email".$email.time())));
		return $email_code;
	}
	public function sendRandomCode($number, $sms_code)
	{
		// Generate the random code
		$this->sendTextMessage($number, "Thank you for registering on Storally! Your verification code is ".$sms_code);

	}
	public function uploadPicture($data)
	{
		$client_id = "5afda92df529389";
		$pvars   = array('image' => base64_encode($data));
  		$timeout = 30;
  		$curl = curl_init();
  		curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
  		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
  		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
  		curl_setopt($curl, CURLOPT_POST, 1);
  		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
  		$out = curl_exec($curl);
  		curl_close ($curl);
  		$pms = json_decode($out,true);
  		$url=$pms['data']['link'];
  		return $url;
	}
	public function isPhotoVerified()
	{
		$this->checkSession();
		if ($this->checkLogin())
		{
			if ($this->getField("verified_photo_id") == "true")
			{
				return true;
			} else {
				return false;
			}
		}
	}
	public function sendEmail($to, $subject, $text)
	{
		$sendgrid = new SendGrid('storally.com','Storally16');
		$email = new SendGrid\Email();
		$email->addTo($to);
		$email->setFrom('admin@storally.com');
		$email->setFromName('Storally');
		$email->setSubject($subject);
		$email->setHtml($text);
		$res = $sendgrid->send($email);
	}
	public function getBetaAcceptance($email)
	{
		$this->o->where("email",$email);
		$this->o->get("invites");
		return $this->o->count;
	}
}
?>
