function clear_form_elements(ele) {

    $(ele).find(':input').each(function() {
        switch(this.type) {
            case 'checkbox':
            case 'radio':
                this.checked = false;
            	break;
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
			case 'search':
                $(this).val('');
                break;
        }
    });

}

$(document).ready(function() {

$(window).bind( 'hashchange', function( event ){
  	// get options object from hash
  	var hashOptions = $.deparam.fragment();
  	
  	if (hashOptions && !$.isEmptyObject(hashOptions)) {
  	// reset form values from json object
  	clear_form_elements($('form[name="criteria"]'));
	$.each(hashOptions, function(name, val){
    	var $el = $('form[name="criteria"] :input[name="'+name+'"]'),
        type = $el.attr('type');

    	switch(type){
        case 'checkbox':
            $el.filter('[value="'+val+'"]').attr('checked', 'checked');
            break;
        case 'radio':
            $el.filter('[value="'+val+'"]').attr('checked', 'checked');
            break;
        default:
            $el.val(val);
    	}
    	
    	$('.round-button').siblings('input').each(function(){
			$(this).parent().find('span > span.counter').text($(this).val());
		});
	});

	
	var overlay = $("<div />").css({
    	position: "absolute",
    	width: "100%",
    	height: "100%",
    	left: 0,
    	top: 0,
    	zIndex: 1000000,  // to be on the safe side
    	background: "#aaaaaa url(img/loading.gif) no-repeat 50% 50%",
    	opacity: 0.4,
        filter: "alpha(opacity=40)" /* For IE8 and earlier */
	}).appendTo($("#resultContainer").css("position", "relative"));
  
  	var dfd = jQuery.Deferred();
  	setTimeout(function() {
    	dfd.resolve();
  	}, 500 );
  	// apply options from hash
	$.when($.ajax({
			type        : 'POST', 
			url         : 'resultsAjax.php', 
			data        : $.param(hashOptions), 
			dataType    : 'json', 
			encode      : true
		}), dfd.promise()).done(function(ajaxObj) {
			var data = ajaxObj[0];
			$('#resultList').empty();
			$('#resultno').text($(data).length);
			$('#resultTpl').tmpl(data).appendTo('#resultList');
			/*
			$("#resultList li:has(a)").each(function() {
				var href = $("a:first",this).attr("href");
				$(this).find('.family_image').click(function(){
					window.location = href;
				});
   			});
   			*/
   			$("#resultList .likeImage a").click(function() {
   				var img = $(this).find('img');
   				var id = $(this).attr('data-id');
   				$.ajax({
					type        : 'GET', 
					url         : 'addtowishlist.php', 
					data        : {'id':id}, 
					encode      : true
				}).done(function() {
					if (img.attr('src') == 'img/Heart_button_icon_active.png') 
						img.attr('src','img/Heart_button_icon.png');
					else
						img.attr('src','img/Heart_button_icon_active.png');
				});
			});
			 
   			overlay.remove();
   		}).fail(function(){
    		overlay.remove();  		
   		});
  }
})
  // trigger hashchange to capture any hash data on init
  .trigger('hashchange');
  
	function pushFormParams() {
	  	var formData = {};
  		$('form[name="criteria"]').serializeArray().map(function(x){
  			formData[x.name] = x.value;
  		});
  		//console.log(formData);
  		$.bbq.pushState( formData , 2);
	}
  	
  	$('form[name="criteria"] :input').change(pushFormParams);
	$('form[name="criteria"]').submit(function(e) {
		e.preventDefault();
		return false;
	});
	
	$('form[name="criteria"] :input[name="location"]').typeahead({
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
        	onSubmit: pushFormParams,
        	onClickAfter: function (node, a, item, event) {
        		//console.log(item);
        		$('form[name="criteria"] :input[name="locationid"]').val(item.id); 
        		$('form[name="criteria"] :input[name="location"]').val($(a).text());
        		pushFormParams(); 
        	}
    	}
	});
  
	//$('form[name="criteria"] :input[name="location"]').change(function (){
	//    $('form[name="criteria"] :input[name="locationid"]').val('');
	//});

	$('.round-button, .round-button span').click(function(){pushFormParams();});
});