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

$location_id = intval($_POST['locationid']);

$sql = 	"select p.id, p.name, p.description, p.picture, l.name as cityname, l.countryname, count(*) as services_no, array_to_json(array_agg(s.service_type)) as services_type,  array_to_json(array_agg(s.price_per_day)) as services_price_per_day "
	. "from profile p, offered_service s, porref_nearest l "
	. "where p.id = s.profile_id "
	. "and s.available = TRUE "
	. "and s.price_per_day is not null "	
	. "and l.id = p.location_id "
	. "and (p.location_id = ".$location_id." or ".$location_id." = ANY (l.nearest)) " 
	. "and s.period @> '["
	. $arrival_date->format('Y-m-d').", "
	. $departure_date->format('Y-m-d')."]'::daterange ";
	

if (count($services)>0) {
	$sql .= "and s.service_type in (".implode($services,', ').") ";
}
	
$sql .=	"group by p.id, p.name, p.description, p.picture, l.name, l.countryname "
	. "order by count(*) desc";

$q = $db->prepare($sql);
$q->execute();

$result = [];


while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
	$new_element = array_merge($row,
	[	
		'stars' => isset($_SESSION['stars'][$row['id']]) ? $_SESSION['stars'][$row['id']] : ($_SESSION['stars'][$row['id']] = round(rand(1, 5),1)),
		'wished' => (isset($_SESSION['favourites'][$row['id']]) && $_SESSION['favourites'][$row['id']]),
		'arrival' => $arrival_date->format(__DATEFORMAT),
		'departure' => $departure_date->format(__DATEFORMAT)
	]);

	$types = json_decode($new_element['services_type']);
	$prices = json_decode($new_element['services_price_per_day']);
	
	
	$inqparams = [];
	$insql = 	"select service_type, available, period, price_fix, price_per_day "
		. "from offered_service "
		. "where profile_id = :id "
		. "and price_per_day is not null "
		. "and period @> '["
		. $arrival_date->format('Y-m-d').", "
		. $departure_date->format('Y-m-d')."]'::daterange ";

	$inqparams[":id"] = $row['id'];
	
	$inq = $db->prepare($insql);
	$inq->execute($inqparams);
	while ($inservice = $inq->fetch(PDO::FETCH_ASSOC)) {
		$new_element['services'][] = [
			'type' => $inservice['service_type'],
			'price_per_day' => $inservice['price_per_day'],
			'pic' => ServiceType::GetPics()[$inservice['service_type']],
			'name' => ServiceType::GetTypes()[$inservice['service_type']]
		];
	}
	
	
	$new_element['stars']=5;
	
	$result[] = $new_element;
}

header('Content-Type: application/json; Charset=UTF-8');
echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>