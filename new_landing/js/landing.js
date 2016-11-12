/*
* @Author: ananayarora
* @Date:   2016-04-15 01:29:33
* @Last Modified by:   ananayarora
* @Last Modified time: 2016-04-16 02:30:47
*/

$(document).ready(function(){
	$(".welcome").delay(300).animate({
		'opacity':1
	});

	$(".menu").delay(500).animate({
		'opacity':1
	});

	$(".logo").delay(700).animate({
		'opacity':1
	});
	
	$(".slogan").delay(800).animate({
		'opacity':1
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
});

