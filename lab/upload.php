<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-30 10:46:24
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-04-30 14:44:59
 */

	require('../inc/functions.php');
	require('../inc/conf.php');
	require('../inc/mysqli.php');

	$f = new Functions();
	$f->checkSession();

	if ($f->isAlly()){
		$imgs = json_decode($f->getAllyField("imgs"));
	}
?>

<html>
<head>
	<title>Upload Pictures</title>
	<link rel="stylesheet" type="text/css" href="css/dropzone.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/upload.js"></script>
</head>
<body>
	<script type="text/javascript" src="//api.filepicker.io/v2/filepicker.js"></script>
	<input type="filepicker-dragdrop" data-fp-apikey="AhTgLagciQByzXpFGRI0Az" data-fp-mimetypes="*/*" data-fp-container="modal" data-fp-services="COMPUTER,FACEBOOK,GOOGLE_DRIVE,INSTAGRAM,IMAGE_SEARCH,URL,WEBCAM" onchange="sendToServer(event.fpfile.url)">
</body>
</html>