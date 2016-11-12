/*
* @Author: ananayarora
* @Date:   2016-04-30 04:23:00
* @Last modified by:   ananayarora
* @Last modified time: 2016-08-26T07:47:09+05:30
*/
// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

$(document).ready(function(){

	// Update the country_code select field
	var country_code;
	$.get("api/country_code.php", function(r){
			if (r == "")
			{
				country_code = '1';
			} else {
				country_code = r;
			}
			$("#country_code_selection option[value='"+country_code+"']").prop('selected','selected');
			console.log(r);
	});


	$("#update_password").click(function(){
		var data = $("#password_change_form").serialize();
		$.post('api/password_change.php',data,function(r){
			console.log(r);
			if (r == "sameasold")
			{
				swal("Oops!", "The password you entered is the same as current.", "error");
			} else if (r == "oldwrong") {
				swal("Oops!", "The current password you entered is wrong.", "error");
			} else if (r == "newnomatch") {
				swal("Oops!", "The new password & the confirm new password fields don't match", "error");
			} else if (r == "empty") {
				swal("Oops!", "You didn't fill out all required fields", "error");
			} else if (r == "success") {
				$("input[type='password']").val("");
				swal("Updated!", "Your password has been changed!", "success");
			}
		});
	});
	$("#update_phone_number").click(function(){
		var data = 'country_code='+Base64.encode($("#country_code_selection").val())+'&phone_number='+Base64.encode($("#phone_number_field").val());
		$.post('api/phone_number_update.php', data, function(r){
			console.log(r);
			swal({
				title:"Verification Required",
				text: "Please check your device's SMS inbox for the verification code and enter it here.",
				type: "input",
				html: true
			}, function(inputData){
				var data = "verification_code="+inputData;
				$.post('api/phone_number_verify.php', data, function(r){
					if (r == "success") {
						swal({
							title:"Success",
							text: "Your number is now verified with Storally. You can now register as an ally!",
							type: "success"
						}, function(){
							window.location.href="profile.php#trust";
						});
					} else {
						swal({
							title:"Error",
							text: r,
							type: "error"
						}, function(){
							window.location.href="profile.php#trust";
						});
					}
				});
			});
		});
	});
	$("#upload_dp_button").on('click',function(){
		var formData = new FormData($("#upload_dp")[0]);
		swal("Uploading Profile Picture","Please wait while your new Profile Picture is uploaded","info");
		$.ajax({
			url:'api/update_dp.php',
			type: 'POST',
			contentType: false,
			data: formData,
         	cache: false,
   			processData:false,
   			success: function(data)
   			{
   				if (data == "success")
   				{
						swal({
							title: "Success!",
							text: "Your profile picture has been uploaded successfully.",
							type: "success"
							}, function(){
   						window.location.reload();
   					});
   				} else {
						swal({
							title: "Error",
							text: "An error occurred while uploading your picture",
							type: "error"
							}, function(){
							window.location.reload();
						});
   				}
   			}
		});
	});
	$("#update_picture_button").on('click',function(){
		var formData = new FormData($("#update_picture_form")[0]);
		swal({
			title:"Uploading Photo ID",
			text: "Please wait while your photo id is uploaded..",
			type: "info",
			showConfirmButton: false
		});
		$.ajax({
			url: "api/update_picture.php",
			type: 'POST',
			contentType: false,
			data: formData,
         	cache: false,
   			processData:false,
   			success: function(data)
   			{
   				if (data == "")
   				{
   					swal({
							title: "Success!",
							text: "Your Photo ID has been uploaded and is pending verification",
							type: "success"
							}, function(){
   							window.location.reload();
   					});
   				} else {
						swal({
							title: "Error",
							text: "An error has occurred, please try again later.",
							type: "error"
							}, function(){
   						window.location.href="profile.php#trust";
   					});
   				}
   			}
		});
	});
});
