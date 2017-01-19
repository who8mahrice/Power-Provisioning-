<?php

include 'connect.inc.php';
require_once 'navi.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//checks connection
if ($connection->connect_error) die($connection->connect_error);

echo <<<_END
<div class=content>
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
    <th colspan="2" align="center">New Customer</th>
    <form action = 'new_customer.php' method='post'>
    <tr><td>cID </td>
    <td><input type='text' name='cID'></td></tr>
    <tr><td>Customer Name </td>
    <td><input type='text' name='customerName'></td></tr>
    <tr><td><input type="submit" value="Add Customer" name="newCustomer"></td></tr>
</form>
</div>
</body>

_END;

if(isset($_POST['cID']) && isset($_POST['customerName']) && isset($_POST['newCustomer'])){

    //Prepare and bind
    $stmt = $connection->prepare("INSERT INTO customer(cID,customerName) VALUES(?,?)");
    $stmt->bind_param('is', $_POST['cID'],$_POST['customerName']);
    //Parameters are already set, execute
    $stmt->execute();

    $stmt = $connection->prepare("SELECT cID, customerName FROM customer ");
    $stmt->execute();
    $stmt->bind_result($cID,$customerName);
    //fetch values
    while ($stmt->fetch()) {
    echo "$cID $customerName"."<br>";
    }


    //close statement
    $stmt->close();
    
}

    $connection->close();

//To prevent SQL injections
/*
function get_post($connection, $var)
    {
            return $connection->real_escape_string($_POST['$var']);
    }
*/

?>
