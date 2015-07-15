<?php require 'init.php.inc'; ?>

<?php require '../vendor/autoload.php'; ?>

<pre>

<?php
try {
echo "instantiating SendGrid \n";
$sendgrid = new SendGrid($api_user, $api_key);

echo "instantiating Email \n";
$email    = new SendGrid\Email();


echo "instantiating message \n";
$email->addTo('daria.dubin@googlemail.com')->
          setFrom('daria.dubin@googlemail.com')->
          setSubject('My test message')->
          setText('Hello World!')->
          setHtml('<strong>Hello World!</strong>');

echo "Sending message \n";          
$response = $sendgrid->send($email);

print_r($response);
} catch (Exception $e) {
	print_r($e);
}
?>
</pre>
