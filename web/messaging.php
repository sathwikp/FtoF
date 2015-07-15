<?php require 'init.php.inc'; ?>

<?php require '../vendor/autoload.php'; ?>

<pre>

<?php

try {
	echo "instantiating SendGrid \n";
	$sendgrid = new SendGrid($api_user, $api_key);

	echo "instantiating Email \n";
	$email    = new SendGrid\Email();

/*	if(isset($_POST['email'])) {

		function died($error) {
		    // your error code can go here
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
		$email->addTo('daria.dubin@googlemail.com')->
		          setFrom($email_from)->
		          setSubject($email_subject)->
		          setText($email_message)->
		          setHtml('<strong'.$email_message.'</strong>');

		echo "Sending message \n";          
		$response = $sendgrid->send($email);

		print_r($response);
	}
*/

} catch (Exception $e) {
	print_r($e);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<form name="contactform" method="post" action="send_form_email.php">
<table width="450px">
<tr>
 <td valign="top">
  <label for="first_name">First Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="last_name">Last Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="last_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="email">Email Address *</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="telephone">Telephone Number</label>
 </td>
 <td valign="top">
  <input  type="text" name="telephone" maxlength="30" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="comments">Comments *</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Submit">   <a href="http://www.freecontactform.com/email_form.php">Email Form</a>
 </td>
</tr>
</table>
</form>
</html>
</pre>
