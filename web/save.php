<?php require 'init.php.inc'; ?>

<?php

function sanitize($input) {
    return htmlspecialchars(trim($input));
}

		//header('Content-Type: application/json; Charset=UTF-8');

		// Sanitize all the incoming data
		$_POST = array_map('sanitize', $_POST);

    	$error_message = [];
		
		if (!isset($_SERVER['HTTP_REFERER']) ||
			(strpos($_SERVER['HTTP_REFERER'], 'localhost') === FALSE &&
			strpos($_SERVER['HTTP_REFERER'], 'ftof.herokuapp.com') === FALSE)) {
	        $error_message[] = "Technical error: not allowed to perform this action";	
	        goto theExit;				
		}
		
		
		
		if (!$user->is_loggedin()) {
	        $error_message[] = "Technical error: unknown profile id";	
	        goto theExit;	
		}

		$profile_id = intval($_SESSION['user_session']);
		
		if (!isset($_POST['id'])) {
	        $error_message[] = "Technical error: unknown field id";	
	        goto theExit;	
		}
		
		$id = ($_POST['id']);

		if (!isset($_POST['value'])) {
	        $error_message[] = "Technical error: unknown field value";	
	        goto theExit;	
		}
		
		$value = ($_POST['value']);
/*		
		$services = array_map("intval",preg_grep_keys("/service__\d+/",$_POST));
		
		if (!count($services)>0) {
			$error_message[] = "You should select at least one service";	
	        goto theExit;	
		}
*/

		switch ($id) {
			case 'name':
			case 'description':
			case 'location_id':
			
			{
				$sql = 	"update profile set ".$id."= :fval "
					. "where id = :pid ";

				$qparams = [
					 		//":fid" => $id,
					 		":fval" => $value,
					 		":pid" => $profile_id,
					 	];
	
				$q = $db->prepare($sql);
				$q->execute($qparams);	
			}
			
			break;
			default: 
		}		

 
theExit:
  		if(count($error_message) > 0) {
 		    //echo json_encode([
 		    //	'success' => FALSE,
 		    //	'error' => $error_message
 		    //]);
 		    
 		    echo '';

		} else {
 		    echo $value;
		}
?>

<?php require 'destroy.php.inc'; ?>