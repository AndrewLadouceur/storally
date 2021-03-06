<?php
/**
 * @Author: ananayarora
 * @Date:   2016-03-30 21:35:01
@Last modified by:   ananayarora
@Last modified time: 2016-08-22T02:52:47+05:30
 */
	$title = "Profile";
	$include = '<link rel="stylesheet" type="text/css" href="css/sweetalert.css">';
	$include .= '<link rel="stylesheet" type="text/css" href="css/profile.css">';
	$include .= '<link rel="stylesheet" type="text/css" href="css/settings.css">';
	$include .= '<script src="js/jquery.js"></script>';
	$include .= '<script src="js/profile.js"></script>';
	$include .= '<script src="js/settings.js"></script>';
	$include .= '<script src="js/sweetalert.min.js"></script>';
	session_start();
	// Include files
	if (!isset($_SESSION['logged_in'])) {
		header("Location: index.php");
	}
	require('inc/mysqli.php');
	require('inc/conf.php');
	// Init Classes
	$c = new Conf();
	$o = new MysqliDb($c->host, $c->username, $c->password, $c->db);
	// Check if the person came from facebook
	if (isset($_SESSION['fbid'])){
		// Check if he is registered
		$o->where("fbid", $_SESSION['fbid']);
		$o->get("users");
		if (!$o->count){
			// If the user is not registered, add him to the databases
			$data = Array(
				'fbid'=>$_SESSION['fbid'],
				'fullname'=>$_SESSION['fullname'],
				'email'=>$_SESSION['email'],
				'ip'=>$_SERVER['REMOTE_ADDR'],
				'regtime'=>time()
			);
			$o->insert("users", $data);
		}
	}
	require 'header.php';
	$f = new Functions();
