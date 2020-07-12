<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require './src/rb.php';
require './src/Server.php';
require './src/ServerList.php';

/*
//PDO connection  **NOT USED
$servername = "localhost";
$username = "ADMIN";
$password = "!1q2w3e4r";

try {
  $conn = new PDO("mysql:host=$servername;dbname=SEEDBOX_OLTP", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
//close connection
$conn = null;
*/


//ORM connection
R::setup( 'mysql:host=localhost;dbname=SEEDBOX_OLTP',
        'ADMIN', '!1q2w3e4r' );


$tables = R::inspect();
foreach ($tables as &$table) {
    printf($table.'<br>');
}
unset($table); // break the reference with the last element


$privileges = R::getAll( 'SELECT * FROM PRIVILEGES' );
$users = R::getAll( 'SELECT * FROM USERS' );
$servers = R::getAll( 'SELECT * FROM SERVERS' );
$eventLog = R::getAll( 'SELECT * FROM EVENTS' );

R::close(); //closes ORM connection



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Seedbox Servers</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
</head>

<body>
<?php
$inventory = new ServerList();
$inventory->serverAdd(new Server('Markao 01'));
$inventory->serverAdd(new Server('Markao 02'));
$inventory->serverRemove('Markao 01');

$inventory->getServerList();


foreach ($servers as $server) {
    $inventory->serverAdd(new Server($server['SERVER_NAME']));
}
unset($server); // break the reference with the last element
print_r($inventory);
$inventory->getServerList();
printf('<br>'.PHP_EOL);
foreach ($inventory->server_inventory as $server) {
	$server->startServer();
}
$inventory->getServerList();
printf('<br>'.PHP_EOL);
unset($server); // break the reference with the last element

foreach ($inventory->server_inventory as $server) {
	$server->stopServer();
}
unset($server); // break the reference with the last element
$inventory->getServerList();
    
?>	
</body>

</html>
