<?php

/*
Adds new power product to the database.

<?php
// BAD CODE:
$mysqli->multi_query(" Many SQL queries ; "); // OK
$mysqli->query(" SQL statement #1 ; ") // not executed!
$mysqli->query(" SQL statement #2 ; ") // not executed!
$mysqli->query(" SQL statement #3 ; ") // not executed!
$mysqli->query(" SQL statement #4 ; ") // not executed!
?>

The only way to do this correctly is:

<?php
// WORKING CODE:
$mysqli->multi_query(" Many SQL queries ; "); // OK
while ($mysqli->next_result()) {;} // flush multi_queries
$mysqli->query(" SQL statement #1 ; ") // now executed!
$mysqli->query(" SQL statement #2 ; ") // now executed!
$mysqli->query(" SQL statement #3 ; ") // now executed!
$mysqli->query(" SQL statement #4 ; ") // now executed!
?>

*/

include 'connect.inc.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);

echo <<<_END
<style>
	table{
		border: 1px solid black;
	}
	
	th {
		text-decoration: underline;
	}
</style>
<body>
<table border="0" cellpadding="10" cellspacing="5" bgcolor="#eeeeee">
	<th colspan="2" align="left">Add Power Product</th>
	<form action = 'powerproduct.php' method='post'>
	<tr><td>cID </td>
	<td><input type='text' name='cid'></td></tr>
	<tr><td>sID </td>
	<td><input type='text' name='sid'></td></tr>
	<tr><td>Product Name </td>
	<td><input type='text' name='productNane'></td></tr>
	<tr><td>Cage </td>
	<td><input type='text' name='cage'></td></tr>
	<tr><td>Row </td>
	<td><input type='text' name='row'></td></tr>
	<tr><td>Cab </td>
	<td><input type='text' name='cab'></td></tr>
	<tr><td>MAC </td>
	<td><input type='text' name='mac'></td></tr>
	<tr><td>MAU </td>
	<td><input type='text' name='mau'></td></tr>
	<tr><td><input type="submit" value="Add product"></td></tr>
</form>
</body>

_END;

//if (isset($_POST['sid']) && )	









?>
