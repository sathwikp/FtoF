<?php
require('../vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = Aws\S3\S3Client::factory(['signature' => 'v4','region'=>'eu-central-1']);
//$s3Client = S3Client::factory(array('key'=>YOUR_AWS_KEY, 'secret'=>YOUR_AWS_SECRET, 'signature' => 'v4', 'region'=>'eu-central-1'));
$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {

$upload = $s3->upload($bucket, $_FILES['userfile']['name'],
			fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');
echo htmlspecialchars($upload->get('ObjectURL'));
}
?>