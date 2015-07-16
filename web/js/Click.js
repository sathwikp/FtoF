// JavaScript Document
$(document).ready(function(){


$('a.add-to-cart').click(function(){
	var parentDiv = $(this).closest('.Available');
	parentDiv.find(".ui_checkbox").click();
	parentDiv.fadeOut(600).hide(800,function(){
		parentDiv.siblings('.AddedToCart').fadeIn(600).show(800).css('display','block');
	});
});

$('a.remove-from-cart').click(function(){
	var parentDiv = $(this).closest('.AddedToCart');
	parentDiv.siblings('.Available').find(".ui_checkbox").click();
	parentDiv.fadeOut(600).hide(800,function(){
		parentDiv.siblings('.Available').fadeIn(600).show(800).css('display','block');
	});
});	
	
$("div.checkMark .ui_checkbox_target").each(function(){
	if ($(this).closest("div.checkMark").find(".ui_checkbox").prop("checked")) {
		$(this).removeClass('clr');
		$(this).addClass('chk');
	}
});

$('div.checkMark').click(function(){
	var obj = $(this);
	if($(obj).find(".ui_checkbox_target").hasClass("clr")){
		$(obj).find(".ui_checkbox").click();
		$(obj).find(".ui_checkbox_target").removeClass('clr').addClass('chk');
	}
	else if($(obj).find(".ui_checkbox_target").hasClass("chk")){
		$(obj).find(".ui_checkbox").click();
		$(obj).find(".ui_checkbox_target").removeClass('chk').addClass('clr');			
	}
});

});