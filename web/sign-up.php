<?php
require_once 'init.php.inc';

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']))
{
	$error = [];
	
	$umail = trim($_POST['email']);
	$upass = trim($_POST['password']);
	$upass2 = trim($_POST['password2']);

	if($umail=="")	{
		$error[] = "Please provide email address!";	
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Please enter a valid email address !';
	}
	else if($upass=="")	{
		$error[] = "provide password !";
	}
	else if(strlen($upass) < 8){
		$error[] = "Password must be at least 8 characters long";	
	}
	else if($upass != $upass2){
		$error[] = "Password does not match the password confirmation";	
	}
	else
	{
		try
		{
			$stmt = $db->prepare("SELECT email FROM profile WHERE email=:umail");
			$stmt->execute(array(':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['email']==$umail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($user->register($umail,$upass))	{
					
					//done!
				} 
				else
				{
					$error[] = "Unknown error";
				}
			}
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
	}
	
	if (count($error)>0) {
			echo json_encode([
				'success' => FALSE,
				'error' => $error
			]);
	}	else {
			echo json_encode([
				'success' => TRUE
			]);
	}
}

?>

<?php require_once 'destroy.php.inc'; ?>