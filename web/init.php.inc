<?php 

session_start();

// Database connection
$dbopts = parse_url(getenv('DATABASE_URL'));

$dsn = 'pgsql:'
    . 'host='.$dbopts["host"].';'
    . 'dbname='.ltrim($dbopts["path"],'/').';'
    . 'user='.$dbopts["user"].';'
    . 'port='.$dbopts["port"].';';
//    . 'sslmode=require;'
if (array_key_exists("pass",$dbopts))
    $dsn .= 'password='.$dbopts["pass"];
try
{
	$db = new PDO($dsn);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $pe)
{
	die('Connection error, because: ' .$pe->getMessage());
}

$api_user='app38733322@heroku.com';
$api_key='uyw72sji2997';
// Functions
function random_lipsum($amount = 1, $what = 'paras', $start = 0) {
	return (string) simplexml_load_file("http://www.lipsum.com/feed/xml?amount=$amount&what=$what&start=$start")->lipsum;
}

function preg_grep_keys($pattern, $input, $flags = 0) {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
}

function redirect_to_home() {
	header( 'Location: ./index.php' ) ;
	exit();
}

define ("__DATEFORMAT", 'm/d/Y');
date_default_timezone_set('Europe/Paris');
function parse_and_validate_dates($arrival, $departure){
	$dep_date = DateTime::createFromFormat(__DATEFORMAT, $departure);
	$arr_date = DateTime::createFromFormat(__DATEFORMAT, $arrival);
	
	if ($dep_date == FALSE || $arr_date == FALSE)
	{
		return FALSE;
	}
	
	$now = new DateTime();
	
	if ($arr_date > $dep_date) {
		return FALSE;
	}

	if ($dep_date < $now || $arr_date < $now) {
		return FALSE;
	}
	
	return [$arr_date, $dep_date];
}


$_SESSION['lang'] = 'fr';

if (isset($_GET['lang'])) {
	$lang = strtolower(trim($_GET['lang']));
	if ($lang == 'en' || $lang == 'fr') {
		$_SESSION['lang'] = $lang;
	}
}

function localization($en, $fr) {
	switch ($_SESSION['lang']) {
		case 'en':
			return $en;
		case 'fr':
			return $fr;
	}
}

//Classes
abstract class ServiceType
{
    const Stroller = 0;
	const CarSeat = 1;
	const BabyChair = 2;
	const Toys = 3; // / Books
    const Bike = 4; //Bike / Roller
	const FamilyCar = 5;
	const House = 6;
    const Transfer = 7;
    const Babysit = 8; 
    const Activity = 9;
    const Teaching = 10;
    const Others = 11;
    
    static public function GetTypes() { 
    	return [
    		ServiceType::Stroller => localization("'Stroller'","'Poussette'"),
    		ServiceType::Bike => localization("'Bike / Rollers'", "'Vélo / Rollers'"),
    		ServiceType::Transfer => localization("'Airport Transfer'", "'Transfert aéroport'"),
    		ServiceType::Toys => localization("'Baby Toys / Books'", "'Jouets / Livres'"),
			ServiceType::CarSeat => localization("'Baby Car Seat'", "'Siège auto'"),
			ServiceType::BabyChair => localization("'Baby Chair'", "'Chaise haute'"),
			ServiceType::FamilyCar => localization("'Family Car'"", "'Voiture familiale'"),
			ServiceType::House => localization("'Family-friendly House'", "'Maison familiale'"),
			ServiceType::Babysit => localization("'Baby Sitting'", "'Baby Sitting'"),
			ServiceType::Activity => localization("'Children Activity'", "'Activités enfantines'"),
			ServiceType::Teaching => localization("'Teaching Lessons'", "'Cours particuliers'"),
			ServiceType::Others => localization("'Others'", "'Autres'"),
    	];
    }
    
    static public function GetPics() { 
    	return [
    		ServiceType::Stroller => 'img/Baby_trolley.png',
    		ServiceType::Bike => 'img/Bike_icon.png',
    		ServiceType::Transfer => 'img/Taxi_icon.png',
    		ServiceType::Toys => 'img/Teddy_bear_icon.png',
    		
			ServiceType::CarSeat => 'img/car_seat.png',
			ServiceType::BabyChair => 'img/baby_chair.png',
			ServiceType::FamilyCar => 'img/family_car.png',
			ServiceType::House => 'img/house.png',
			ServiceType::Babysit => 'img/babysit.png',
			ServiceType::Activity => 'img/activity.png',
			ServiceType::Teaching => 'img/teaching.png',
			ServiceType::Others => 'img/others.png',
    	];
    }
}

include_once 'class.user.php';
$user = new USER($db);

?>
