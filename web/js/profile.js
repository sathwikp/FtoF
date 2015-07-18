 $(document).ready(function() {
     $('.edit').editable('save.php', {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...'
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
     $(".ajaxupload").editable("upload.php", { 
        indicator : "<img src='img/loading.gif'>",
        type      : 'ajaxupload',
        submit    : 'Upload',
        cancel    : 'Cancel',
        tooltip   : "Click to upload..."
    });
    

	$( ".datepicker" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
 
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
    
 });