<?php

	require("inc/conf.php");
	require("inc/mysqli.php");
	$title = "Storally";
	$landing = "true";
	$include = file_get_contents('include.php');
	require("header.php");
?>/
<?php
/**
 * @Author: ananayarora
 * @Date:   2016-04-15 01:28:54
@Last modified by:   ananayarora
@Last modified time: 2016-08-23T02:21:29+05:30
 */
?>

	<div class="welcome">
		<div class="overlay"></div>
		<img src="https://storally.com/img/logo_white.png" class="logo">
		<br>
		<div class="divider"></div>
		<div class="slogan">Storally helps you find a host for your belongings while you are away.</div>
		<br />
		<div class="find_text">Find an Ally near you.</div>
		<?php
			// if ($f->checkLogin())
			// {
				// if ($f->getBetaAcceptance($_SESSION['email']))
				// {
					echo "<div class=\"searchbar\"><input type=\"text\" class=\"search_bar_home\" placeholder=\"Enter the location where you would like to store your items\">
					<div class=\"search_button submit_button\">SEARCH</div>
					</div>";
				// } else {
					// echo "<div class=\"searchbar\">Your account is in review for our beta program. Please come back later.</div>";
				// }
			// } else {
				// echo "<div class=\"searchbar\"><input type=\"text\" class=\"beta_home\" placeholder=\"Enter your email to get access to the beta\"><div class=\"beta_button submit_button\">Get Beta</div></div>";
			// }
		?>
	</div>
	<div id="us2" style="display:none;"></div>
	<div id="us2-lat" style="display:none;"></div>
	<div id="us2-lon" style="display:none;"></div>
	<center>
		<div class="how_it_works">
			<div class="title">How it works</div>
			<br />
			<br />

			<div class="tooltip">
			<div class="search item">
				<i class="fa fa-search"></i>
				<span class="tooltiptext">
					Start by searching for Allies in your area
				</span>
				<br />
				<p>Search</p>
			</div>
			</div>


			<div class="tooltip">
			<div class="search item">
				<i class="fa fa-globe"></i>
				<span class="tooltiptext">
					Select an Ally who matches your criteria
				</span>
				<br />
				<p>Select</p>
			</div>
			</div>

			<div class="tooltip">
			<div class="search item">
				<i class="fa fa-user"></i>
				<span class="tooltiptext">
					Request to store your belongings
				</span>
				<br />
				<p>Request</p>
			</div>
			</div>

			<div class="tooltip">
			<div class="search item">
				<i class="fa fa-connectdevelop"></i>
				<span class="tooltiptext">
					Connect with the Ally to discuss storage details
				</span>
				<br />
				<p>Connect</p>
			</div>
			</div>


		</div>
		<br>
		<br>
		<div class="def">
			<div class="title">Storee</div>
			<br />
			<p>A storee is someone looking to store their belongings</p>
		</div>
		<div class="def" style="background:#11866F">
			<div class="title">Ally</div>
			<br />
			<p>An ally is someone willing to host someone’s belongings</p>
		</div>
		<!-- <div class="sec">
			<div class="title">What's in a listing?</div>
			<br />
			<p>You set the rules for who, what belongings and for how long. Storee preferences help hosting fit into your lifestyle.</p>
		</div> -->
	
		<div class="sec half">
			<div class="title">What can I store?</div>
			<br />
			<br />
			<br />
			<p class="desc">“From books and bikes to your favorite jacket, Storally allows you to store your belongings for as low as $5/month.<br /><div class="signup_btn"><a style="color:#fff; text-decoration:none; cursor:pointer;" href="img/catalog.pdf" target="_blank">Find more</a></div></p>
		</div>
		<div class="sec half" style="border-left:1px solid #333;">
		<div class="title">Why become an Ally?</div>
		<br />
		<!-- <p>As an Ally, you can earn <b>upto $50/week</b> by hosting someone's belongings. You can accept/reject a Storee's request and decide who stores, what belongings and 
for how long.You can monetize the extra space you have at home, garage or office by hosting just a few boxes/luggage.
			<br />
			<br />
			<div class="signup_btn"><a href="https://storally.com/signup.php">Sign up now</a></div>
		</p> -->
		<p>
			<ul class="bullet_points">
				<li>Earn more than $15/week</li>
				<li>Decide who stores, what belongings and for how long in your space by accepting/rejecting requests.</li>
				<li>Utilize and monetize the space in your cupboard, dorm, house or apartment.</li>
			</ul>
			<br />
			<div class="signup_btn"><a href="https://storally.com/signup.php">Sign up now</a></div>
		</p>
	</div>
		<div class="clear"></div>
		<div class="testimonials">
			<h1>Testimonials</h1>
			<br />
			<br />
			<br />
			<h2 class="quote"></h2>
			<br />
			<br />
			<br />
			<span class="quote_author"></span>
		</div>
		<div class="clear"></div>
	</center>
	<?php require("footer.php"); ?>
</body>
</html>
<!-- display: block;
    margin-top: 0px;
    position: fixed;
    top: 50%;
    height: 87%;
    width: 57%;
    left: 67%;
    transform: translate(-50%,-50%); -->
