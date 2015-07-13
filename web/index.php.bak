<?php

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

?>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Bootstrap | Welcome</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
 <h1>Finally up and running!!</h1>
  </body>
</html>


<?php

$db=null;

?>
