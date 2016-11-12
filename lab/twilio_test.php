<?php
	require("../inc/Twilio/Twilio.php");
	
	$sid = "AC04c6d06348a76bb63d848e817c5b17fa";
	$token = "8f2fb64e320bb2266be863d7089efa50";

	$number = "5097036980";
	$dest = "+918826516848";
	$message = "Your code is - ".time();

	$client = new Services_Twilio($sid, $token);
	$message = $client->account->messages->sendMessage($number,$dest,$message);

	echo $message->id;
		
?>
