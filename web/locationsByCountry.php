<?php require 'init.php.inc';?>

<?php
header('Content-Type: application/json; Charset=UTF-8');

if (!isset($_POST['countrycode'])){
	die ('Missing parameter');
}

$sql = 	"select id, name "
	. "from porref_nearest "
	. "where countrycode = :countrycode "
	. "and locationtype = 'C' "
	. "order by name ASC ";

$q = $db->prepare($sql);
$q->execute(['countrycode'=>$_POST['countrycode']]);
$result = [];
while($loc = $q->fetch(PDO::FETCH_ASSOC)) {
	$result[] = $loc;
}

echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>