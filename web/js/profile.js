 $(document).ready(function() {
     $('.edit').editable('save.php', {
         submitdata : {profile_id: "1"},
         indicator : 'Saving...',
         tooltip   : 'Click to edit...'
     });
     $('.edit_area').editable('save.php', {
        submitdata : {profile_id: "1"},
         type      : 'textarea',
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="img/loading.gif">',
         tooltip   : 'Click to edit...'
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
    
 });