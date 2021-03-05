// JavaScript Document

$(document).ready(function() {	
	var h1 = $(".main_left").height();
	var h2 = $(".main_right").height();
	if (h1>h2){
		   $(".main_right").height(h1+"px");
		} else {
		    $(".main_left").height(h2+"px");
		}
});