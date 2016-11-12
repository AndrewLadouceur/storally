<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-05-14 09:22:59
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-14 10:52:35
 */

	require "../inc/conf.php";
	require "../inc/mysqli.php";
	require "../inc/functions.php";

	$f = new Functions();
	$f->checkSession();
	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}
	if (!isset($_FILES))
	{
		header("Location: index.php");
	}

	$file = $_FILES['image']['tmp_name'];

	// Get the image dtaa
	$image_data = file_get_contents($file);

	$url = $f->uploadPicture($image_data);
	if ($url != "")
	{
		// Store the image URL in the database
		$f->o->where("user_id", $f->getField("id"));
		$data = Array(
			'photo'=>$url
		);
		$f->o->update("ally",$data);
	}
?>