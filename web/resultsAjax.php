<?php require 'init.php.inc';?>

<?php

$result = [

[
	'name' => 'Dupont',
	'description' => random_lipsum(),
	'picture' => 'img/profiles/dupont.jpeg',
	'stars' => '4',
	'services' => [ServiceType::Stroller, ServiceType::CarSeat],
	'_POST' => $_POST
]

];

echo json_encode($result);
?>

<?php require 'destroy.php.inc';?>