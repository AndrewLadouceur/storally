/*
* @Author: ananayarora
* @Date:   2016-05-09 15:06:04
* @Last Modified by:   ananayarora
* @Last Modified time: 2016-05-09 19:34:35
*/
$(document).ready(function(){
	$(".accept_button").click(function(){
		$.get("api/requests/accept_request.php?reqid="+$(this).attr('request-id'), function(r){
			swal('Success', 'You have accepted this request.', 'success');
			setTimeout(function(){
				swal.close();
			}, 2000);
		});
	});

	$(".reject_button").click(function(){
		$.get("api/requests/reject_request.php?reqid="+$(this).attr('request-id'), function(r){
			swal('Rejected', 'You have rejected this request.', 'info');
			setTimeout(function(){
				swal.close();
			}, 2000);
		});
	});
});