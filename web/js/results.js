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
	});
  
  // apply options from hash
	$.ajax({
		type        : 'POST', 
		url         : 'resultsAjax.php', 
		data        : $.param(hashOptions), 
		dataType    : 'json', 
		encode      : true
	}).done(function(data) {
		//console.log(data); 
		$('#resultList').empty();
		$('#resultTpl').tmpl(data).appendTo('#resultList');
		$("#resultList li:has(a)").click(function() {
      		window.location = $("a:first",this).attr("href");
   		});
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
  		console.log(formData);
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
  
	$('form[name="criteria"] :input[name="location"]').change(function (){
	    $('form[name="criteria"] :input[name="locationid"]').val('');
	});
 
});