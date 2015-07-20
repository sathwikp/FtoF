<?php require 'init.php.inc';?>

<?php
require('../vendor/autoload.php');
header('Content-Type: application/json; Charset=UTF-8');
try {
	// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
	$s3 = Aws\S3\S3Client::factory(['signature' => 'v4','region'=>'eu-central-1']);
	//$s3Client = S3Client::factory(array('key'=>YOUR_AWS_KEY, 'secret'=>YOUR_AWS_SECRET, 'signature' => 'v4', 'region'=>'eu-central-1'));
	$bucket = getenv('S3_BUCKET');
	if (!$bucket)
		throw new Exception('No "S3_BUCKET" config var in found in env!');

	
		
		if (!isset($_SERVER['HTTP_REFERER']) ||
			(strpos($_SERVER['HTTP_REFERER'], 'localhost') === FALSE &&
			strpos($_SERVER['HTTP_REFERER'], 'ftof.herokuapp.com') === FALSE &&
			strpos($_SERVER['HTTP_REFERER'], 'family2family.eu') === FALSE)) {
	        throw new Exception( "Technical error: not allowed to perform this action");	
		}
		
		
		
		if (!$user->is_loggedin()) {
	        throw new Exception("Technical error: unknown profile id");	
		}

		$profile_id = intval($_SESSION['user_session']);
		
		if (!isset($_POST['id'])) {
	        throw new Exception("Technical error: unknown field id");	
		}
		
		$id = ($_POST['id']);


	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['value']) && $_FILES['value']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['value']['tmp_name'])) {

	$fileInfo = pathinfo($_FILES["value"]["name"]);
	
    $maxsize    = 2097152;
    $acceptable = array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    );

    if(($_FILES['value']['size'] >= $maxsize) || ($_FILES["value"]["size"] == 0)) {
        throw new Exception( 'File too large. File must be less than 2 megabytes.');
    }

    if(!in_array($_FILES['value']['type'], $acceptable) && (!empty($_FILES["value"]["type"]))) {
        throw new Exception( 'Invalid file type. Only JPG, GIF and PNG types are accepted.');
    }


	$upload = $s3->upload($bucket, uniqid() . '.' . $fileInfo['extension'],
				fopen($_FILES['value']['tmp_name'], 'rb'), 'public-read');
	
	$url = htmlspecialchars($upload->get('ObjectURL'));
	
	
		switch ($id) {
			case 'picture':
			{
				$sql = 	"update profile set picture = :fval, big_picture = :fval "
					. "where id = :pid ";

				$qparams = [
					 		//":fid" => $id,
					 		":fval" => $url,
					 		":pid" => $profile_id,
					 	];
	
				$q = $db->prepare($sql);
				$q->execute($qparams);	
			}
			
			break;
			
			case 'avatar':
			{
				$sql = 	"update profile set avatar = :fval "
					. "where id = :pid ";

				$qparams = [
					 		//":fid" => $id,
					 		":fval" => $url,
					 		":pid" => $profile_id,
					 	];
	
				$q = $db->prepare($sql);
				$q->execute($qparams);	
			}
			
			break;
			
			default: 
		}		

	
	
	echo json_encode(
		[
			'success' => TRUE,
			'url' => $url,
		]
	);

	}
	else
	{
		throw new UploadException($_FILES['value']['error']);
	}
} catch (Exception $e) {
	echo json_encode(
		[
			'success' => FALSE,
			'error' => $e->getMessage()
		]
	);	
}
?>

<?php require 'destroy.php.inc';?>
