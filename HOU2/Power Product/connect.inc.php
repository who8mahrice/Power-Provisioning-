<?PHP

//uses login.php credentials to log into the DB and test if it is connected.

require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
echo 'Connected to host: '.$db_hostname;
echo '<br>'.'<br>'.'<br>';
if(!$db_server) die("Unable to connect to MySQL: ".mysql_error());

?>
