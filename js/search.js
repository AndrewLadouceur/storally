/*
* @Author: ananayarora
* @Date:   2016-05-01 18:44:35
* @Last modified by:   ananayarora
* @Last modified time: 2016-08-14T03:43:36+05:30
*/
var latestreponse;
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
$(document).ready(function(){
	$(".submit_button").click(function(){
		var data = "api/ally/get_allies.php?lat="+$("#us2-lat").val()+"&lon="+$("#us2-lon").val()+"&radius="+(parseInt($("#rad").val()) * 1000);
    $(".results").html("<div class=\"back_button\">Search Again</div><br /><br />");
		$.getJSON(data, function(r){
			latestreponse = r;
			if (r.length == 0)
			{
				swal("No Allies found nearby", "There are no allies within the given radius. Please try again!","info");
			}
			for (var i = 0; i <= r.length - 1; i++) {
				var formatdesc = "<div class=price>"+r[i]['price']+" <br />"+r[i]['time']+"<br />"+r[i]['dist']+" away</div><br />";
				var link = r[i]['link']+'&lat='+$("#lat").val()+'&lon='+$("#lon").val();
				var html = "<center>"+r[i]['price']+"&nbsp;<br />&nbsp;"+r[i]['time']+"<br />"+r[i]['dist']+" away<br /><br /><br /><a onclick='swal({title:\""+r[i]['title'].replace("'","&rsquo;")+"\",text:\""+formatdesc+"\",html:true, confirmButtonText:\"View\",closeOnConfirm:\"false\",showCancelButton:\"true\"}, function(inp){if(inp){var win=window.open(\""+link+"\",\"_blank\");win.focus();}});' id=\"details_view_map\" class='details_view_map' title=\""+r[i]['desc']+"\">View Details</a></center>";
				$("#map").addMarker({
					coords: [r[i]['lat'], r[i]['lon']],
					title: '<div style="padding:20px;">'+r[i]['title']+'</div>',
					text: html,
				});
        $(".back_button").show();
				$(".results").append("<div class=\"result\" lat=\""+r[i]['lat']+"\" lon=\""+r[i]['lon']+"\">"+r[i]['image']+"<br /><br /><p>"+r[i]['title']+"</p></div>");
				$("#search_form").slideUp();
			};
		});
	});
	$(document).on('keydown', 'input', function(e){
			if (e.keyCode == 13)
			{
        $(".submit_button").trigger('click');
			}
		});
	$(document).on("click", ".result", function(e){
		var thelat = $(this).attr("lat");
		var thelon = $(this).attr("lon");
		$("#map").centerMap({
			'coords': [thelat, thelon]
		});

	});
  $(document).on("click", ".back_button", function(){
    $(".results").html("");
    $("#search_form").slideDown();
  });
	function getLocation()
	{
		if ($("#address").val() == "")
		{
			if (navigator.geolocation) {
        		swal("Getting Position","Please wait while we locate you.");
        		navigator.geolocation.getCurrentPosition(setPos);
    		} else {
    		   	$.getJSON("http://ipinfo.io/", function(data){
					lat = data.loc.split(",")[0];
					lon = data.loc.split(",")[1];
				});
    		}
		} else {
			$(".submit_button").trigger('click');
      $("#us2-lat").val(getUrlVars()["lat"]);
      $("#us2-lon").val(getUrlVars()["lon"]);

      $('#us2').locationpicker({
  			location: {latitude: getUrlVars()["lat"], longitude: getUrlVars()["lon"]},
  			radius: 300,
  			inputBinding: {
  		        latitudeInput: $('#us2-lat'),
  		        longitudeInput: $('#us2-lon'),
  		        locationNameInput: $('.search_bar_home')
  		    },
  		    enableAutocomplete: true
  		});
      $("#map").googleMap({
  			coords: [getUrlVars()["lat"], getUrlVars()["lon"]]
  		});
      $(".submit_button").trigger('click');
		}
	}
	function setPos(pos)
	{
		swal.close();
		$("#lat").val(pos.coords.latitude);
		$("#lon").val(pos.coords.longitude);
		$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng='+$("#lat").val()+","+$("#lon").val(),function(r){
			$("#address").val(r.results[0].formatted_address);
		});
		$("#map").googleMap({
			coords: [pos.coords.latitude, pos.coords.longitude]
		});
    var lat = pos.coords.latitude;
		var lon = pos.coords.longitude;
    $("#us2-lat").val(lat);
    $("#us2-lon").val(lon);
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
	getLocation();
});
