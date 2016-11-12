/*
* @Author: ananayarora
* @Date:   2016-05-08 04:19:00
* @Last Modified by:   ananayarora
* @Last Modified time: 2016-05-08 23:55:35
*/
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars;
}
$(document).ready(function(){
	$(".ask_for_details").click(function(){
		$.get("api/ally/ally_request_status.php?id=" + getUrlVars()["id"], function(r){
			if (r == "false")
			{	
				swal({
					title: "Ask for details",
					text: `<form id=\"details_request_form\"><p></p><br /><p>Tell the Ally a little about yourself<br />
1. For how long are  you looking to store your stuff?( If not sure, mention the approximate time period)<br />
2. How much stuff do you have?( Eg. Two cartons of 2.2 cubic feet; a suitcase; A bike)<br />
3. What are you storing? (Books; clothes; Utensils etc.)</p><br /><textarea class=\"details_request_message\" name=\"details\" placeholder=\"
Hey I am Jamie! I'm going home to China and looking to store some clothes and a bike over the summer. It's a suitcase and a small carton\"\"></textarea></form>`,
					html: true,
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
					confirmButtonText:"Ask for Details"
				}, function(){
					$.get("api/requests/send_request.php?id="+getUrlVars()["id"]+"&message="+$(".details_request_message").val(), function(r){
						if (r == 'truealready')
						{
							swal("Error", "This person has already accepted your request", "info");
						} else if (r == 'truealreadyrequest') {
							swal("Error", "You've already sent this person a request", "info");
						} else if (r == 'false') {
							swal("Success","Request sent!","success");
						} else if (r == 'falsephotoid') {
							swal("Error","You cannot send requests until your photo id is verified!","error");
						}
						console.log(r);
					});
				});
			}
		});
	});
});