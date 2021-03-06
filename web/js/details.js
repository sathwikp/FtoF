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
		var theTotalFld2 = $(this).closest('.Available').
			siblings('.AddedToCart').find('div.TotalPrice > h3 > span');
		$.each([theTotalFld, theTotalFld2], function(i,x){
			x.text(Math.round(dayDiff*price*100)/100); //rounds to 2 decimal places
		}); 
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
		var theTotalFld2 = $(this).closest('.Available').
			siblings('.AddedToCart').find('div.TotalPrice > h3 > span');
		$.each([theTotalFld, theTotalFld2], function(i,x){
			x.text(Math.round(dayDiff*price*100)/100); //rounds to 2 decimal places
		}); 
      //	$( "#datepickerDeparture" ).datepicker( "option", "minDate", dateText );
		//$( "#datepickerDeparture" ).focus();
      }
    });
    
    $( ".datepickerArrival, .datepickerDeparture" ).each(function(){
    	$(this).datepicker( "option", "minDate", $(this).attr('data-mindate') );
    	$(this).datepicker( "option", "maxDate", $(this).attr('data-maxdate') );
    });

	$("#modalBtn").click(function(){
		$("#SendMail #selectedServices").html('');
		$('form[name="serviceSelection"] :input:checked').each(function(){
			var price = Number($(this).closest('div').siblings()
				.find('.datepickerArrival').attr('data-price'));
			var arrival = $(this).closest('div').siblings()
				.find('.datepickerArrival').datepicker('getDate');
			var departure = $(this).closest('div').siblings()
				.find('.datepickerDeparture').datepicker('getDate');
			var arrivaltxt = $(this).closest('div').siblings()
				.find('.datepickerArrival').val();
			var departuretxt = $(this).closest('div').siblings()
				.find('.datepickerDeparture').val();				
			var dayDiff = Math.abs(Math.ceil((departure - arrival) / (1000 * 60 * 60 * 24)))+1;
			
			$('<li class="list-group-item"><span class="badge">'+dayDiff*price+'&#8364;'+'</span>'+$(this).attr('data-servicename')+' - '+arrivaltxt+', '+departuretxt+'</li>')
				.appendTo($("#SendMail #selectedServices"));
		});
        $("#SendMail").modal();
    });
    
    $("form[name='serviceSelection'] :input").change(function(){
    	var theTotalPrice = 0;
    	
    	$("form[name='serviceSelection'] :input:checked").each(function(){
    		//console.log($(this).val());
    		var arrDate = $(this).closest('div').siblings()
    			.find('.datepickerArrival').datepicker('getDate');
    			
    		var depDate =  $(this).closest('div').siblings()
    			.find('.datepickerDeparture').datepicker('getDate');
    			
    		var dayDiff = Math.abs(Math.ceil((depDate - arrDate) / (1000 * 60 * 60 * 24)))+1;
			var price = Number($(this).closest('div').siblings()
    			.find('.datepickerArrival').attr('data-price'));
    			
    		theTotalPrice += dayDiff*price;
    	});
    	
    	//console.log(theTotalPrice);
    	
    	var theTotalFld = $('#Amount > span');
		theTotalFld.text(Math.round(theTotalPrice*100)/100); //rounds to 2 decimal places
    });
    
    $('form[name="mailform"]').submit(function(e){
    	e.preventDefault();
    	
    	$.ajax({
			type        : 'POST', 
			url         : 'messaging.php', 
			data        : $('form[name="mailform"], form[name="serviceSelection"]').serialize(), 
			dataType    : 'json', 
			encode      : true
		}).done(function(data) {
			//console.log(data);
			if (!data.success){
				var errCont = $("#SendMail").find('.share-error');
				errCont.html('');
				var errUl = $('<ul  class="list-group" />').appendTo(errCont);
				$(data.error).each(function(i,x){
					errUl.append('<li class="list-group-item list-group-item-danger">'+x+'</li>');
				});
			} else {
				$('form[name="mailform"]')[0].reset();
				$("#SendMail").modal('hide');
				$("#Success").modal();
			}
		});
		
    	return false;
    });
    
    $('.likeFamily').click(function(){
    	
    	var heart = $(this).find('span.glyphicon-heart');
		var id = $(this).attr('data-profileid');
		
    	$.ajax({
			type        : 'GET', 
			url         : 'addtowishlist.php', 
			data        : {'id':id}, 
			encode      : true
		}).done(function() {
			heart.toggleClass('wished');
		}); 
    });
    
});