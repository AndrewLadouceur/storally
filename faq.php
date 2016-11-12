<?php
/**
 * @Author: ananayarora
 * @Date:   2016-05-28 19:20:06
@Last modified by:   ananayarora
@Last modified time: 2016-08-22T03:16:01+05:30
 */

	require("inc/conf.php");
	require("inc/mysqli.php");
	require("inc/functions.php");

	$f = new Functions();
	$f->checkSession();

	$include = "<link href='css/faq.css' type='text/css' rel='stylesheet' />";

	$title = "FAQ";
	require("header.php");
?>
<center>
<div class="wrap">
	<div class="faq">
		<div class="question">Q. Are my belongings safe?</div>
		<div class="answer">It is our top priority to ensure the safety of your belongings. All our allies are verified. Please refer to the storage contract for detailed information.</div>
	</div>
	<div class="faq">
		<div class="question">Q. My photo ID isn’t verified. What should I do?</div>
		<div class="answer">The verification process takes 24 hours. If you don’t receive a response within 24 hours, please contact us directly.</div>
	</div>
	<div class="faq">
		<div class="question">Q. Is it safe to keep belongings in my home/office?</div>
		<div class="answer">All our users are verified by ID and address.  You have complete control to accept/reject a storage request and to inspect the belongings before accepting them.</div>
	</div>
	<div class="faq">
		<div class="question">Q. How do I transport my belongings?</div>
		<div class="answer">In order to provide maximum flexibility to both parties we leave it to the Storee to arrange suitable transport for their belongings. We do suggest conferring with your Ally.</div>
	</div>
	<div class="faq">
		<div class="question">Q. How do I know what is being stored?</div>
		<div class="answer">The Storee will provide an inventory sheet for each container being stored.</div>
	</div>
	<div class="faq">
	</div>
</div>
</center>
<?php require("footer.php"); ?>
