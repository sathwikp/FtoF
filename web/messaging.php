<?php require 'init.php.inc'; ?>

<?php require '../vendor/autoload.php'; ?>

<?php

function sanitize($input) {
    return htmlspecialchars(trim($input));
}

header('Content-Type: application/json; Charset=UTF-8');

// Sanitize all the incoming data
$sanitized = array_map('sanitize', $_POST);

    	$error_message = [];
		if(!isset($_POST['first_name']) ||
	        //!isset($_POST['last_name']) ||
	        !isset($_POST['email_from'])     ||
	        !isset($_POST['comments'])) {
	        $error_message[] = "Please complete all the mandatory fields.";
	    }
	    
	    $first_name = $_POST['first_name']; // required
    	//$last_name = $_POST['last_name']; // required
    	$email_from = $_POST['email_from']; // required
    	$telephone = $_POST['phone_number']; // not required
    	$comments = $_POST['comments']; // required


  		if(!filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
   			$error_message[] = 'The Email Address you entered does not appear to be valid.';
 		}


   		if(strlen($first_name) == 0 || strlen($first_name)>150) {
 	    	$error_message[] = 'The First Name you entered does not appear to be valid.';
 		}
 
  		//if(strlen($first_name) == 0 || strlen($first_name)>150) {
 		//    $error_message[] = 'The Last Name you entered does not appear to be valid.';
		//}
 
  		if(strlen($comments) > 50000) {
		    $error_message[] = 'The Comments you entered do not appear to be valid.';
		}
 
  		if(count($error_message) > 0) {
 		    echo json_encode([
 		    	'success' => FALSE,
 		    	'error' => $error_message
 		    ]);

		} else {

			$email_message = "Name: ".($first_name)."\n";
			//$email_message .= "Last Name: ".($last_name)."\n";
			$email_message .= "Email: ".($email_from)."\n";
			if (strlen($telephone)>0)
				$email_message .= "Telephone: ".($telephone)."\n";
			$email_message .= "Comments: ".($comments)."\n";
			
				
			$html_message = '<html><head/><body>';
			$html_message .= "Name: ".($first_name)."<br/>";
			//$html_message .= "Last Name: ".($last_name)."<br/>";
			$html_message .= "Email: ".($email_from)."<br/>";
			if (strlen($telephone)>0)
				$html_message .= "Telephone: ".($telephone)."<br/>";
			$html_message .= "<br/>Comments: ".nl2br($comments);
			$html_message .= '</body></html>';

			$email_subject = "New message from: ".($first_name)." ".($last_name);

			$sendgrid = new SendGrid($api_user, $api_key);
			$sendemail = new SendGrid\Email();

			$sendemail->addTo('family2family.email@gmail.com')->
					  setFrom($email_from)->
					  setSubject($email_subject)->
					  setText($email_message)->
					  setHtml($html_message);
		
			$response = $sendgrid->send($sendemail);
			
			echo json_encode([
				'success' => TRUE,
				'response' => $response
			]);

		}


?>

<?php require 'destroy.php.inc'; ?>