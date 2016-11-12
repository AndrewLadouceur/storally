/*
* @Author: ananayarora
* @Date:   2016-03-28 00:14:32
* @Last Modified by:   ananayarora
* @Last Modified time: 2016-04-02 03:30:31
*/

$(document).ready(function(){
	$(".logo").animate({
		'opacity':1,
		'marginTop':'10px'
	}, function(){
		$(".signup_form").animate({
			'opacity':1,
			'marginTop':'10px'
		});
	});
	$("#story").click(function(){
		$(".story").show();
	});
	$("#storer").click(function(){
		$(".story").hide();
	});
});