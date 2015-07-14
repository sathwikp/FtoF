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
		document.location.href = $.param.fragment('results.php', formData );	
		return false;
	});
	
	$('form[name="search"] :input[name="location"]').typeahead({
	    dynamic: true,
	    hint: true,
    	cache: true,
	    display: ['citycountry', 'cityregioncountry'],
	    source: {
	    	location: {
        		url: {
            	type: "GET",
            	url: "locationAjax.php",
            	data: {
                		q: "{{query}}"
            		}
        		}
    		}
	    },
	    template: "{{name}} ({{region}}), {{countryname}}",
	    callback: {
        	//onSubmit: pushFormParams,
        	onClickAfter: function (node, a, item, event) {
        		$('form[name="search"] :input[name="locationid"]').val(item.id); 
        		$('form[name="search"] :input[name="location"]').val($(a).text());
        		// pushFormParams(); 
        	}
    	}
	});
  
	$('form[name="search"] :input[name="location"]').change(function (){
		console.log('onChange');
	    $('form[name="search"] :input[name="locationid"]').val('');
	});
});
