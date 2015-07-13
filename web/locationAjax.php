<?php require 'init.php.inc';?>

<?php
header('Content-Type: application/json; Charset=UTF-8');

$params = explode(',',trim($_GET["q"]));


$city = trim($params[0]);

$sql = 	"select id, accentcity, region, country "
	. "from location "
	. "where accentcity ILIKE '".$city."%' ";

if (isset($params[1])) {
	$country = trim($params[1]);
	$sql .=	 "and country ILIKE '".$country."%' ";
}	
	
$sql .=	"limit 1000 ";
	
$q = $db->prepare($sql);
$q->execute();

$result = [];
$sorted_result = [];

while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
	$row['citycountry'] = $row['accentcity'] .", ".$row['country'];
	$result[] = $row;
}

if (count($result) > 0) {

	for($i=0; $i<count($result); $i++) {	
   		$temp_arr[$i] = levenshtein($city, $result[$i]['accentcity']);
	}
	asort($temp_arr);
	foreach($temp_arr as $k => $v) {
	    $sorted_result[] = $result[$k];
	}

}

echo json_encode($sorted_result);
?>

<?php require 'destroy.php.inc';?>