<?php
/**
 * @Author: ananayarora
 * @Date:   2016-06-22 02:55:35
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-06-22 02:56:52
 */

	require ('../inc/conf.php');
	require ('../inc/mysqli.php');
	require ('../inc/functions.php');

	$f = new Functions();
	$f->checkSession();

	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}
	if (!isset($_FILES['image']))
	{
		header("Location: index.php");
	}

	$file = $_FILES['image']['tmp_name'];

	// Get the image data
	$image_data = file_get_contents($file);

	$url = $f->uploadPicture($image_data);

	if ($url != "")
	{
		// Great so the pictures uploaded to imgur. Store the image URL in the databse.
		$f->o->where("id",$f->getField("id"));
		$data = Array(
			'profile_pic'=>$url
		);
		$f->o->update("users",$data);
		echo "success";
	} else {
		echo "error";
	}
?>
