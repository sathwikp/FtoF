$(document).ready(function(){

	$( "#datepickerArrival" ).datepicker({
		 minDate: 0,
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
	
	$( "#datepickerDeparture" ).datepicker({
		minDate: 0,
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });

});