<?php require 'init.php.inc';?>

<?php

$SCRIPTSRC[] = "js/jquery.tmpl.min.js";
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
     	<label for="location">Location</label>
     	<input type="text" name="location" class="form-control" />
     </form>
  </div>
  <div id="resultList" class="col-md-6">
  </div>


<?php include 'footer.php.inc';?>

<?php require 'destroy.php.inc';?>