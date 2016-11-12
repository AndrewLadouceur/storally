<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-01 18:20:56
 * @Last Modified by:   meavci
 * @Last Modified time: 2016-08-24
 */

	$r = $_GET['radius'];
	$lat = $_GET['lat'];
	$lon = $_GET['lon'];

	require(__DIR__."/../../inc/mysqli.php");
	require(__DIR__."/../../inc/conf.php");
	require(__DIR__."/../../inc/functions.php");

	$f = new Functions();
	$allies = $f->o->get("spaces");

	$results = array();

	foreach ($allies as $ally_master_array_keys => $ally_array)
	{
		// Loop through all ally arrays
		$d = $f->getDistance($lat,$lon,$ally_array['latitude'], $ally_array['longitude']);

		if ($d <= $r)
		{

			// Add this to the return result
			$push["link"] = 'view_ally.php?id='.$ally_array['id'];
			$push["lat"] = $ally_array['latitude'];
			$push["lon"] = $ally_array['longitude'];
			$push["title"] = stripslashes(htmlentities($f->getFieldByUserId($ally_array['user_id'], "fullname")));
			$sizes = array("sm" => "Small", "md" => "Medium", "lg" => "Large", "xl" => "Extra Large");
			$price = "";
			foreach($sizes as $size => $size_name) {
				if($ally_array[$size."_price_weekly"] != "0") {
					$price .= $size_name . ": " . number_format($ally_array[$size."_price_weekly"] / 100, 2) . ' ' . strtoupper($ally_array["currency"]) ." / week <br />";
				}
				if($ally_array[$size."_price_monthly"] != "0") {
					$price .= $size_name . ": " . number_format($ally_array[$size."_price_monthly"] / 100, 2) . ' ' . strtoupper($ally_array["currency"]) ." / month <br />";
				}
			}
			$push["price"] = $price;
			$push["image"] = "<img src='".$f->getUserImageById($ally_array['user_id'])."' style='width:150px; border-radius:100%;'></img>";
			if ($d > 1000)
			{
				$push["dist"] = number_format((float)($d / 1000), 2, '.', '') . " km";
			} else {
				$push["dist"] = number_format((float)$d, 2, '.', '') . " m";
			}
			array_push($results, $push);
		}
	}

	echo json_encode($results);
?>
