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
	
	 $( "#datepickerArrival" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
	
	$( "#datepickerDeparture" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
});
