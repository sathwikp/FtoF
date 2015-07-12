<?php require 'init.php.inc';?>

<?php

$sql = 	"select p.name, p.description, p.picture, count(*) "
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
	$result[] = array_merge($row,
	[	
		'stars' => '4',
		'services' => [ServiceType::Stroller, ServiceType::CarSeat],
		//'_POST' => $_POST
	]);
}

echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>