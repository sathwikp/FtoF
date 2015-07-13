<?php require 'init.php.inc';?>

<?php
header('Content-Type: application/json; Charset=UTF-8');

$params = explode(',',trim($_GET["q"]));

$querystr = trim($_GET["q"]);

$city = trim($params[0]);

$sql = 	"select id, name, region, countryname, least( levenshtein(lower(name || ' ' || region || ' ' || countryname), lower(:query)), levenshtein(lower(name || ' ' || countryname), lower(:query)), levenshtein(lower(name || ' ' || region), lower(:query)), levenshtein(lower(name), lower(:query)) ) as distance "
	. "from porref "
	//. "where name ILIKE '".$city."%' "
	. "where least( levenshtein(lower(name || ' ' || region || ' ' || countryname), lower(:query)), levenshtein(lower(name || ' ' || countryname), lower(:query)), levenshtein(lower(name || ' ' || region), lower(:query)), levenshtein(lower(name), lower(:query)) ) < 10 "
	. "and locationtype='C' "
	. "order by distance asc ";
/*
if (isset($params[1]) && !isset($params[2])) {
	$country = trim($params[1]);
	$sql .=	 "and countryname ILIKE '".$country."%' ";
}	

if (isset($params[1]) && isset($params[2])) {

	$region = trim($params[1]);
	$sql .=	 "and region ILIKE '".$region."%' ";

	$country = trim($params[2]);
	$sql .=	 "and countryname ILIKE '".$country."%' ";
}	
*/	
$sql .=	"limit 5 ";
	
$q = $db->prepare($sql);
$q->bindParam(':query', $querystr , PDO::PARAM_STR);
$q->execute();

$result = [];
$sorted_result = [];

while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
	$row['citycountry'] = $row['name'] ." ".$row['countryname'];
	$row['cityregioncountry'] = $row['name'] ." ". $row['region']." ".$row['countryname'];
	$result[] = $row;
}
/*
if (count($result) > 0) {

	for($i=0; $i<count($result); $i++) {	
   		$temp_arr[$i] = levenshtein($city, $result[$i]['name']);
	}
	asort($temp_arr);
	foreach($temp_arr as $k => $v) {
	    $sorted_result[] = $result[$k];
	}

}
*/
echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>