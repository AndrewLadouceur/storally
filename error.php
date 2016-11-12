<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-30 14:56:03
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-06-01 01:54:27
 */

	require("inc/conf.php");
	require("inc/mysqli.php");
	require("inc/functions.php");

	$f = new Functions();
	$f->checkSession();
	
	$title = "Error";
	$include = "<link href='css/sweetalert.css' rel='stylesheet' type='text/css' />";
	$include .= "<script src='js/jquery.js'></script>";
	$include .= "<script src='js/sweetalert.min.js'></script>";

	require('header.php');
?>
<script>
	<?php 
		if (isset($_GET['type'])) {
			switch ($_GET['type']) {
				case 'normalexists':
					echo "swal({title:'Error!',text:'A normal account with a password exists with that email. Please login using your password and not your Facebook account.',type:'error'},function(){window.location.href='signin.php'});";
					break;
				case '403':
					echo "swal({title:'403',text:'Forbidden',type:'error'},function(){window.location.href='index.php'});";
					break;
				case '404':
					echo "swal({title:'404',text:'Not Found',type:'error'},function(){window.location.href='index.php'});";
					break;
				case 'notbeta':
					echo 'swal({title:"Beta",text:"Your account does not have beta access.",type:"error"},function(){window.location.href=\'index.php\'});';
					break;
				default:
					echo "swal({title:'Error',text:'Unknown Error',type:'error'},function(){window.location.href='index.php'});";
					# code...
					break;
			}
		} else {
			echo "swal({title:'Error',text:'Unknown Error',type:'error'},function(){window.location.href='index.php'});";
		}
	?>

</script>