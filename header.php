<?php
/**
 * @Author: ananayarora
 * @Date:   2016-03-30 23:59:09
@Last modified by:   eavci
@Last modified time: 2016-08-22
 */
	if (!class_exists('Functions')) {
		require("inc/functions.php");
		$f = new Functions();
		$f->checkSession();
	}
	if ($_SERVER['REQUEST_URI'] != "/t&c.php")
	{
		if($f->checkLogin())
		{
			if ($f->getField("tandc") == "false")
			{
				header("Location: t&c.php");
			}
		}
	}
/*
	if ($_SERVER['PHP_SELF'] !== "/index.php" && $_SERVER['PHP_SELF'] !== "/" && (strpos($_SERVER['PHP_SELF'], "error.php") == false))
	{
		if ($f->checkLogin())
		{
			if (!$f->getBetaAcceptance($_SESSION['email']))
			{
				header("Location: error.php?type=notbeta");
			}
		}
	}
*/

?>
<html>
<head>
	<title><?php echo $title; ?></title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<?php echo $include; ?>
	<script src="https://use.fontawesome.com/dbcdf6f26d.js"></script>
	<script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  	ga('create', 'UA-77537649-1', 'auto');
  	ga('send', 'pageview');
  	ga('set', 'userId', '<?php echo $f->getField("email"); ?>');

	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			(function($){$.fn.replaceText=function(b,a,c){return this.each(function(){var f=this.firstChild,g,e,d=[];if(f){do{if(f.nodeType===3){g=f.nodeValue;e=g.replace(b,a);if(e!==g){if(!c&&/</.test(e)){$(f).before(e);d.push(f)}else{f.nodeValue=e}}}}while(f=f.nextSibling)}d.length&&$(d).remove()})}})(jQuery);
    		$('*').replaceText( /\bally\b/gi, 'Ally' );
    		$('*').replaceText( /\bstoree\b/gi, 'Storee' );
    		$('*').replaceText( /\bstorally\b/gi, 'Storally' );
    		$('*').replaceText( /\bstorees\b/gi, 'Storees' );
    		$('*').replaceText( /\ballies\b/gi, 'Allies' );
    		$('*').replaceText( /\bstuff\b/gi, 'Belongings' );
		});
	</script>
	<link rel="stylesheet" href="css/responsive.css" type="text/css" media="screen" charset="utf-8">
	<link rel="icon"
      type="image/png"
      href="img/symbol.png">
</head>
<body>

<div class="master_head">
	<a href='http://storally.com'><img src="img/symbol.png" class="symbol"></a>

	<div class="menu">
		<ul>
			<?php
				if ($f->checkLogin())
				{
				if (!isset($landing)){
			?>
				<li><a href="search.php">Search</a><br /><div class="border"></div></li>
			<?php } ?>

					<li><a href="profile.php">Profile</a><br /><div class="border"></div></li>
			<?php
				if (!$f->isAlly())
				{
			?>
					<li><a href="ally2.php">Become an Ally</a><br /><div class="border"></div></li>
			<?php
				} else {
			?>
					<li><a href="ally2.php">Ally Settings</a><br /><div class="border"></div></li>
					<li><a href="ally_requests.php">Requests from storees</a><br /><div class="border"></div></li>
			<?php
				}
			?>
				<li><a href="faq.php">FAQ</a><br /><div class="border"></div></li>
					<li><a href="logout.php">Logout</a><br /><div class="border"></div></li>
			<?php
				} else {
				if (!isset($landing)){
			?>
				<li><a href="search.php">Search</a><br /><div class="border"></div></li>
			<?php } ?>
				<li><a href="signin.php">Sign in</a><br /><div class="border"></div></li>
				<li><a href="new_signup.php">Sign up</a><br /><div class="border"></div></li>
				<li><a href="signup.php">Become an ally</a><br /><div class="border"></div></li>
				<li><a href="faq.php">FAQ</a><br /><div class="border"></div></li>
			<?php
				}
			?>

		</ul>
	</div>

	<div class="logged_in_user">
		<?php
			if ($f->checkLogin())
			{

		?>
			<span class="user_name"><?php echo $f->getUserFirstName(); ?></span></img>
			<img src="<?php echo $f->getUserImage(); ?>" class="user_picture">
		<?php
			} else {

		?>
			<span class="user_name">Guest</span>
			<img src="img/user.png" class="user_picture">
		<?php
			}
		?>
	</div>
</div>
