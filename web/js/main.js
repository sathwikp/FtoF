$(document).ready(function(){
	$('#borrow-head').on('click',function (e) {
	    e.preventDefault();

	    var target = '#borrow-section';
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});
	$('#lend-head').on('click',function (e) {
	    e.preventDefault();

	    var target = '#lend-section';
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 1000, 'swing', function () {
	        window.location.hash = target;
	    });
	});
	$('#share-head').on('click',function (e) {
	    e.preventDefault();

	    var target = '#share-section';
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 1200, 'swing', function () {
	        window.location.hash = target;
	    });
	});
	
   $('form[name="search"]').submit(function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		var emptyfields = $('form[name="search"] :input[type="text"]')
			.filter(function() {
        		return $.trim(this.value).length === 0;
    		});

		if (!emptyfields.length > 0) {
    		document.location.href = $.param.fragment('results.php', formData );
		} else {
			$(emptyfields).each(function(){
				console.log($(this));
			});
		}
		
		return false;
	});
	
	
	
});
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
}

