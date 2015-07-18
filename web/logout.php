<?php require 'init.php.inc';?>

<?php

	$user->logout();
	$user->redirect('index.php');

?>
<?php require 'destroy.php.inc';?>
