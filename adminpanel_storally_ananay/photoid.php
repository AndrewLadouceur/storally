<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-20 14:52:06
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-21 03:06:39
 */
	require("../inc/conf.php");
	require("../inc/mysqli.php");
	require("../inc/functions.php");

	$f = new Functions();
?>
<html>
<head>
	<title></title>
	<style type="text/css">
		*
		{
			font-family: "Open Sans","Helvetica Neue","Segoe Ui Light","sans-serif";
			font-weight:300;
		}
		body
		{
			background:#eee;
		}
		.person
		{
			padding:20px;
			width: 200px;
			position: relative;
			background:#fff;
			display: inline-block;
		}
		.name
		{
			font-size: 20pt;
			text-align: center;
		}
		.image
		{
			width: 200px;
			text-align: center;
		}
		.accept_button
		{
			padding:10px;
			background:#16a085;
			color:#fff;
			width: 40%;
			display: inline-block;
		}
		.reject_button
		{
			padding:10px;
			background:#c0392b;
			color:#fff;
			width: 40%;
			display: inline-block;
		}
	</style>
</head>
<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".accept_button").click(function(){
			var id = $(this).prop('id');
			$.post("action.php?action=accept&accept_id="+id, function(r){
				if (r == "success")
				{
					swal("Accepted","You have accepted this request","success");
				} else {
					console.log(r);
				}
			});
			$(this).parent().fadeOut();
		});
		$(".reject_button").click(function(){
			var id = $(this).prop('id');
			$.post("action.php?action=reject&reject_id="+id, function(r){
				if (r == "success")
				{
					swal("Rejected","You have rejected this request","reject");
				} else {
					console.log(r);
				}
			});
			$(this).parent().fadeOut();
		});
	});
</script>
<body>
	<center>
		<br>
		<h1>PhotoIDs Pending Verification</h1>
	<br />
	<p>No. of Pending PhotoID Verifications: <?php $f->o->where("verified_photo_id","false"); $f->o->where("photoid","","!="); $f->o->get("users"); echo $f->o->count; ?></p>
	<p>No. of users who haven't uploaded a Photo ID: <?php $f->o->where("verified_photo_id","false"); $f->o->where("photoid",""); $f->o->get("users"); echo $f->o->count; ?></p>
	<p>No. of verified Photo IDs: <?php $f->o->where("verified_photo_id","true"); $f->o->get("users"); echo $f->o->count; ?></p>
	<p>No. of rejected Photo IDs: <?php $f->o->where("verified_photo_id","rejected"); $f->o->get("users"); echo $f->o->count; ?></p>
	<br />
	<?php 
		$f->o->where("photoid","","!=");
		$f->o->where("verified_photo_id","false");
		$a = $f->o->get("users");
		foreach ($a as $key => $value) {
				echo "<div class=\"person\">";
				echo "<img src='".$value['photoid']."' class=\"image\"></img>";
				echo "<br />";
				echo "<br />";
				echo "<center><span class=\"name\">".$value['fullname']."</span></center><br />";
				echo "<center><span class=\"email\">".$value['email']."</span></center><br />";
				echo "<div class=\"accept_button\" id=\"".$value['id']."\">Accept</div>";
				echo "<div class=\"reject_button\" id=\"".$value['id']."\">Reject</div>";
				echo "</div>";
		}
	?>
	</center>
</body>
</html>