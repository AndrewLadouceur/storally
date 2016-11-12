<?php
if(!isset($_GET['redirect'])) {
	die('invalid access');
}

require_once('ui.php');
ChargeUI::validate(120);
?>