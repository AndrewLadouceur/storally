/*
* @Author: ananayarora
* @Date:   2016-04-20 05:56:03
* @Last modified by:   ananayarora
* @Last modified time: 2016-08-21T04:31:44+05:30
*/

$(document).ready(function(){

	// Tabs on the left
	$(window).scrollTop(0);
	var pages = $(".edit_profile, .trust, .settings");

	if (location.hash == "") {
		location.hash = "edit_profile";
	}

	if (location.hash != "")
	{
			var loc = location.hash;
			$(".active_link").removeClass("active_link");
			$(loc).addClass("active_link");
			$(".page_title").text($(loc).text());
			loc = loc.replace("#",".");
			pages.hide();
			$(loc).fadeIn();
			$(window).scrollTop(0);
	}

	$(".trust_section").click(function(){
		pages.hide();
		$(".trust").fadeIn();
		location.hash = "#trust";
		$(".active_link").removeClass("active_link");
		$("#trust").addClass("active_link");
		$(window).scrollTop(0);
	});

	$("#profile_submit_button").click(function(){
		var data = $("form#profile").serialize();
    var month = $("#month").val();
		var day = $("#day").val();
		var year = $("#year").val();
		if (month == "" || day == "" || year == "") {
			swal("Error", "You must fill out your birth date correctly.","error");
		} else {
			var birthday_data = "month="+month+"&day="+day+"&year="+year;
			$.post("api/birthday.php", birthday_data, function(r){
        $.post('update_profile.php', data, function(r){
  			  swal({
						title:"Success!",
						text: "Your profile has been updated.",
						type: "success"
					}, function(){
						window.location.reload();
					});
  		  });
			});
    }
	});

	$("#update_address").click(function(){
		var address = $("#street_address").val();
		if (address == "") {
			swal("Error!","Please enter an address","error");
		} else {
			var data = "address="+encodeURI(address);
			$.post('api/update_address.php', data, function(r){
				if (r == "success") {
					swal({
						title:"Success!",
						text:"Your address has been verified.",
						type:"success"
					}, function(){
						window.location.reload();
					});
				} else {
					// swal("Error",r,"error");
					swal("Error","Your address is invalid. Please make sure you're entering a valid address","error");
				}
			});
		}
	});

	$(".profile_links a").click(function(){
		$(".active_link").removeClass("active_link");
		$(this).addClass("active_link");
		$(".page_title").text($(this).text());
		$(window).scrollTop(0);
	});

	$("#edit_profile").click(function(){
		pages.hide();
		$(".profile").fadeIn();
		location.hash = "#profile";
	});

	$("#trust").click(function(){
		pages.hide();
		$(".trust").fadeIn();
		location.hash = "#trust";
	});

	$("#settings").click(function(){
		pages.hide();
		$(".settings").fadeIn();
		location.hash = "#settings";
	});



	// Fetch Birthday

	$.get("api/fetch_birthday.php", function(r){
		var birthday_array = $.parseJSON(r);
		$("#day option[value='"+birthday_array['day']+"']").prop('selected','selected');
		$("#year option[value='"+birthday_array['year']+"']").prop('selected','selected');
		$("#month option[value='"+birthday_array['month']+"']").prop('selected','selected');
	});


});
