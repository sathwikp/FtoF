<?php require 'init.php.inc';?>

<?php
$id = intval($_GET['id']);

if (!isset($_SESSION['favourites']))
	$_SESSION['favourites'] = [];

if (!isset($_SESSION['favourites'][$id]))
	$_SESSION['favourites'][$id] = TRUE;
else	
	$_SESSION['favourites'][$id] = !$_SESSION['favourites'][$id];
?>

<?php require 'destroy.php.inc';?>