?>
<br>
<div class="wrap">
	<center>
	<h1 class="page_title">Edit Profile</h1>
	<br />
	<br />
	</center>
	<div class="profile_links">
		<br />
		<br />
		<a href="#edit_profile" id="edit_profile" class="active_link">Edit Profile</a>
		<br />
		<br />
		<a href="#trust" id="trust">Trust &amp; Verification</a>
		<br />
		<br />
		<a href="#settings" id="settings">Settings</a>
		<br />
	</div>
	<center>
	<div class="profile edit_profile">
		<div class="box">
			<center>
				<div class="title">Change Profile Picture</div>
				<br>
				<br>
				<p>Current Picture: </p>
				<br>
				<img src="<?php echo $f->getUserImage(); ?>" style="width:300px;">
				<br>
				<br>
				<p>Size 150x150 recommended</p>
				<br />
				<form id="upload_dp" enctype="multipart/form-data" method="post">
					<input id="uploadImage" type="file" accept="image/*" name="image" />
				</form>
				<br />
				<br />
				<div class="submit_button" id="upload_dp_button">Upload</div>
				<br />
			</center>
		</div>
		<br />
		<br>
			<br>
			<div class="box">
				<div class="title">Basic Information</div>
				<div class="fields">
					<form action="main.php" method="POST" id="profile">

						<div class="field">
							<span class="label">First Name</span>
							<div class="textbox">
								<input required name="first_name" value="<?php echo $f->getField('first_name'); ?>" type="text" class="text" size="50">
							</div>
						</div>

						<div class="field">
							<span class="label">Last Name</span>
							<div class="textbox">
								<input required name="last_name" value="<?php echo $f->getField('last_name'); ?>" type="text" class="text" size="50">
							</div>
						</div>
						<div class="field">
							<span class="label">Email</span>
							<div class="textbox">
								<span class="profile_noedit_text">
									<?php echo $f->getField('email'); ?>
								</span>
							</div>
						</div>
						<br />
						<div class="field">
							<span class="label">Phone No.</span>
							<div class="textbox">
								<span class="profile_noedit_text">
									<?php echo ($f->getField('phone') == "") ? "<span class='link trust_section'>Add phone number here.</span>": $f->getField('phone'); ?>
									<?php echo ($f->getField('phone') != "" && !$f->isPhoneVerified()) ? "(<span class='link trust_section'>Needs Verification</span>)" : "" ?>
								</span>
							</div>
						</div>

						<div class="field">
							<span class="label" style="vertical-align:top;margin-top:20px;">Tell us a little bit about yourself</span>
							<div class="textbox">
								<textarea required name="description" placeholder="What do you do? Where you are from?" type="text" class="text" size="50"><?php echo $f->getField('description'); ?></textarea>
							</div>
						</div>

					</form>
				</div>
			</div>
			<br>
			<div class="box birthday">
				<div class="title">Birthday</div>
				<br />
				<br />
				<select id="month">
					<option value="">Month</option>
		      <option value="">----</option>
		      <option value="01">January</option>
		      <option value="02">February</option>
		      <option value="03">March</option>
		      <option value="04">April</option>
		      <option value="05">May</option>
		      <option value="06">June</option>
		      <option value="07">July</option>
		      <option value="08">August</option>
		      <option value="09">September</option>
		      <option value="10">October</option>
		      <option value="11">November</option>
		      <option value="12">December</option>
				</select>
				<br />
				<br />
				<select id="day">
					<option value="">Day</option>
		      <option value="">----</option>
		      <option value="1">01</option>
		      <option value="2">02</option>
		      <option value="3">03</option>
		      <option value="4">04</option>
		      <option value="5">05</option>
		      <option value="6">06</option>
		      <option value="7">07</option>
		      <option value="8">08</option>
		      <option value="9">09</option>
		      <option value="10">10</option>
		      <option value="11">11</option>
		      <option value="12">12</option>
		      <option value="13">13</option>
		      <option value="14">14</option>
		      <option value="15">15</option>
		      <option value="16">16</option>
		      <option value="17">17</option>
		      <option value="18">18</option>
		      <option value="19">19</option>
		      <option value="20">20</option>
		      <option value="21">21</option>
		      <option value="22">22</option>
		      <option value="23">23</option>
		      <option value="24">24</option>
		      <option value="25">25</option>
		      <option value="26">26</option>
		      <option value="27">27</option>
		      <option value="28">28</option>
		      <option value="29">29</option>
		      <option value="30">30</option>
		      <option value="31">31</option>
				</select>
				<br />
				<br />
				<select id="year">
					<option value="">Year</option>
      		<option value="">----</option>
		      <option value="2010">2010</option>
		      <option value="2009">2009</option>
		      <option value="2008">2008</option>
		      <option value="2007">2007</option>
		      <option value="2006">2006</option>
		      <option value="2005">2005</option>
		      <option value="2004">2004</option>
		      <option value="2003">2003</option>
		      <option value="2002">2002</option>
		      <option value="2001">2001</option>
		      <option value="2000">2000</option>
		      <option value="1999">1999</option>
		      <option value="1998">1998</option>
		      <option value="1997">1997</option>
		      <option value="1996">1996</option>
		      <option value="1995">1995</option>
		      <option value="1994">1994</option>
		      <option value="1993">1993</option>
		      <option value="1992">1992</option>
		      <option value="1991">1991</option>
		      <option value="1990">1990</option>
		      <option value="1989">1989</option>
		      <option value="1988">1988</option>
		      <option value="1987">1987</option>
		      <option value="1986">1986</option>
		      <option value="1985">1985</option>
		      <option value="1984">1984</option>
		      <option value="1983">1983</option>
		      <option value="1982">1982</option>
		      <option value="1981">1981</option>
		      <option value="1980">1980</option>
		      <option value="1979">1979</option>
		      <option value="1978">1978</option>
		      <option value="1977">1977</option>
		      <option value="1976">1976</option>
		      <option value="1975">1975</option>
		      <option value="1974">1974</option>
		      <option value="1973">1973</option>
		      <option value="1972">1972</option>
		      <option value="1971">1971</option>
		      <option value="1970">1970</option>
		      <option value="1969">1969</option>
		      <option value="1968">1968</option>
		      <option value="1967">1967</option>
		      <option value="1966">1966</option>
		      <option value="1965">1965</option>
		      <option value="1964">1964</option>
		      <option value="1963">1963</option>
		      <option value="1962">1962</option>
		      <option value="1961">1961</option>
		      <option value="1960">1960</option>
		      <option value="1959">1959</option>
		      <option value="1958">1958</option>
		      <option value="1957">1957</option>
		      <option value="1956">1956</option>
		      <option value="1955">1955</option>
		      <option value="1954">1954</option>
		      <option value="1953">1953</option>
		      <option value="1952">1952</option>
		      <option value="1951">1951</option>
		      <option value="1950">1950</option>
		      <option value="1949">1949</option>
		      <option value="1948">1948</option>
		      <option value="1947">1947</option>
		      <option value="1946">1946</option>
		      <option value="1945">1945</option>
		      <option value="1944">1944</option>
		      <option value="1943">1943</option>
		      <option value="1942">1942</option>
		      <option value="1941">1941</option>
		      <option value="1940">1940</option>
		      <option value="1939">1939</option>
		      <option value="1938">1938</option>
		      <option value="1937">1937</option>
		      <option value="1936">1936</option>
		      <option value="1935">1935</option>
		      <option value="1934">1934</option>
		      <option value="1933">1933</option>
		      <option value="1932">1932</option>
		      <option value="1931">1931</option>
		      <option value="1930">1930</option>
		      <option value="1929">1929</option>
		      <option value="1928">1928</option>
		      <option value="1927">1927</option>
		      <option value="1926">1926</option>
		      <option value="1925">1925</option>
		      <option value="1924">1924</option>
		      <option value="1923">1923</option>
		      <option value="1922">1922</option>
		      <option value="1921">1921</option>
		      <option value="1920">1920</option>
		      <option value="1919">1919</option>
		      <option value="1918">1918</option>
		      <option value="1917">1917</option>
		      <option value="1916">1916</option>
		      <option value="1915">1915</option>
		      <option value="1914">1914</option>
		      <option value="1913">1913</option>
		      <option value="1912">1912</option>
		      <option value="1911">1911</option>
		      <option value="1910">1910</option>
		      <option value="1909">1909</option>
		      <option value="1908">1908</option>
		      <option value="1907">1907</option>
		      <option value="1906">1906</option>
		      <option value="1905">1905</option>
		      <option value="1904">1904</option>
		      <option value="1903">1903</option>
		      <option value="1901">1901</option>
		      <option value="1900">1900</option>
				</select>
				<br />
				<br />
			</div>
			<br />
			<br />
			<div class="box">
				<div class="title">Additional Information</div>
				<div class="fields">
					<form>
						<div class="field">
							<span class="label">School</span>
							<div class="textbox">
								<input name="school" type="text" class="text" size="50">
							</div>
						</div>

						<div class="field">
							<span class="label">Work</span>
							<div class="textbox">
								<input name="work" type="text" class="text" size="50">
							</div>
						</div>
					</form>
				</div>
			</div>
			<br />
			<br />
			<div id="profile_submit_button" class="submit_button">Update</div>
			<br />
			<br />
		</div>
		<div class="trust">
			<div class="box">
				<div class="title">Upload Photo ID*</div>
				<br />
				<?php if (!$f->isPhotoVerified() && ($f->getField('photoid') != "") && ($f->getField('verified_photo_id') != "rejected")) {
							echo "<center><p>This Photo ID is being verified by our team. Please wait.</p></center>";
							echo "<br /><br /><img src='".$f->getField('photoid')."' class='the_photo_id' style='width:400px;'></img>";
						} else if ($f->getField('photoid') == "") {
							echo "<center><p>Please upload a Photo ID below.</p></center>";
						} else if ($f->isPhotoVerified() && ($f->getField('photoid') != "")){
							echo "<center><i class='fa fa-check' style='color:#16a085;'></i>&nbsp;&nbsp;Your Photo ID is Verified!</center>";
							echo "<br /><br /><img src='".$f->getField('photoid')."' class='the_photo_id' style='width:400px;'></img>";
						} else if (($f->getField("verified_photo_id") == "rejected") && ($f->getField('photoid') != "")){
							echo "<center><i class='fa fa-times' style='color:#c0392b;'></i>&nbsp;&nbsp;Your Photo ID was rejected. Please upload a different one!</center>";
							echo "<br /><br /><img src='".$f->getField('photoid')."' class='the_photo_id' style='width:400px;'></img>";
						}
				?>
				<form id="update_picture_form" enctype="multipart/form-data" method="post">
					<br />
					<input id="uploadImage" type="file" accept="image/*" name="image" />
					<br />
					<br />
					<div class="submit_button" id="update_picture_button">Upload</div>
					<br />
				</form>
				<br />
				<a style="color:#39c; cursor:pointer;" onclick="swal({title:'Photo ID Example',text:'Example: Student ID, Drivers license etc.',imageUrl:'https://storally.com/img/photoid.png',imageSize:'400x200',html:true});">View Examples of Photo ID</a>
				<br />
				<br />
			</div>
			<br />
			<br />
			<div class="box phone_number_box">
				<div class="title">Phone Number*</div>
				<div class="fields">
					<div class="field">
						<?php if (!$f->isPhoneVerified() && ($f->getField('phone') != "")){
							echo "<center><p>You need to verify this phone number. Click on 'Update' to start the verify process.</p></center>";
						} else if ($f->getField('phone') == "") {
							echo "<center><p>Please add a phone number below</p></center>";
						} else if ($f->isPhoneVerified() && ($f->getField('phone') != "")){
							echo "<center><i class='fa fa-check' style='color:#16a085;'></i>&nbsp;&nbsp;Your Phone Number is Verified!</center>";
						}?>
						<br />
						<br />
						<span class="label">Phone Number</span>
						<div class="textbox">
							<select name="countryCode" id="country_code_selection">
								<option data-countryCode="US" value="1" selected>US / Canada (+1)</option>
								<optgroup label="Other countries">
									<option data-countryCode="DZ" value="213">Algeria (+213)</option>
									<option data-countryCode="AD" value="376">Andorra (+376)</option>
									<option data-countryCode="AO" value="244">Angola (+244)</option>
									<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
									<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
									<option data-countryCode="AR" value="54">Argentina (+54)</option>
									<option data-countryCode="AM" value="374">Armenia (+374)</option>
									<option data-countryCode="AW" value="297">Aruba (+297)</option>
									<option data-countryCode="AU" value="61">Australia (+61)</option>
									<option data-countryCode="AT" value="43">Austria (+43)</option>
									<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
									<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
									<option data-countryCode="BH" value="973">Bahrain (+973)</option>
									<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
									<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
									<option data-countryCode="BY" value="375">Belarus (+375)</option>
									<option data-countryCode="BE" value="32">Belgium (+32)</option>
									<option data-countryCode="BZ" value="501">Belize (+501)</option>
									<option data-countryCode="BJ" value="229">Benin (+229)</option>
									<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
									<option data-countryCode="BT" value="975">Bhutan (+975)</option>
									<option data-countryCode="BO" value="591">Bolivia (+591)</option>
									<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
									<option data-countryCode="BW" value="267">Botswana (+267)</option>
									<option data-countryCode="BR" value="55">Brazil (+55)</option>
									<option data-countryCode="BN" value="673">Brunei (+673)</option>
									<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
									<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
									<option data-countryCode="BI" value="257">Burundi (+257)</option>
									<option data-countryCode="KH" value="855">Cambodia (+855)</option>
									<option data-countryCode="CM" value="237">Cameroon (+237)</option>
									<!-- <option data-countryCode="CA" value="1">Canada (+1)</option> -->
									<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
									<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
									<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
									<option data-countryCode="CL" value="56">Chile (+56)</option>
									<option data-countryCode="CN" value="86">China (+86)</option>
									<option data-countryCode="CO" value="57">Colombia (+57)</option>
									<option data-countryCode="KM" value="269">Comoros (+269)</option>
									<option data-countryCode="CG" value="242">Congo (+242)</option>
									<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
									<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
									<option data-countryCode="HR" value="385">Croatia (+385)</option>
									<option data-countryCode="CU" value="53">Cuba (+53)</option>
									<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
									<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
									<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
									<option data-countryCode="DK" value="45">Denmark (+45)</option>
									<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
									<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
									<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
									<option data-countryCode="EC" value="593">Ecuador (+593)</option>
									<option data-countryCode="EG" value="20">Egypt (+20)</option>
									<option data-countryCode="SV" value="503">El Salvador (+503)</option>
									<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
									<option data-countryCode="ER" value="291">Eritrea (+291)</option>
									<option data-countryCode="EE" value="372">Estonia (+372)</option>
									<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
									<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
									<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
									<option data-countryCode="FJ" value="679">Fiji (+679)</option>
									<option data-countryCode="FI" value="358">Finland (+358)</option>
									<option data-countryCode="FR" value="33">France (+33)</option>
									<option data-countryCode="GF" value="594">French Guiana (+594)</option>
									<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
									<option data-countryCode="GA" value="241">Gabon (+241)</option>
									<option data-countryCode="GM" value="220">Gambia (+220)</option>
									<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
									<option data-countryCode="DE" value="49">Germany (+49)</option>
									<option data-countryCode="GH" value="233">Ghana (+233)</option>
									<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
									<option data-countryCode="GR" value="30">Greece (+30)</option>
									<option data-countryCode="GL" value="299">Greenland (+299)</option>
									<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
									<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
									<option data-countryCode="GU" value="671">Guam (+671)</option>
									<option data-countryCode="GT" value="502">Guatemala (+502)</option>
									<option data-countryCode="GN" value="224">Guinea (+224)</option>
									<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
									<option data-countryCode="GY" value="592">Guyana (+592)</option>
									<option data-countryCode="HT" value="509">Haiti (+509)</option>
									<option data-countryCode="HN" value="504">Honduras (+504)</option>
									<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
									<option data-countryCode="HU" value="36">Hungary (+36)</option>
									<option data-countryCode="IS" value="354">Iceland (+354)</option>
									<option data-countryCode="IN" value="91">India (+91)</option>
									<option data-countryCode="ID" value="62">Indonesia (+62)</option>
									<option data-countryCode="IR" value="98">Iran (+98)</option>
									<option data-countryCode="IQ" value="964">Iraq (+964)</option>
									<option data-countryCode="IE" value="353">Ireland (+353)</option>
									<option data-countryCode="IL" value="972">Israel (+972)</option>
									<option data-countryCode="IT" value="39">Italy (+39)</option>
									<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
									<option data-countryCode="JP" value="81">Japan (+81)</option>
									<option data-countryCode="JO" value="962">Jordan (+962)</option>
									<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
									<option data-countryCode="KE" value="254">Kenya (+254)</option>
									<option data-countryCode="KI" value="686">Kiribati (+686)</option>
									<option data-countryCode="KP" value="850">Korea North (+850)</option>
									<option data-countryCode="KR" value="82">Korea South (+82)</option>
									<option data-countryCode="KW" value="965">Kuwait (+965)</option>
									<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
									<option data-countryCode="LA" value="856">Laos (+856)</option>
									<option data-countryCode="LV" value="371">Latvia (+371)</option>
									<option data-countryCode="LB" value="961">Lebanon (+961)</option>
									<option data-countryCode="LS" value="266">Lesotho (+266)</option>
									<option data-countryCode="LR" value="231">Liberia (+231)</option>
									<option data-countryCode="LY" value="218">Libya (+218)</option>
									<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
									<option data-countryCode="LT" value="370">Lithuania (+370)</option>
									<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
									<option data-countryCode="MO" value="853">Macao (+853)</option>
									<option data-countryCode="MK" value="389">Macedonia (+389)</option>
									<option data-countryCode="MG" value="261">Madagascar (+261)</option>
									<option data-countryCode="MW" value="265">Malawi (+265)</option>
									<option data-countryCode="MY" value="60">Malaysia (+60)</option>
									<option data-countryCode="MV" value="960">Maldives (+960)</option>
									<option data-countryCode="ML" value="223">Mali (+223)</option>
									<option data-countryCode="MT" value="356">Malta (+356)</option>
									<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
									<option data-countryCode="MQ" value="596">Martinique (+596)</option>
									<option data-countryCode="MR" value="222">Mauritania (+222)</option>
									<option data-countryCode="YT" value="269">Mayotte (+269)</option>
									<option data-countryCode="MX" value="52">Mexico (+52)</option>
									<option data-countryCode="FM" value="691">Micronesia (+691)</option>
									<option data-countryCode="MD" value="373">Moldova (+373)</option>
									<option data-countryCode="MC" value="377">Monaco (+377)</option>
									<option data-countryCode="MN" value="976">Mongolia (+976)</option>
									<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
									<option data-countryCode="MA" value="212">Morocco (+212)</option>
									<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
									<option data-countryCode="MN" value="95">Myanmar (+95)</option>
									<option data-countryCode="NA" value="264">Namibia (+264)</option>
									<option data-countryCode="NR" value="674">Nauru (+674)</option>
									<option data-countryCode="NP" value="977">Nepal (+977)</option>
									<option data-countryCode="NL" value="31">Netherlands (+31)</option>
									<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
									<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
									<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
									<option data-countryCode="NE" value="227">Niger (+227)</option>
									<option data-countryCode="NG" value="234">Nigeria (+234)</option>
									<option data-countryCode="NU" value="683">Niue (+683)</option>
									<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
									<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
									<option data-countryCode="NO" value="47">Norway (+47)</option>
									<option data-countryCode="OM" value="968">Oman (+968)</option>
									<option data-countryCode="PW" value="680">Palau (+680)</option>
									<option data-countryCode="PA" value="507">Panama (+507)</option>
									<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
									<option data-countryCode="PY" value="595">Paraguay (+595)</option>
									<option data-countryCode="PE" value="51">Peru (+51)</option>
									<option data-countryCode="PH" value="63">Philippines (+63)</option>
									<option data-countryCode="PL" value="48">Poland (+48)</option>
									<option data-countryCode="PT" value="351">Portugal (+351)</option>
									<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
									<option data-countryCode="QA" value="974">Qatar (+974)</option>
									<option data-countryCode="RE" value="262">Reunion (+262)</option>
									<option data-countryCode="RO" value="40">Romania (+40)</option>
									<option data-countryCode="RU" value="7">Russia (+7)</option>
									<option data-countryCode="RW" value="250">Rwanda (+250)</option>
									<option data-countryCode="SM" value="378">San Marino (+378)</option>
									<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
									<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
									<option data-countryCode="SN" value="221">Senegal (+221)</option>
									<option data-countryCode="CS" value="381">Serbia (+381)</option>
									<option data-countryCode="SC" value="248">Seychelles (+248)</option>
									<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
									<option data-countryCode="SG" value="65">Singapore (+65)</option>
									<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
									<option data-countryCode="SI" value="386">Slovenia (+386)</option>
									<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
									<option data-countryCode="SO" value="252">Somalia (+252)</option>
									<option data-countryCode="ZA" value="27">South Africa (+27)</option>
									<option data-countryCode="ES" value="34">Spain (+34)</option>
									<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
									<option data-countryCode="SH" value="290">St. Helena (+290)</option>
									<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
									<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
									<option data-countryCode="SD" value="249">Sudan (+249)</option>
									<option data-countryCode="SR" value="597">Suriname (+597)</option>
									<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
									<option data-countryCode="SE" value="46">Sweden (+46)</option>
									<option data-countryCode="CH" value="41">Switzerland (+41)</option>
									<option data-countryCode="SI" value="963">Syria (+963)</option>
									<option data-countryCode="TW" value="886">Taiwan (+886)</option>
									<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
									<option data-countryCode="TH" value="66">Thailand (+66)</option>
									<option data-countryCode="TG" value="228">Togo (+228)</option>
									<option data-countryCode="TO" value="676">Tonga (+676)</option>
									<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
									<option data-countryCode="TN" value="216">Tunisia (+216)</option>
									<option data-countryCode="TR" value="90">Turkey (+90)</option>
									<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
									<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
									<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
									<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
									<option data-countryCode="UG" value="256">Uganda (+256)</option>
									<option data-countryCode="GB" value="44">UK (+44)</option>
									<option data-countryCode="UA" value="380">Ukraine (+380)</option>
									<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
									<option data-countryCode="UY" value="598">Uruguay (+598)</option>
									<!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
									<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
									<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
									<option data-countryCode="VA" value="379">Vatican City (+379)</option>
									<option data-countryCode="VE" value="58">Venezuela (+58)</option>
									<option data-countryCode="VN" value="84">Vietnam (+84)</option>
									<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
									<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
									<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
									<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
									<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
									<option data-countryCode="ZM" value="260">Zambia (+260)</option>
									<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
								</optgroup>
							</select>
							<input required value="<?php echo $f->getField('phone'); ?>" id="phone_number_field" name="phone_number" type="text" class="text" size="50">
						</div>
						<br />
						<br />
						<div class="submit_button" id="update_phone_number">Update</div>
					</div>
				</div>
			</div>
			<br />
			<br />
			<?php

			/*
			<div class="box address_validation">
				<div class="title">Address</div>
				<div class="fields">
					<div class="field">
						<div class="textbox">
							<input name="address" id="street_address" type="text" value="<?php echo $f->getField('address'); ?>" style="width:300px" class="text" placeholder="Full Street Address"/>
						</div>
					</div>
				</div>
				<br />
				<div class="submit_button" id="update_address">Update</div>
				<br />
				<br />
			</div>
			*/
			
			?>
			<br />
			<br />
			<br />
		</div>
		<div class="settings">
			<?php if (isset($_SESSION['fbid'])) { ?>
			<div class="box">
				<div class="title">Change Password</div>
				<div class="fields">
					<p align="left">Since you've logged in through a Facebook account, you cannot change your password.</p>
				</div>
			</div>
			<?php } else { ?>
			<div class="box">
				<div class="title">Change Password</div>
				<div class="fields">
					<form id="password_change_form">
						<div class="field">
							<span class="label">Current Password</span>
							<div class="textbox">
								<input required name="currentpass" type="password" class="text" size="50">
							</div>
						</div>
						<div class="field">
							<span class="label">New Password</span>
							<div class="textbox">
								<input required name="newpass" type="password" class="text" size="50">
							</div>
						</div>
						<div class="field">
							<span class="label">Confirm New Password</span>
							<div class="textbox">
								<input required name="confirmnewpass" type="password" class="text" size="50">
							</div>
						</div>
					</form>
					<br>
					<br>
					<div class="submit_button" id="update_password">Update</div>
				</div>
				<br />
				<br />
			</div>
			<?php } ?>
		</div>
	</center>
</div>
