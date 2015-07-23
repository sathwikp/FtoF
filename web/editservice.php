<?php require 'init.php.inc'; ?>

<?php

function sanitize($input) {
    return htmlspecialchars(trim($input));
}

		//header('Content-Type: application/json; Charset=UTF-8');

		try {

		// Sanitize all the incoming data
		$_POST = array_map('sanitize', $_POST);

    	$error_message = [];
		
		if (!isset($_SERVER['HTTP_REFERER']) ||
			(strpos($_SERVER['HTTP_REFERER'], 'localhost') === FALSE &&
			strpos($_SERVER['HTTP_REFERER'], 'ftof.herokuapp.com') === FALSE &&
			strpos($_SERVER['HTTP_REFERER'], 'family2family.eu') === FALSE)) {
	        $error_message[] = "Technical error: not allowed to perform this action";	
	        goto theExit;				
		}
		
		
		if (!$user->is_loggedin()) {
	        $error_message[] = "Technical error: unknown profile id";	
	        goto theExit;	
		}

		$profile_id = intval($_SESSION['user_session']);
		
		$from = DateTime::createFromFormat(__DATEFORMAT, $_POST['from']);
		$to = DateTime::createFromFormat(__DATEFORMAT, $_POST['to']);



				$sql = 	"update offered_service set available = TRUE, service_type = :type, period = daterange('".$from->format('Y-m-d')."', '".$to->format('Y-m-d')."','[]'), price_per_day = :price, service_desc = :desc "
					. "where ctid = :ctid and profile_id = :pid ";

				$qparams = [
							":price" => $_POST['price'],
					 		":type" => $_POST['type'],
					 		":desc" => $_POST['desc'],
					 		":ctid" => $_POST['ctid'],
					 		":pid" => $profile_id
					 	];
	
				$q = $db->prepare($sql);
				$q->execute($qparams);	

		} catch(Exception $e){}
 
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

	$user->redirect('profile.php#service-list');
?>

<?php require 'destroy.php.inc'; ?>