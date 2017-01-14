
jQuery('#sucess').hide();
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });


$(".next").click(function(event){  //next OPEN
	var fv=formValidation(event);
	if(fv){
	}else{
	return false;
	}

	if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({'transform': 'scale('+scale+')'});
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 800, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
}); //next CLOSE

$(".previous").click(function(){ //previous OPEN
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
}); //previous CLOSE

$("#msform").submit(function(){ //#ms SUBMIT OPEN
	//first name present?=======
	var fname=jQuery('#fname').val();
	var lname=jQuery('#lname').val();

	if ($.trim(fname).length == 0) {
	document.getElementById("fname").style.borderColor = "#E34234";
	jQuery('.fs-error').html('<span style="color:red;"> Please Enter First Name !</span>');
	jQuery('.fs-error').show();
	return false;
	}

	else{
	document.getElementById("fname").style.borderColor = "#006600";
	jQuery('.fs-error').hide();
	}
	if ($.trim(lname).length == 0) {
	document.getElementById("lname").style.borderColor = "#E34234";
	jQuery('.fs-error').html('<span style="color:red;"> Please Enter Last Name !</span>');
	jQuery('.fs-error').show();
	return false;
	}
	else{
	document.getElementById("lname").style.borderColor = "#006600";
	jQuery('.fs-error').hide();
	}

	//=========phone verification=============
	var phoneval = jQuery('#phone').val();

	var phoneformat = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;

	var vphone = phoneformat.test(phoneval);

	if ($.trim(phoneval).length == 0 || vphone == false) {
	document.getElementById("phone").style.borderColor = "#E34234";
	jQuery('.fs-error').html('<span style="color:red;"> Phone is invalid !</span>');
	jQuery('.fs-error').show();
	return false;
	}
	else{
	document.getElementById("phone").style.borderColor = "#006600";
	jQuery('.fs-error').hide();
	}

	//=========postal code verification=============
	var pcode=jQuery('#pcode').val();

	var pcodeformat = /[A-Z][0-9][A-Z]\s[0-9][A-Z][0-9]/;

	var vcode = pcodeformat.test(pcode);

	if ($.trim(pcode).length == 0 || vcode == false) {
	document.getElementById("pcode").style.borderColor = "#E34234";
	jQuery('.fs-error').html('<span style="color:red;"> Postal code is invalid !</span>');
	jQuery('.fs-error').show();
	return false;
	}
	else{
	document.getElementById("pcode").style.borderColor = "#006600";
	jQuery('.fs-error').hide();
	}

	// Address entry
	var address = jQuery('#address').val();

	if ($.trim(address).length == 0) {
		document.getElementById("address").style.borderColor = "#E34234";
		jQuery('.fs-error').html('<span style="color:red;"> Please Enter Your Address !</span>');
		jQuery('.fs-error').show();
		return false;
	}
	else{
		document.getElementById("address").style.borderColor = "#006600";
		jQuery('.fs-error').hide();
	}

	// submit

		if (!($.trim(fname).length == 0) && !($.trim(lname).length == 0) && !($.trim(phoneval).length == 0 || vphone==false) && !($.trim(address).length == 0) && !($.trim(pcode).length == 0 || vcode == false)){

		var data = $("#msform").serialize();
		if ($("#pass").val() == $("#cpass").val()){ // if 2
		console.log("Calling");
		$.post('new_signup/signup_process_normal_new.php', data, function(r){
			console.log(r);
			console.log("in post");
			if (r == "inuse") { //if 3
				console.log("inuse");
				swal("Error","The email you entered is used", "error");
				$("#msform")[0].reset();
			} else if (r == "success") {
				console.log("success");
				swal({
					title:"Success!",
					
					text: "Thank you for signing up! Please check your email for a confirmation. <br /><br /> After confirming, you may <a style='color:#39c;text-decoration:none;' href='signin.php'>Sign In</a>",
					type: "success",
					html:true
				}, function(){
					window.location.href='index.php';
				}); //swal close
				$("#msform")[0].reset();
			} else {
				console.log("else");
			} //else close 3
		}); //post function close
		
console.log("after first if");
//old code
			// var serializedReturn = formData();
			// window.location = "new_signup/success.html";
			// return false;
	}	//if statement close	
} //sss

});



$("#storee").click(function(){ //storee OPEN
		document.getElementById("storee").style.borderColor = "#006600";
		document.getElementById("ally").style.borderColor = "red";
		document.getElementById("storee").style.backgroundColor = "#11866F";
		document.getElementById("ally").style.backgroundColor = "#16a085";
}); //storee CLOSE

$("#ally").click(function(){ //storee OPEN
	document.getElementById("storee").style.borderColor = 'red';
	document.getElementById("ally").style.borderColor = '#006600';
	document.getElementById("storee").style.backgroundColor = '#16a085';
	document.getElementById("ally").style.backgroundColor = '#11866F';
}); //storee CLOSE


function formData() { //form data open


var data = $("#msform").serialize();
	console.log("Calling");
	$.post('signup_process_normal_new.php', data, function(r){
		console.log(r);
		if (r == "inuse") {
			swal("Error","The email you entered is used", "error");
			$("#msform")[0].reset();
		} else if (r == "success") {
			swal({
				title:"Success!",
				text: "Thank you for signing up! Please check your email for a confirmation. <br /><br /> After confirming, you may <a style='color:#39c;text-decoration:none;' href='signin.php'>Sign In</a>",
				type: "success",
				html:true
			}, function(){
				window.location.href='index.php';
			});
			$("#msform")[0].reset();
		}
	});
}
		




//     var serializedValues = jQuery("#msform").serialize();
//   //  serializedValues.push({'ally',var_ally});
// 		var form_data = {
//             action: 'ajax_data',
//             type: 'post',
//             data: serializedValues,
//         };
//    jQuery.post('new_signup/insert.php', form_data, function(response) {
// 		alert(response);
// 		// document.getElementById("sucess").style.color = "#006600";
// 		// jQuery('#sucess').show();
//     });
	
//     return serializedValues;
// } 	//formData close



function formValidation(e){ //formValidation open
//email check=====
	var emailval=jQuery('#email').val();
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
// Checking Empty Fields
	var vemail=mailformat.test(emailval)
	if ($.trim(emailval).length == 0 || vemail==false) {
		document.getElementById("email").style.borderColor = "#E34234";
		jQuery('.fs-error').html('<span style="color:red;"> Email is invalid !</span>');
		return false;
	}
	else{
		document.getElementById("email").style.borderColor = "#006600";
		jQuery('.fs-error').hide();
	}

	var pass1 = document.getElementById("pass").value;
    var pass2 = document.getElementById("cpass").value;
	
    if (pass1 != pass2 || pass1 == '') {
        //alert("Passwords Do not match");
        document.getElementById("pass").style.borderColor = "#E34234";
        document.getElementById("cpass").style.borderColor = "#E34234";
		jQuery('.fs-error').html('<span style="color:red;"> Passwords do not match !</span>');
		jQuery('.fs-error').show();
        return false;
    }
    else {
    	document.getElementById("pass").style.borderColor = "#006600";
        document.getElementById("cpass").style.borderColor = "#006600";
		jQuery('.fs-error').hide();
		return true;
    }
	
}	//formValidation close

});

