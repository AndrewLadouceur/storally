<?php
	/**
 * @Author: ananayarora
 * @Date:   2016-05-28 19:20:06
 * @Last Modified by:   ananayarora
 * @Last Modified time: 2016-07-16 20:34:12
 */

	require("inc/conf.php");
	require("inc/mysqli.php");
	require("inc/functions.php");

	$f = new Functions();
	$f->checkSession();

	// if (!$f->checkLogin())
	// {
	// 	header("Location: index.php");
	// }

	$title = "Terms & Conditions";
	$include = "<link href='css/sweetalert.css' type='text/css' rel='stylesheet' />";
	$include .= "<script src='js/jquery.js'></script><script src='js/sweetalert.min.js'></script>";
	require("header.php");

	if (isset($_POST['accept']) && ($f->checkLogin()))
	{
		$f->o->where("email",$_SESSION['email']);
		$data = Array(
			'tandc'=>'true'
		);
		$f->o->update("users",$data);
	}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".submit_button").click(function(){
			$.post('t&c.php',"accept=true",function(r){
				swal({title:"Accepted!",text:"Thank you for accepting the terms and conditions.",type:"success"},function(){
					window.location.href="https://storally.com/profile.php";
				});
			});
		});
	});
</script>
<style type="text/css">
	*
	{
		margin:0;
		padding:0;
	}
	body
	{
		overflow-x:hidden;
	}
	.wrap
	{
		margin-top:100px;
		width: 50%;
		margin-left:25%;
		background: #fff;
 		width: 50%;
 		border: 1px solid rgba(100, 100, 100, 0.1);
 		box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
 		padding:30px;
 		height:65%;
	}
	p
	{
		margin:30px;
	}
	.footer_text
	{
		position: absolute !important;
		top:0 !important;
	}
	.submit_button
	{
  		padding: 20px;
  		padding-bottom: 15px;
  		padding-top: 15px;
  		background: #16a085;
  		width: 100px;
  		text-align: center;
  		color: #fff;
  		cursor: pointer;
  		float:left;
	}
	.disagree_button
	{
  		padding: 20px;
  		padding-bottom: 15px;
  		padding-top: 15px;
  		background: #16a085;
  		width: 100px;
  		text-align: center;
  		color: #fff;
  		cursor: pointer;
  		float: left;
  		margin-left:40px;
	}
	.disagree_button a
	{
		color:#fff;
		text-decoration: none;
		display:inline-block;
	}
	.t_and_c_box
	{
		border:1px solid #999;
		overflow:scroll;
		margin-top:30px;
		height:70%;
	}
	body
	{
		background:#eee;
	}
	.footer
	{
		position: fixed !important;
		bottom:0 !important;
		width:100%;
	}
	.clear
	{
		clear:both;
	}
</style>


<div class="wrap">
	<center>
		<h1>Terms and Conditions</h1>
	</center>
	<br />
	<center>
<?php
	if ($f->checkLogin()) {
		echo  '<div class="submit_button">I agree</div>';
		echo '<div class="disagree_button"><a href="contact.php">I disagree</a></div>';
	}
?>
</center>
<div class="clear"></div>
<div class="t_and_c_box">
<br />
	<br />
<p>In consideration of the respective covenants contained herein, the parties hereto, agree as follows:</p>

<p><b>Property Being Stored</b></p>

<p>Storee owns the following property and requires a facility or location to temporarily store said Belongings mentioned on the inventory sheet. </p>

<p><b>Storage Facility</b></p>

<p>During the term of this Agreement, the  Ally agrees to host the belongings  in safe keeping at their specified location on their Ally profile which offers storage for the Belongings. And the Ally hereby agrees to store the Belongings for the Storee.</p>

<p><b>Storage Period</b></p>

<p>This Agreement shall commence on the date the Ally receives the belongings of the Storee and continue until the agreed upon time period, unless the Storee takes back their Belongings earlier.</p>

<p><b>Payments</b></p>

<p>The Storee agrees to pay the agreed upon amount per time period specified to the Ally.</p>

<p><b>No Refunds</b></p>

<p>Any unused portion of storage fees paid by the Storee is not refundable, unless the Ally, for any reason, terminates the storage contract.</p>


<p><b>Termination of Storage</b></p>

