$(document).ready(function(){

	$( ".datepickerArrival" ).datepicker({
	  minDate: 0,
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      onClose: function(dateText, inst) {
		var price = Number($(this).attr('data-price'));
      	var otherdate = $(this).closest('div').find('.datepickerDeparture').datepicker('getDate');
      	var thisdate = $(this).datepicker('getDate');
		var dayDiff = Math.abs(Math.ceil((otherdate - thisdate) / (1000 * 60 * 60 * 24)))+1;
		var theTotalFld = $(this).closest('div').siblings().find('div.TotalPrice > h3 > span');
		theTotalFld.text(Math.round(dayDiff*price*100)/100); //rounds to 2 decimal places
      	$(this).closest('div').find('.datepickerDeparture').datepicker( "option", "minDate", dateText );
		//$( "#datepickerDeparture" ).focus();
      }
    });
	
	
	
	$( ".datepickerDeparture" ).datepicker({
	  minDate: 0,
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      onClose: function(dateText, inst) {
		var price = Number($(this).attr('data-price'));
      	var otherdate = $(this).closest('div').find('.datepickerArrival').datepicker('getDate');
      	var thisdate = $(this).datepicker('getDate');
		var dayDiff = Math.abs(Math.ceil((otherdate - thisdate) / (1000 * 60 * 60 * 24)))+1;
		var theTotalFld = $(this).closest('div').siblings().find('div.TotalPrice > h3 > span');
		theTotalFld.text(Math.round(dayDiff*price*100)/100); //rounds to 2 decimal places
      //	$( "#datepickerDeparture" ).datepicker( "option", "minDate", dateText );
		//$( "#datepickerDeparture" ).focus();
      }
    });
    
    $( ".datepickerArrival, .datepickerDeparture" ).each(function(){
    	$(this).datepicker( "option", "minDate", $(this).attr('data-mindate') );
    	$(this).datepicker( "option", "maxDate", $(this).attr('data-maxdate') );
    });

});