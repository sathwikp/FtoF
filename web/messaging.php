<?php require 'init.php.inc'; ?>

<?php require '../vendor/autoload.php'; ?>

<?php

function sanitize($input) {
    return htmlspecialchars(trim($input));
}

		header('Content-Type: application/json; Charset=UTF-8');

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
		
		if (!isset($_POST['id']) ||
			!(intval($_POST['id']) > 0)) {
	        $error_message[] = "Technical error: unknown profile id";	
	        goto theExit;	
		}
		
		$id = intval($_POST['id']);
		
		$services = array_map("intval",preg_grep_keys("/service__\d+/",$_POST));
		
		if (!count($services)>0) {
			$error_message[] = "You should select at least one service";	
	        goto theExit;	
		}
		
		$qparams = [];
		$sql = 	"select p.name, p.email, service_type, period, price_fix, price_per_day, service_desc "
		. "from offered_service s, profile p "
		. "where s.profile_id = :id "
		. "and s.profile_id = p.id "
		. "and available = TRUE "
		. "and s.service_type in (".implode($services,', ').")";

		$qparams[":id"] = $id;
	
		$q = $db->prepare($sql);
		$q->execute($qparams);	
		$servicelist=[];
		$overall_price=0;
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			$dest_name = $row['name'];
			$dest_email = $row['email'];
			$datespair = parse_and_validate_dates($_POST['arrival__'.$row['service_type']], $_POST['departure__'.$row['service_type']]);
			if (!$datespair) {
				$error_message[] = "Invalid departure or arrival dates provided";	
	        	goto theExit;	
			}
			$service_tot_price = ($datespair[1]->diff($datespair[0],true)->days+1) * $row['price_per_day'];
			$overall_price += $service_tot_price;
			$servicelist[] = [
				'type' => $row['service_type'],
				'name' => ServiceType::GetTypes()[$row['service_type']],
				'price_per_day' => $row['price_per_day'],
				'datespair' => $datespair,
				'tot_price' => $service_tot_price
			];
		}
		
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
 	    	$error_message[] = 'The Name you entered does not appear to be valid.';
 		}
 
  		//if(strlen($first_name) == 0 || strlen($first_name)>150) {
 		//    $error_message[] = 'The Last Name you entered does not appear to be valid.';
		//}
 
  		if(strlen($comments) > 50000) {
		    $error_message[] = 'The Comments you entered do not appear to be valid.';
		}
 
theExit:
  		if(count($error_message) > 0) {
 		    echo json_encode([
 		    	'success' => FALSE,
 		    	'error' => $error_message
 		    ]);

		} else {

// =======================================================================================	
// ========================== CONFIRMATION EMAIL TO THE	BUYER ============================
// =======================================================================================		
			$email_subject = "Family2Family confirmation de commande";
			
			$email_message = "Bonjour ".$first_name.",\n\n"

			."Ceci est un message de confirmation.\n\n"

			."Nous avons bien transmis votre commande à ".$dest_name.", incluant vos coordonnées.\n" 
			."La famille devrait vous contacter directement pour arranger l'échange.\n\n"

			."Récapitulatif de votre message :\n";
			
			foreach ($servicelist as $service) {
				$email_message .= "   - ".$service['name']." - ".$service['datespair'][0]->format('d-m-Y')." au ".$service['datespair'][1]->format('d-m-Y')." - ".round($service['tot_price'],2)."€\n";
			}
			$email_message .= "\nTotal de la commande : ".round($overall_price,2)."€\n\n";

			if (strlen($comments)>0) {
				$email_message .= "Commentaires ajoutés \n" . nl2br($comments) . "\n\n";
			}


			$email_message .=  "\nMerci de votre confiance. Si vous avez des questions ou que vous rencontrez une difficulté, n'hésitez pas à nous contacter.\n\n"

			."Family@Family\n"
			."\"Vous faciliter le voyage en famille et faire des rencontres inoubliables\"\n\n"

			."Facebook: https://www.facebook.com/pages/Family2Family/820471384696590"
			."Twitter: https://twitter.com/Family_Family2";


			
			$html_message = "<html><head/><body>"
			."<p><img src='https://ftof.herokuapp.com/img/mail_header.png' /></p>"
			
			."<p>Bonjour ".$first_name.",</p>"

			."<p>Ceci est un message de confirmation.</p>"

			."<p>Nous avons bien transmis votre commande à ".$dest_name.", incluant vos coordonnées.<br />" 
			."La famille devrait vous contacter directement pour arranger l'échange.<p>"

			."<p>Récapitulatif de votre message :</p><ul>";
			
			foreach ($servicelist as $service) {
				$html_message .= "<li>".$service['name']." - ".$service['datespair'][0]->format('d-m-Y')." au ".$service['datespair'][1]->format('d-m-Y')." - ".round($service['tot_price'],2)."€</li>";
			}
			$html_message .= "</ul><p>Total de la commande : ".round($overall_price,2)."€</p>";

			if (strlen($comments)>0) {
				$html_message .= "<p>Commentaires ajoutés: <br/>" . $comments . "</p>";
			}


			$html_message .=  "<br/><p>Merci de votre confiance. Si vous avez des questions ou que vous rencontrez une difficulté, n'hésitez pas à nous contacter.<p>"

			."<p>Family@Family</br>"
			."\"Vous faciliter le voyage en famille et faire des rencontres inoubliables\"</p>"

			."<a href='https://www.facebook.com/pages/Family2Family/820471384696590'>Family2Family Facebook</a><br/>"
			."<a href='https://twitter.com/Family_Family2'>@Family_Family2 Twitter</a>"
			."<p><img src='https://ftof.herokuapp.com/img/mail_footer_logo.jpg' /></p>"
			."</body></html>";


			$sendgrid = new SendGrid($api_user, $api_key);
			
			$sendemail = new SendGrid\Email();

			$sendemail->addTo($email_from)->
					  addBcc('family2family.email@gmail.com')->
					  setFrom('family2family.email@gmail.com')->
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