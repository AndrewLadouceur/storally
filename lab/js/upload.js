/*
* @Author: ananayarora
* @Date:   2016-04-30 11:13:09
* @Last Modified by:   ananayarora
* @Last Modified time: 2016-04-30 14:45:59
*/

function sendToServer(url)
{
	var data = 'url='+url;
	$.post('upload_picture.php',url,function(r){
		return true;
	});
}

$(document).ready(function(){

});