<p>The Ally reserves the right to terminate this Agreement at any time by giving the Storee thirty (30) days written notice of its intention to do so. In the event if the Storee fails to remove any stored Products within the thirty (30) days period the Ally reserves the right to have the same removed at the cost and expense of the Storee. In such an event the Ally shall be relieved of any liability with respect to such goods therefore or thereafter incurred.
In the event if the Storee does not pay any unpaid balance of storage fees, the Ally after giving the Storee an advance thirty (30) days written notice, treat the Belongings as abandoned. The Ally will sell such abandoned Belongings in a commercially reasonable manner and apply the proceeds to the costs of sale and any unpaid storage fees.</p>

<p><b>Ownership of the Belongings</b></p>

<p>Title to the Belongings shall at all times remain with the Storee. Nothing contained in this
Agreement shall be construed or interpreted as conveying title to, or any interest in, the
Property to the Ally.</p>

<p><b>Warranties</b></p>

<p>The Storee represents and warrants that it is the legal owner of the Belongings and has the legal right and authority to contract for services for all of the Belongings. The Storee agrees to indemnify and hold harmless the Ally from and against any and all claims relating to breach of this warranty.</p>

<p><b>Condition of the Belongings</b></p>

<p>The Ally agrees to exercise reasonable care to protect the Belongings from theft or
damage, and shall maintain adequate insurance to protect the Storee from any loss or
damage caused by the Ally’s negligence. If any damage is incurred to the Belongings, the Ally assumes full responsibility and shall be liable to reimburse the Storee for the damages.</p>

<p><b>Warranty Disclaimer</b></p>

<p>THE ALLY PROVIDES THE FACILITY AND THE SERVICES "AS IS" WITHOUT WARRANTY OF ANY KIND EITHER EXPRESS, IMPLIED OR STATUTORY, INCLUDING BUT NOT LIMITED TO THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. THIS DISCLAIMER OF WARRANTY CONSTITUTES AN ESSENTIAL PART OF THIS AGREEMENT.</p>

<p><b>Dangerous and Hazardous Materials</b></p>

<p>The Storee shall not place or keep in or on the Premises explosives, flammable liquids, or any other goods prohibited by the law and shall be held liable accordingly.</p>


<p><b>Force Majeure</b></p>

<p>In the event either party is unable wholly or in part by force majeure to carry out its obligations under this agreement, other than to make payments of amounts due hereunder, the party shall give notice in writing, and the obligations of such party, shall be suspended during the continuance of any inability so caused.</p>

<p><b>Entire Agreement</b></p>

<p>This Agreement represents the entire understanding between the parties hereto. It replaces and supersedes any and all oral agreements between the parties, as well as any prior writings.</p>

<p><b>Successors and Assignees</b></p>

<p>This agreement binds and benefits the heirs, successors, and assignees of the parties.</p>

<p><b>Notices</b></p>

<p>All notices which may be or are required to be given by any party to the other under this
Agreement, shall be in writing and (i) delivered personally, or (ii) sent by prepaid courier
service or registered mail with acknowledgement of receipt to the parties at their
respective addresses first above mentioned. Any such notice so given shall be deemed
conclusively to have been given and received when so personally delivered or delivered,
by courier or on the fifth day, in the absence of evidence to the contrary, following the
sending thereof by registered mail. Any party may from time to time change its address
hereinbefore set forth by notice to the other parties in accordance with this paragraph.</p>

<p><b>Dispute Resolution</b></p>

<p>Any controversy or claim arising out of or relating to this contract the breach thereof, or the goods affected thereby, whether such claims be found in tort or contract shall be settled by arbitration under the rules the rules of the American Arbitration Association, provided however, that upon any such arbitration the arbitrator(s) may not vary or modify any of the foregoing provisions.</p>

<p><b>Modification</b></p>

<p>This agreement may be modified only by a written agreement signed by all the parties.</p>

<p><b>Waiver</b></p>

<p>If one party waives any term or provision of this agreement at any time, that waiver will only be effective for the specific instance and specific purpose for which the waiver was given. If either party fails to exercise or delays exercising any of its rights or remedies under this agreement, that party retains the right to enforce that term or provision at a later time.</p>

<p><b>Severability</b></p>

<p>If any court determines that any provision of this agreement is invalid or unenforceable, any invalidity or unenforceability will affect only that provision and will not make any other provision of this agreement invalid or unenforceable and shall be modified, amended, or limited only to the extent necessary to render it valid and enforceable.</p>
<br />
<br />
<br />
</div>
</div>
<?php require('footer.php'); ?>
