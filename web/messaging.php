<?php require 'init.php.inc'; ?>
<pre>
<?php

$sendgrid = new SendGrid($api_user, $api_key);
$email    = new SendGrid\Email();

$message->addTo('daria.dubin@googlemail.com')->
          setFrom('some@email.com')->
          setSubject('My test message')->
          setText('Hello World!')->
          setHtml('<strong>Hello World!</strong>');
$response = $sendgrid->send($message);

print_r($response);

?>
</pre>
