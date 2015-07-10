<?php

$dbopts = parse_url(getenv('DATABASE_URL'));

$dsn = 'pgsql:'
    . 'host='.$dbopts["host"].';'
    . 'dbname='.ltrim($dbopts["path"],'/').';'
    . 'user='.$dbopts["user"].';'
    . 'port='.$dbopts["port"].';'
    . 'sslmode=require;'
    . 'password='.$dbopts["pass"];
try
{
	$db = new PDO($dsn);
}
catch(PDOException $pe)
{
	die('Connection error, because: ' .$pe->getMessage());
}

?>
<html>
<head></head>
<body><h1><?php echo "hello world from php!!!"; ?></h1></body>
</html>

<?php

$db=null;

?>