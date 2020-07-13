<?php
//some draft basic html interface for testing purposes
// to do: 	-interactive user interface (front-end)
//			- Data Access Object (DAO) to load and save data to the database

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
//the database connection is secured with SSL for remote clients. 
//Keys, certs ans CAs for the server and clients are found in /src/ssl/mysql dir.
//The connection will be refused if ssl is not properly configured on clients

//test connection to database via ORM
/*$tables = R::inspect();
foreach ($tables as &$table) {
    printf($table.'<br>');
}
unset($table); // break the reference with the last element
*/

//load from ORM
$privileges = R::getAll( 'SELECT * FROM PRIVILEGES' ); // not used
$users = R::getAll( 'SELECT * FROM USERS' ); //not used
$servers = R::getAll( 'SELECT * FROM SERVERS' );
$eventLog = R::getAll( 'SELECT * FROM EVENTS' );// not used





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

//as there's no interactice user interface, the user interactions are shown here in the index.php code.
$inventory->serverAdd(new Server('MyTestServer 01')); //user adds server (stopped by default on create)
$inventory->serverAdd(new Server('MyTestServer 02','START')); //user adds another server
$inventory->serverRemove('MyTestServer 01'); //user removes one server (by name)

$inventory->getServerList(); //user lists existing servers


foreach ($servers as $server) {
    $inventory->serverAdd(new Server($server['SERVER_NAME'],$server['SERVER_RUNNING_STATUS'])); //System loads all servers from the database (via ORM)
}
unset($server); // break the reference with the last element

$inventory->getServerList(); //user lists existing servers
printf('<br>'.PHP_EOL);  //<br> for the http interface -- PHP_EOL for the console interface
foreach ($inventory->server_inventory as $server) {
	$server->startServer(); // user sending start signal to all servers
}
$inventory->getServerList();
printf('<br>'.PHP_EOL);
unset($server); // break the reference with the last element

foreach ($inventory->server_inventory as $server) {
	$server->stopServer(); //user sending stop signal to all servers
}
unset($server); // break the reference with the last element

$inventory->getServerList(); //user listing servers

//saving back to ORM ---> database

R::exec('DELETE FROM SERVERS;');
foreach ($inventory->server_inventory as $server) {
	$s_name = $server->getServerName(); // 
	$s_status = $server->getServerStatus();
	R::exec('insert into SERVERS (SERVER_NAME, SERVER_RUNNING_STATUS) values("'.$s_name.'", "'.$s_status.'");');
}

R::close(); //closes ORM connection
    
?>	
</body>

</html>
