$(document).ready(function() {

	$('.round-button').click(function(){
		var theCurrVal=Number($(this).siblings('input').val());
		var theNewVal = theCurrVal+1;
		$(this).siblings('input').val(theNewVal);
		$(this).find('span > span.counter').text(theNewVal);
	});
	
	
	$('.decrease').click(function(e){
		var theCurrVal=Number($(this).closest('.round-button').siblings('input').val());
		if (theCurrVal > 0) {
			var theNewVal = theCurrVal-1;
			$(this).closest('.round-button').siblings('input').val(theNewVal);
			$(this).parent().find('span.counter').text(theNewVal);
		}
		e.preventDefault();
		return false;
	});
	
	  $('[data-toggle="tooltip"]').tooltip();
	  
});