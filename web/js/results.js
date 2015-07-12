$(document).ready(function() {
	$('form[name="criteria"] :input').change(function() {
  		var formData = {};
  		$(this).closest('form').serializeArray().map(function(x){formData[x.name] = x.value;});
  		$.bbq.pushState( formData );
  		console.log(formData);
	});
	$('form[name="criteria"]').submit(function(e) {
		e.preventDefault();
		return false;
	});
});

$(window).bind( 'hashchange', function( event ){
  	// get options object from hash
  	var hashOptions = $.deparam.fragment();
  	
  	if (hashOptions && !$.isEmptyObject(hashOptions)) {
  	// reset form values from json object
	$.each(hashOptions, function(name, val){
    	var $el = $('form[name="criteria"] :input[name="'+name+'"]'),
        type = $el.attr('type');

    	switch(type){
        case 'checkbox':
            $el.attr('checked', 'checked');
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
		console.log(data); 
		$('#resultList').empty();
		$('#resultTpl').tmpl(data).appendTo('#resultList');
	});
  }
})
  // trigger hashchange to capture any hash data on init
  .trigger('hashchange');