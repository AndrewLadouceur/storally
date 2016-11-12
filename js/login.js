/*
* @Author: ananayarora
* @Date:   2016-03-30 20:49:38
* @Last modified by:   ananayarora
* @Last modified time: 2016-08-23T01:57:02+05:30
*/

$(document).ready(function(){

	// Animations

	$(".header_").animate({
		'opacity':1
	}, function(){
		$(".facebook_login_button").animate({
			'opacity':1
		}, function(){
			$("#the_login_form").animate({
				'opacity':1
			});
		});
	});

	// Submit form button


	$("input").keydown(function(e){
		if (e.keyCode == 13)
		{
			var $email = $("#email").val();
			var $password = $('#password').val();
			if ($email == "" || $password == "")
			{
				swal("Error","Username and Password cannot be blank!","error");
			} else {
				$data = {'email':$email,'password':$password};
				$.post('login_process.php', $data, function(r){
					console.log(r);
					if (r == "true")
					{
						window.location.href="main.php";
					} else {
						swal("Oops!","Invalid Username / Password Combination","error");
					}
				});
			}
		}
	});

	$(".submit_button").click(function(){
		var $email = $("#email").val();
		var $password = $('#password').val();
		if ($email == "" || $password == "")
		{
			swal("Error","Username and Password cannot be blank!","error");
		} else {
			$data = {'email':$email,'password':$password};
			$.post('login_process.php', $data, function(r){
				console.log(r);
				if (r == "true")
				{
					window.location.href="main.php";
				} else if (r == "false") {
					swal("Oops!","Invalid Username / Password Combination","error");
				} else if (r == "verifyemail") {
					swal("Error","Please verify your email before continuing","error");
				}
			});
		}
	});
});
