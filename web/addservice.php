<?php require 'init.php.inc'; ?>

<?php

function sanitize($input) {
    return htmlspecialchars(trim($input));
}

		//header('Content-Type: application/json; Charset=UTF-8');

		// Sanitize all the incoming data
		//$_POST = array_map('sanitize', $_POST);

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
		

				$sql = 	"insert into offered_service (service_type, profile_id, period, available) "
					  . "values (0, :pid, daterange(current_date, current_date), TRUE) ";

				$qparams = [
					 		":pid" => $profile_id
					 	];
	
				$q = $db->prepare($sql);
				$q->execute($qparams);	


 
theExit:
  		//if(count($error_message) > 0) {
 		    //echo json_encode([
 		    //	'success' => FALSE,
 		    //	'error' => $error_message
 		    //]);
 		  //  
 		 //   echo '';
//
//		} else {
 //		    echo $value;
//		}

	$user->redirect('profile.php');
?>

<?php require 'destroy.php.inc'; ?>