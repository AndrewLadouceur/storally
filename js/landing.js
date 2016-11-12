/*
* @Author: ananayarora
* @Date:   2016-04-15 01:29:33
* @Last modified by:   ananayarora
* @Last modified time: 2016-08-21T05:00:07+05:30
*/

$(document).ready(function(){
	$(".welcome").delay(300).animate({
		'opacity':1
	});

	$(".menu").delay(500).animate({
		'opacity':1
	});

	var quotes = ['Being an ally was a friendly interaction, with great willingness and disposal from Storally.','Storally makes storage very easy and cheap','I stored all my stuff over the summer for $60. Storally is amazing!'];

	var quote_authors = ['Sebastian Gutierrez','Anna Robertson','Brian Nelson'];
	var quoteLoop = -1;
	setInterval(function(){
			if (quoteLoop == 2) {
				quoteLoop = -1;
			}
			$(".quote").fadeOut(function(){
				$(this).html("&ldquo;"+quotes[quoteLoop]+"&rsquo;").fadeIn();
			});
			$(".quote_author").fadeOut(function(){
				$(this).html(" - "+quote_authors[quoteLoop]).fadeIn();
			});
			console.log(quoteLoop);
			quoteLoop++;
	}, 3000);


	$(".logo").delay(700).animate({
		'opacity':1
	}, function(){
		$(".logo").animate({
			'left':'25%'
		}, 500, function(){
			$(".divider").animate({
					'height':'300px'
			});
			$(".slogan").animate({
				'opacity':1
			});
		});
	});
	$(".block").delay(900).animate({
		'opacity':1
	});
	$("#about_menu").click(function(){
		$("body,html").stop(0).animate({
			scrollTop: $(".about_page").offset().top
		});
	});
	$("#works_menu").click(function(){
		$("body,html").stop(0).animate({
			scrollTop: $(".works").offset().top
		});
	});
	$("#signup_menu").click(function(){
		$("body,html").stop(0).animate({
			scrollTop: $(".sign_up").offset().top
		});
	});
	$(".works .btn").click(function(){
		$("body,html").stop(0).animate({
			scrollTop: $(".sign_up").offset().top
		});
	});
	$(".search_button").click(function(){
		var search_bar = $(".search_bar_home").val();
		window.location.href="search.php?address="+search_bar+"&lat="+$("#us2-lat").val()+"&lon="+$("#us2-lon").val();
	});
	$(".beta_button").click(function(){
		if ($(".beta_home").val() !== "")
		{
			var data = "email="+$(".beta_home").val();
			$.post('../api/beta.php', data, function(r)
			{
				if (r == "success")
				{
					swal("Thanks!","You have been added to the beta list.", "success");
				} else if (r == "already") {
					swal("Info","You're already in the beta list!","info");
				} else {
					swal("Error",r,"error");
				}
			});
		} else {
			swal("Error!","Please enter your email.","error");
		}
	});
	function setPos(pos)
	{
		var lat = pos.coords.latitude;
		var lon = pos.coords.longitude;

		$('#us2').locationpicker({
			location: {latitude: lat, longitude: lon},
			radius: 300,
			inputBinding: {
		        latitudeInput: $('#us2-lat'),
		        longitudeInput: $('#us2-lon'),
		        locationNameInput: $('.search_bar_home')
		    },
		    enableAutocomplete: true
		});
	}
	function locError(error)
	{
		if (error.code == 1)
		{
			swal("Error!", "Please allow storally to know your location.", "error");
		}
		console.log(error);
	}
	if (navigator.geolocation) {
       	navigator.geolocation.watchPosition(setPos, locError);
	}
});
