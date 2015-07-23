 $(document).ready(function() {
     $('.edit').editable('save.php', {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         onblur: 'submit'
     });
     $('.edit_area').editable('save.php', {
         type      : 'textarea',
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="img/loading.gif">',
         tooltip   : 'Click to edit...',
			data : function(value,settings) {
				value = value.replace(/(\r\n|\n|\r)/gi,"");
				var retval = value.replace(/<br>/gi,"\n");
				return retval;
			},
			callback: function(value, settings) {
				var retval = value.replace(/<br>/gi, '\n');
				$(this).html(retval);	
			}
     });

	$( 'input[name="from"].datepicker' ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      onClose: function(dateText){
      	$(this).closest('div').find( 'input[name="to"].datepicker' ).datepicker( "option", "minDate", dateText );
		$(this).closest('div').find( 'input[name="to"].datepicker' ).focus();
      }
    });

	$( 'input[name="to"].datepicker' ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
    });
    
    $("#countrySelect").change(function(){
    	var theval = $(this).val();
    	$.ajax({
			type        : 'POST', 
			url         : 'locationsByCountry.php', 
			data        : {'countrycode':theval},  
			encode      : true
		}).done(function(data) {
			$("#locationSelect").html('<option selected disabled>Choose a location</option>');
			$(data).each(function(idx,item){
				$('<option value='+item.id+'>'+item.name+'</option>').appendTo("#locationSelect");
			});
		});
    });
    
    $("#locationSelect").change(function(){
    	var theval = $(this).val();
    	$.ajax({
			type        : 'POST', 
			url         : 'save.php', 
			data        : {'id':'location_id','value':theval},  
			encode      : true
		}).done(function(data) {
			
		});
    });
    
    $('.file-upload-form form').ajaxForm({ 
        	// dataType identifies the expected content type of the server response 
        	dataType:  'json', 
        	// success identifies the function to invoke when the server response 
        	// has been received 
        	success:    function (data,x,y,z) {
                    var form = $(z[0]);
                    if (data.success) {
                    	var imgcont = form.attr('data-imgcontid');
                    	$('#'+imgcont).css('background-image',"url('"+data.url+"')");
                    }
                    else
                    {
                    	alert(data.error);
                    }
                    
                    form.closest('.picture-upload').find('a').show();
                    form.closest('.file-upload-form').hide();
                }, 
    	});
    	
    $('.file-upload-form').hide();
    
    $('.file-upload-form form input').change(function (){
    	$(this).closest('form').submit();
    });
    
    $('.picture-upload a').click(function(){
    	$(this).closest('.picture-upload').find('.file-upload-form').show();
    	$(this).hide();
    });
    
    $('body').click(function(e){
    		if( $(e.target).closest(".picture-upload").length > 0 ) {
        		return true;
     		}
    	
    		$('.picture-upload').each(function(){
    			$(this).find('a').show();
    			$(this).find('.file-upload-form').hide();
    		});
    	
    });
    
    if ($('.editservice-form[data-available=false]').length) {
    	$('#addservice').addClass('disabled');
    	$('#addservicewrapper').tooltip(); 
    }
    
    var checkEditForm = function(){
    	var thePrice = $(this).closest('form').find('input[name="price"]').val();
    	var submit = $(this).closest('form').find('input[type="submit"]');
    	if (thePrice == "" || !(Number(thePrice) >= 0)) {
    		submit.attr('disabled', 'disabled');
    		$(this).closest('form').find('input[name="price"]').tooltip();
    		$(this).closest('form').find('input[name="price"]').addClass('errinput');
    	} else {
    		submit.removeAttr('disabled');
    		$(this).closest('form').find('input[name="price"]').tooltip('destroy');
    		$(this).closest('form').find('input[name="price"]').removeClass('errinput');
    	}
    };
    
    $('form.editservice-form :input').bind('input',checkEditForm);
    $('form.editservice-form :input').each(checkEditForm);
    
 });