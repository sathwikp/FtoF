<?php require 'init.php.inc'; ?>

<?php require '../vendor/autoload.php'; ?>

<pre>

<?php

try {
	echo "instantiating SendGrid \n";
	$sendgrid = new SendGrid($api_user, $api_key);

	echo "instantiating Email \n";
	$sendemail = new SendGrid\Email();

	if(isset($_POST['email'])) {

		function died($error) {
		    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
		    echo "These errors appear below.<br /><br />";
		    echo $error."<br /><br />";
		    echo "Please go back and fix these errors.<br /><br />";
		    die();
		}
		
		if(!isset($_POST['first_name']) ||
	        !isset($_POST['last_name']) ||
	        !isset($_POST['email']) ||
	        !isset($_POST['telephone']) ||
	        !isset($_POST['comments'])) {
	        died('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }
	    echo "email is set \n";
	    /*
	    $first_name = $_POST['first_name']; // required
    	$last_name = $_POST['last_name']; // required
    	$email_from = $_POST['email']; // required
    	$telephone = $_POST['telephone']; // not required
    	$comments = $_POST['comments']; // required
 
    	$error_message = "";
    	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  		if(!preg_match($email_exp,$email_from)) {
   			$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 		}

 		$string_exp = "/^[A-Za-z .'-]+$/";
   		if(!preg_match($string_exp,$first_name)) {
 	    	$error_message .= 'The First Name you entered does not appear to be valid.<br />';
 		}
 
  		if(!preg_match($string_exp,$last_name)) {
 		    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
		}
 
  		if(strlen($comments) < 2) {
		    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
		}
 
  		if(strlen($error_message) > 0) {
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

        $email_subject .= "New message from: ".clean_string($first_name)." ".clean_string($last_name)

		echo "instantiating message \n";
		$sendemail->addTo('daria.dubin@googlemail.com')->
		          setFrom($email_from)->
		          setSubject($email_subject)->
		          setText($email_message)->
		          setHtml('<strong> Hello World! </strong>');

		echo "Sending message \n";          
		$response = $sendgrid->send($sendemail);

		print_r($response);*/
	}


} catch (Exception $e) {
	print_r($e);
}
?>

</pre>
