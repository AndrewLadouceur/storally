<?php
/**
 * @Author: ananayarora
 * @Date:   2016-06-17 02:13:49
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-06-18 20:44:48
 */
?>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDCobO4v0gsYoPKsodPJvgwuVLAi2rkM6A"></script>
	<script type="text/javascript" src="../js/jquery.googlemap.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

		});
	</script>
	<style type="text/css">
		#map
		{
			width: 800px;
			height: 500px;
		}
	</style>
</head>
<body>
	<center>
		<h1>Map View</h1>
		<br />
		<form>
			<input type="text" name="search" placeholder="Enter Email" required>
			<input type="submit" />
		</form>
		<br />
		<?php 
			if (isset($_GET['search']))
			{
				require("../inc/mysqli.php");
				require("../inc/conf.php");
				$c = new Conf();
				$o = new MysqliDb($c->host, $c->username, $c->password, $c->db);
				$o->where("email",trim($_GET['search']));
				$k = $o->get("users")[0];
				if ($o->count != 0){
					echo '<br /><br />Name: '.$k['fullname'].'<br />';
					echo 'Email: '.$k['email'].'<br />';
					if ($k['fbid'] != "")
					{	
						echo 'Facebook Profile : <a href="http://facebook.com/'.$k['fbid'].'">View Profile</a><br />';
					}
					echo 'Ally: ';
					echo ($k['ally'] == true) ? "Yes" . '<br />' : "No" .'<br />';
					echo 'Verified Email: ';
					echo ($k['verified_email'] == true) ? "Yes" . '<br />' : "No" .'<br />';
					echo 'Verified Photo ID: ';
					echo ($k['verified_photo_id'] == true) ? "Yes" . '<br />' : "No" .'<br />';
					echo 'Terms and Conditions Accepted? : ';
					echo ($k['verified_photo_id'] == true) ? "Yes" . '<br />' : "No" .'<br />';
					echo 'IP : ' . $k['ip'];
					$ip_details = json_decode(file_get_contents("http://ipinfo.io/{$k['ip']}/json"));
					echo '<br />IP Location : ' . $ip_details->city . ', '.$ip_details->region.', '.$ip_details->country;
					if ($k['ally'] == true)
					{
						echo "<br />Ally Location : On Map";
						$o->where("user_id",$k['id']);
						$d = $o->get("spaces")[0];
						$lat = $d['latitude'];
						$add = $d['address'];
						$lon = $d['longitude'];
						$name = $d['name'];
					print_r($d);	
					?>
					<div id="map"></div>
					<script type="text/javascript">
					$(document).ready(function(){

						$("#map").googleMap({
							coords: [<?php global $lat; echo $lat; ?>,<?php global $lon; echo $lon; ?>],
						});
						$("#map").addMarker({
							coords: [<?php global $lat; echo $lat; ?>,<?php global $lon; echo $lon; ?>],
							title: '<div style="padding:20px;"><?php global $name; echo $name; ?></div>',
							text:'Address: <?php global $add; echo $add; ?><br />Coordinates: <?php global $lat; echo $lat; ?>,<?php global $lon; echo $lon; ?>'
						});
					});
					</script>

				<?php 
					}
				} else {
					echo "Not found";
				}

			}
		?>
	</center>
</body>
</html>
