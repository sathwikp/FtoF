<?php require 'init.php.inc';?>

<?php

$PAGETITLE = "F2F | Search Results";

$SCRIPTSRC[] = "js/jquery.tmpl.min.js";
$SCRIPTSRC[] = "js/jquery.typeahead.min.js";
$SCRIPTSRC[] = "js/jquery-migrate-1.2.1.min.js";
$SCRIPTSRC[] = "js/jquery.ba-bbq.min.js";

$SCRIPTSRC[] = "js/results.js";

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
     	<input name="locationid" type="hidden" />
     	<div class="typeahead-container">
	     	<label for="location">Location</label>
        	<div class="typeahead-field">
     			<span class="typeahead-query">
     				<input name="location" type="search" placeholder="Search" autocomplete="off" />
     			</span>
     		</div>
     	</div>
     	<?php
     		foreach (ServiceType::GetTypes() as $key => $val) {
     			echo '<div class="checkbox">'
    				. '<label>'
      				. '<input type="checkbox" name="service__'.$key.'" value="'.$key.'"> '. $val
    				. '</label>'
					. '</div>';
     		}
     	 ?>
     </form>
  </div>
  <div id="resultList" class="col-md-6">
  </div>


<?php include 'footer.php.inc';?>

<?php require 'destroy.php.inc';?>