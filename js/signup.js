/*
* @Author: ananayarora
* @Date:   2016-04-20 21:04:15
* @Last modified by:   ananayarora
* @Last modified time: 2016-08-22T01:34:04+05:30
*/

$(document).ready(function(){
	$(".submit_button").click(function(){
				var error = 0;
				$(".text").each(function(){
					if ($(this).val() == "")
					{
						swal("Error","You didn't fill out all the information","error");
						error = 1;
					}
				});
				if (error == 0) {
					var data = $("#signup_form").serialize();
					if ($("#pass").val() == $("#confirmpass").val()){
						console.log("Calling");
						$.post('signup_process_normal.php', data, function(r){
							console.log(r);
							if (r == "inuse") {
								swal("Error","The email you entered is used", "error");
								$("#signup_form")[0].reset();
							} else if (r == "success") {
								swal({
									title:"Success!",
									text: "Thank you for signing up! Please check your email for a confirmation. <br /><br /> After confirming, you may <a style='color:#39c;text-decoration:none;' href='signin.php'>Sign In</a>",
									type: "success",
									html:true
								}, function(){
									window.location.href='index.php';
								});
								$("#signup_form")[0].reset();
							}
						});
					}
				} else {
					swal("Error","Passwords don't match","error");
				}
		});
	$("input").keydown(function(e){
		if (e.keyCode == 13)
		{
		// 	$("input").each(function(){
		// 	if ($(this).val() == "")
		// 	{
		// 		swal("Error","You didn't fill out all the information","error");
		// 	} else {
		//
		//
		// 		var data = $("#signup_form").serialize();
		// if ($("#pass").val() == $("#confirmpass").val()){
		// 	$.post('signup_process_normal.php', data, function(r){
		// 		if (r == "inuse")
		// 		{
		// 			swal("Error","The email you entered is used", "error");
		// 			$("#signup_form")[0].reset();
		// 		} else if (r == "success")
		// 		{
		// 			swal({
		// 				title:"Success!",
		// 				text: "Thank you for signing up! Please check your email for a confirmation. <br /><br /> After confirming, you may <a style='color:#39c;text-decoration:none;' href='signin.php'>Sign In</a>",
		// 				type: "success",
		// 				html:true
		// 			}, function(){
		// 				window.location.href='index.php';
		// 			});
		// 			$("#signup_form")[0].reset();
		// 			// $(".box").fadeOut(function(){
		// 				// $(this).html("Thank you for signing up! Please check your email for a confirmation. <br /> After confirming, you may <a href='signin.php'>Sign In</a>").fadeIn();
		// 			// });
		// 		}
		// 	});
		// } else {
		// 	swal("Error","Passwords don't match","error");
		// }
		//
		//
		// 	}
		// });
			$(".submit_button").trigger('click');
		}
	});
});
