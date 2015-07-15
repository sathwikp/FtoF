<?php require 'init.php.inc';?>

<?php

if (!array_key_exists('arrival',$_POST)  || !array_key_exists('departure',$_POST) ) {
	die("Invalid parameters");
}
$datespair = parse_and_validate_dates($_POST['arrival'], $_POST['departure']);
if ($datespair == FALSE) { 
	die("Invalid parameters");
}
list($arrival_date, $departure_date) = $datespair;

$services = array_map("intval",preg_grep_keys("/service__\d+/",$_POST));

//intval($_POST['babyno']),
//intval($_POST['oldbabyno']),
//intval($_POST['boyno'])

$sql = 	"select p.id, p.name, p.description, p.picture, count(*) as services_no, array_to_json(array_agg(s.service_type)) as services_type,  array_to_json(array_agg(s.price_per_day)) as services_price_per_day "
	. "from profile p, offered_service s "
	. "where p.id = s.profile_id "
	. "and s.available = TRUE "
	. "and s.period && '["
	. $arrival_date->format('Y-m-d').", "
	. $departure_date->format('Y-m-d')."]'::daterange ";
	

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
		'stars' => rand(1, 5),
		'arrival' => $arrival_date->format(__DATEFORMAT),
		'departure' => $departure_date->format(__DATEFORMAT)
	]);

	$types = json_decode($new_element['services_type']);
	$prices = json_decode($new_element['services_price_per_day']);
	
	for ($i=0; $i<count($types); ++$i){
		$new_element['services'][] = [
			'type' => $types[$i],
			'price_per_day' => $prices[$i],
			'pic' => ServiceType::GetPics()[$types[$i]],
			'name' => ServiceType::GetTypes()[$types[$i]]
		];
	}
	
	$result[] = $new_element;
}

header('Content-Type: application/json; Charset=UTF-8');
echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>