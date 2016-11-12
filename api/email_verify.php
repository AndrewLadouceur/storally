<?php
	require '../inc/conf.php';
	require '../inc/mysqli.php';
	require '../inc/functions.php';

	$f = new Functions();
	$f->checkSession();

	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}

	if ($f->isMailVerified())
	{
		header("Location: index.php");
	}

	// $f->sendEmail("i@ananayarora.com","Test","Hello");

?>
