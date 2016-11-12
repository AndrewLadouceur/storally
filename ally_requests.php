<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-09 01:16:03
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-09 17:43:56
 */

	require 'inc/conf.php';
	require 'inc/mysqli.php';
	require 'inc/functions.php';

	$f = new Functions();
	$f->checkSession();

	$title = "Requests from Storee";
	$include = '<link rel="stylesheet" type="text/css" href="css/ally_requests.css">';
	$include .= '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	$include .= '<script src="js/ally_requests.js"></script>';

	require 'header.php';
?>
	<div class="box">
		<center><h1>Requests from Storees</h1></center><br /><br />
<?php 
	$f->o->where("receiver", $f->getAllyField("id"));
	$k = $f->o->get("requests");
	foreach ($k as $key => $value) {
		echo "<div class=\"request\">";
		echo "<img src='http://placehold.it/300x300' class='image'></img><br /><br />";
		echo "<div class=\"full_name\">".$f->getUserById($value['sender'])['fullname']."</div><br />";
		echo "<div class=\"message\">".$value['message']."</div><br />";
		echo "<div class=\"submit_button accept_button\" request-id=\"".$value['id']."\">Accept</div>";
		echo "<div class=\"submit_button reject_button\" request-id=\"".$value['id']."\">Reject</div>";
		echo "</div>";
	}
?>

</div>
