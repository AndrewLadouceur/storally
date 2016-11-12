/*
* @Author: ananayarora
* @Date:   2016-04-27 01:47:47
* @Last Modified by:   ananayarora
* @Last Modified time: 2016-07-19 02:05:59
*/
var pickupType;
$(document).ready(function(){
	// Get the ally info from the server
	$.get("api/ally/ally_info.php?field=pickupType", function(r){
		if (r !== "false"){
			$(".selected").removeClass('selected');
			$("#option_"+r.toLowerCase()).addClass('selected');
			console.log(r);
		}
	});
	$.get("api/ally/ally_info.php?field=description", function(r){
		if (r !== "false"){
			$(".description textarea").html(r);
		}
	});
	$.get("api/ally/ally_info.php?field=price", function(r){
		if (r !== "false"){
			$(".price .text").val(r);
		}
	});
	$.get("api/ally/ally_info.php?field=address", function(r){
		if (r !== "false"){
			$("#us2-address").val(r);
		}
	});
	
	$.get("api/ally/ally_info.php?field=phone", function(r){
		if (r !== "false"){
			$(".phone").val(r);
		}
	});
	$(".price .weekly").change(function(){
		$(".price .monthly").val($(".price .weekly").val() * 4);
	});

	function updatePickupType()
	{
		pickupType = ($("#select_pickup_type .selected").text() == undefined) ? "Yes" : $("#select_pickup_type .selected").text();
	}

	updatePickupType();
	$(".pickup_type_option").click(function(){
		$(".selected").removeClass('selected');
		$(this).addClass('selected');
		updatePickupType();
	});

	function setPos2(lat, lon)
	{
		console.log('called');
		$('#us2').locationpicker({
			location: {latitude: lat, longitude: lon},
			radius: 300,
			inputBinding: {
		        latitudeInput: $('#us2-lat'),
		        longitudeInput: $('#us2-lon'),
		        locationNameInput: $('#us2-address')
		    },
		    enableAutocomplete: true
		});
	}

	function setPos3(pos)
	{
		var lat = pos.coords.latitude;
		var lon = pos.coords.longitude;
		$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+","+lon, function(r){
			$("#us2-address").val(r.results[0].formatted_address);
		});
    	
	    $("#us2-lat").val(lat);
	    $("#us2-lon").val(lon);
		$('#us2').locationpicker({
			location: {latitude: lat, longitude: lon},
			radius: 300,
			inputBinding: {
		        latitudeInput: $('#us2-lat'),
		        longitudeInput: $('#us2-lon'),
		        locationNameInput: $('#us2-address')
		    },
		    enableAutocomplete: true
		});
	}

	function getLocation()
	{
		var exists = "";
		var lat = 0, lon = 0;
		if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(setPos3, locError);
		} else {
	   		$.getJSON("http://ipinfo.io/", function(data){
				lat = data.loc.split(",")[0];
				lon = data.loc.split(",")[1];
			});
		}
	}

	function locError(error)
	{
		if (error.code == 1)
		{
			swal("Error!", "Please allow storally to know your location.", "error");
		}
		console.log(error);
	}
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
		        locationNameInput: $('#us2-address')
		    },
		    enableAutocomplete: true
		});
	}
	$("#mylocation").click(function(){
		getLocation();
	});
	$(".update_button").click(function(){
		var formData = new FormData($("#update_picture_form")[0]);
		var price = $(".price .text").val();
		var time = $("#time option:selected").val();
		var weekly = $(".price .weekly").val();
		var monthly = $(".price .monthly").val();
		var hasNoImage = ($(".photos img").val() == undefined);
		var data = "name="+$(".name-text").val()+"&pickupType="+pickupType+"&weeklyprice="+weekly+"&monthlyprice="+monthly+"&latitude="+$("#us2-lat").val()+"&longitude="+$("#us2-lon").val()+"&address="+$('#us2-address').val();
		swal("Uploading","Please wait, your changes are being saved.", "info");
				if ($("#uploadImage").val() != "")
				{
					// if(price < 8)
					// {
						$.post("api/ally/ally_update.php", data, function(r){
							$.ajax({
								url: "api/update_ally_photo.php",
								type: 'POST',
								contentType: false,
								data: formData,
								cache: false,
								processData:false,
								success: function(r)
								{
	   								if (r == "")
	   								{
   										swal("Saved!","Your changes have been updated.","success", function(){
   											window.location.reload();
   										});
   									} else {
   										swal("Error",data,"error", function(){
   											window.location.reload();
   										});
   									}
   								}
							});
						});
					// } else {
						// swal("Error","The price must be more than $8","error");
					// }
				} else if (hasNoImage == false) {
					if(price < 8)
					{
						$.post("api/ally/ally_update.php", data, function(r){
	   						if (r == "")
	   						{
   								swal("Saved!","Your changes have been updated.","success", function(){
   									window.location.reload();
   								});
   							} else {
   								swal("Error",r,"error", function(){
   									window.location.reload();
   								});
   							}
   						});
					} else {
						swal("Error","The price must be more than $8","error");
					}
				} else {
					swal("Error","Please select an image.","error");
				}
			});
	getLocation();
});
