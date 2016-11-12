<?php 
/**
 * @Author: ananayarora
 * @Date:   2016-04-20 15:41:24
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-05-15 04:54:17
 */
	require("inc/mysqli.php");
	require("inc/conf.php");
	require("inc/functions.php");

	$title = "Storally";
	$include = '<link rel="stylesheet" type="text/css" href="css/main.css">';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/script.js"></script>';
	
	$f = new Functions();
	$f->checkSession();
	
	if (!$f->checkLogin())
	{
		header("Location: index.php");
	}

	header("Location:search.php");
	// require("header.php");
?>

