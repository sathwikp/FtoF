<?php require 'init.php.inc'; ?>

<?php require '../vendor/autoload.php'; ?>

<?php

		if(!isset($_POST['first_name']) ||
	        !isset($_POST['last_name']) ||
	        !isset($_POST['email']) ||
	        !isset($_POST['telephone']) ||
	        !isset($_POST['comments'])) {
	        died('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }
	    
	    $first_name = $_POST['first_name']; // required
    	$last_name = $_POST['last_name']; // required
    	$email_from = $_POST['email']; // required
    	$telephone = $_POST['telephone']; // not required
    	$comments = $_POST['comments']; // required

    	$error_message = [];
  		if(!filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
   			$error_message[] = 'The Email Address you entered does not appear to be valid.';
 		}


   		if(strlen($first_name) == 0 || strlen($first_name)>150) {
 	    	$error_message[] = 'The First Name you entered does not appear to be valid.';
 		}
 
  		if(strlen($first_name) == 0 || strlen($first_name)>150) {
 		    $error_message[] = 'The Last Name you entered does not appear to be valid.';
		}
 
  		if(strlen($comments) > 50000) {
		    $error_message[] = 'The Comments you entered do not appear to be valid.';
		}
 
  		if(count($error_message) > 0) {
 		    died($error_message);
		}
 
   		function clean_string($string) {
 			$bad = array("content-type","bcc:","to:","cc:","href");
 	    return str_replace($bad,"",$string);
 		}
 		
 		$email_message .= "First Name: ".clean_string($first_name)."\n";
 		$email_message .= "Last Name: ".clean_string($last_name)."\n";
 		$email_message .= "Email: ".clean_string($email_from)."\n";
 		$email_message .= "Telephone: ".clean_string($telephone)."\n";
        $email_message .= "Comments: ".clean_string($comments)."\n";

        $email_subject .= "New message from: ".clean_string($first_name)." ".clean_string($last_name);

		$sendgrid = new SendGrid($api_user, $api_key);
		$sendemail = new SendGrid\Email();

		$sendemail->addTo('family2family.email@gmail.com')->
		          setFrom($email_from)->
		          setSubject($email_subject)->
		          setText($email_message)->
		          setHtml('<strong>'.$email_message.'</strong>');

		echo "Sending message \n";          
		$response = $sendgrid->send($sendemail);

		print_r("Your message has been sent ");


?>

</pre>
