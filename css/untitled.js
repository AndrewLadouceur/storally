if (!($.trim(fname).length == 0) && !($.trim(lname).length == 0) && !($.trim(phoneval).length == 0 || vphone==false) && !($.trim(pcode).length == 0 || vcode == false) && !($.trim(address).length == 0)) {






$("#msform").submit(function(){

var fname=jQuery('#fname').val();
if ($.trim(fname).length == 0) {
document.getElementById("fname").style.borderColor = "#E34234";
jQuery('.fs-error').html('<span style="color:red;"> Please Enter First Name !</span>');
jQuery('.fs-error').show();
return false;
}
else{
jQuery('.fs-error').hide();
 var serializedReturn = formData();

window.location = "http://localhost/multistepform/success.php";
 return false;

 }
});


&nbsp;

function formData() {
 var serializedValues = jQuery("#msform").serialize();
 var form_data = {
 action: 'ajax_data',
 type: 'post',
 data: serializedValues,
 };
 jQuery.post('insert.php', form_data, function(response) {
 alert(response);
 // document.getElementById("sucess").style.color = "#006600";
 // jQuery('#sucess').show();
 });

 return serializedValues;
}
function formValidation(e){

var emailval=jQuery('#email').val();
 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
// Checking Empty Fields
var vemail=mailformat.test(emailval)
if ($.trim(emailval).length == 0 || vemail==false) {
jQuery('.fs-error').html('<span style="color:red;"> Email is invalid !</span>');
return false;
}
else{

jQuery('.fs-error').hide();
}
 var pass1 = document.getElementById("pass").value;
 var pass2 = document.getElementById("cpass").value;

 if (pass1 != pass2 || pass1 == '') {
 //alert("Passwords Do not match");
 document.getElementById("pass").style.borderColor = "#E34234";
 document.getElementById("cpass").style.borderColor = "#E34234";
 jQuery('.fs-error').html('<span style="color:red;"> Passords do not match !</span>');
 jQuery('.fs-error').show();
 return false
 }
 else {
 document.getElementById("pass").style.borderColor = "#006600";
 document.getElementById("cpass").style.borderColor = "#006600";
 jQuery('.fs-error').hide();
 return true;
 }
}
