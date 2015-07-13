<?php require 'init.php.inc';?>

<?php

if (!array_key_exists('id',$_GET) || !array_key_exists('arrival',$_GET)  || !array_key_exists('departure',$_GET) ) {
	redirect_to_home();
}
$id = intval($_GET['id']);
$datespair = parse_and_validate_dates($_GET['arrival'], $_GET['departure']);
if (!($id > 0) || $datespair == FALSE) { 
	redirect_to_home();
}

list($arrival_date, $departure_date) = $datespair;

$PAGETITLE = "F2F | Services Detail";

//$SCRIPTSRC[] = "js/jquery.tmpl.min.js";

//$SCRIPTSRC[] = "js/results.js";

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

<?php
$qparams = [];
$sql = 	"select name, description, picture "
	. "from profile p "
	. "where id = :id";

$qparams[":id"] = $id;
	
$q = $db->prepare($sql);
$q->execute($qparams);
if ($q->rowCount() == 0) {
	redirect_to_home();
}
?>

  <div id="resultList" class="col-md-9">
	<?php 
	if ($row = $q->fetch(PDO::FETCH_ASSOC)) {

	echo 	'<div>'
			. '<h3>'.$row['name'].'</h3>'
			. '<div>'.$row['description'].'</div>';
			
	echo '<ul>';

	{
	$qparams = [];
	$sql = 	"select service_type, available, period, price_fix, price_per_day "
		. "from offered_service "
		. "where profile_id = :id "
		. "and period && '["
		. $arrival_date->format('Y-m-d').", "
		. $departure_date->format('Y-m-d')."]'::daterange ";

	$qparams[":id"] = $id;
	
	$q = $db->prepare($sql);
	$q->execute($qparams);
	
	while ($service = $q->fetch(PDO::FETCH_ASSOC)) {
		echo '<li>Service '.$service['service_type'].'</li>';	
	}

	}
	echo '</ul>';
	
	echo '</div>';

	}	
	?>
  </div>


<?php include 'footer.php.inc';?>

<?php require 'destroy.php.inc';?>