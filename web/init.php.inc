<?php 

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
}
catch(PDOException $pe)
{
	die('Connection error, because: ' .$pe->getMessage());
}

// Functions
function random_lipsum($amount = 1, $what = 'paras', $start = 0) {
	return (string) simplexml_load_file("http://www.lipsum.com/feed/xml?amount=$amount&what=$what&start=$start")->lipsum;
}

//Classes
abstract class ServiceType
{
    const Stroller = 0;
    const CarSeat = 1;
    const House = 2;
    const Babysit = 3;
    
    static public function GetTypes() { 
    	return [
    		ServiceType::Stroller => 'Stroller',
    		ServiceType::CarSeat => 'Car Seat',
    		ServiceType::House => 'House',
    		ServiceType::Babysit => 'Babysitting'
    	];
    }
}

?>
