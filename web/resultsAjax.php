<?php require 'init.php.inc';?>

<?php
header('Content-Type: application/json; Charset=UTF-8');

$sql = 	"select p.name, p.description, p.picture, count(*), array_to_json(array_agg(s.service_type)) as services "
	. "from profile p, offered_service s "
	. "where p.id = s.profile_id "
	. "and s.available = TRUE ";
	
$services = preg_grep_keys("/service__\d+/",$_POST);
if (count($services)>0) {
	$sql .= "and s.service_type in (".implode($services,', ').")";
}
	
$sql .=	"group by p.id, p.name, p.description, p.picture "
	. "order by count(*) desc";

$q = $db->prepare($sql);
$q->execute();

$result = [];

while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
	$new_element = array_merge($row,
	[	
		'stars' => '4',
		//'services' => [ServiceType::Stroller, ServiceType::CarSeat],
		//'_POST' => $_POST
	]);

	$new_element['services'] = json_decode($new_element['services']);
	$result[] = $new_element;
}

echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>