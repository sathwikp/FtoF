<?php
require_once 'init.php.inc';

if(isset($_POST['email']) && isset($_POST['password']))
{
	$umail = $_POST['email'];
	$upass = $_POST['password'];
		
	if($user->login($umail,$upass))
	{
		echo '1';
	}
	else
	{
		echo '0';
	}	
}
else
{
	echo '-1';
}
?>

<?php require_once 'destroy.php.inc'; ?>