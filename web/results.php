<?php require 'init.php.inc';?>

<?php

$SCRIPTSRC[] = "js/jquery.tmpl.min.js";

$SCRIPTS[] =
"$(document).ready(function() {
	$('form[name=\"criteria\"] :input').change(function() {
  		formData = $(this).closest('form').serialize();
  		console.log(formData);
  		// process the form
        $.ajax({
            type        : 'POST', 
            url         : 'resultsAjax.php', 
            data        : formData, 
            dataType    : 'json', 
        	encode      : true
        }).done(function(data) {
            console.log(data); 
            $('#resultList').empty();
            $('#resultTpl').tmpl(data).appendTo('#resultList');
        });
	});
	$('form[name=\"criteria\"]').submit(function(e) {
		e.preventDefault();
		return false;
	});
});";

$SCRIPTS[] =
[
['id' => 'resultTpl', 'type' => 'text/x-jquery-tmpl'],
'<div>
<h3>${name}</h3>
<div>${description}</div>
<ul>
{{each services}}
<li>service ${$value}</li>
{{/each}}
</ul>
</div>'	
];

?>

<?php include 'header.php.inc';?>


  <div class="col-md-3 col-md-offset-1">
     <form name="criteria"> 
     	<label for="location">Location</label>
     	<input type="text" name="location" class="form-control" />
     </form>
  </div>
  <div id="resultList" class="col-md-6">
  </div>


<?php include 'footer.php.inc';?>

<?php require 'destroy.php.inc';?>