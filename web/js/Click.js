// JavaScript Document

addToCart = function(obj){
	if($(obj).parent().parent().hasClass('Available')){
		$(obj).parent().find(".ui_checkbox").prop('checked', true);
		$(obj).parent().parent().fadeOut(600).hide(800,function(){
		$(obj).parent().parent().parent().find('.AddedToCart').fadeIn(600).show(800).css('display','block');
		});
	}
	else if($(obj).parent().parent().hasClass('AddedToCart')){
		$(obj).parent().parent().parent().find(".ui_checkbox").prop('checked', false);
		$(obj).parent().parent().fadeOut(600).hide(800,function(){
		$(obj).parent().parent().parent().find('.Available').fadeIn(600).show(800).css('display','block');
	});
	}
};
changeTick = function(obj){
	if($(obj).find(".ui_checkbox_target").hasClass("clr")){
		$(obj).find(".ui_checkbox").prop('checked', true);
		$(obj).find(".ui_checkbox_target").removeClass('clr').addClass('chk');
	}
	else if($(obj).find(".ui_checkbox_target").hasClass("chk")){
		$(obj).find(".ui_checkbox").prop('checked', false);
		$(obj).find(".ui_checkbox_target").removeClass('chk').addClass('clr');			
	}
};