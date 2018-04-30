<?php
include 'connect.inc.php';


$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);


if(isset($_POST['cID']) && isset($_POST['customerName']) && isset($_POST['newCustomer'])){

    //Prepare and bind
    $stmt = $connection->prepare("INSERT INTO customer(cID,name) VALUES(?,?)");
    $stmt->bind_param('is', $_POST['cID'],$_POST['customerName']);
    //Parameters are already set, execute
    $stmt->execute();

    //This section here will fetch the last id (What we just entered) of the table. 
    $stmt = $connection->prepare("SELECT cID, name FROM customer ORDER BY ID DESC LIMIT 1");
    $stmt->execute();
    $stmt->bind_result($cID,$customerName);
    //fetch values
    while ($stmt->fetch()) {
    //echo "$cID $customerName"."<br>";
    printf("The following was entered to the Customer Table [%s] %s",$cID,$customerName);

    }

/*  //This section querys the whole customer table 
    $stmt = $connection->prepare("SELECT cID, customerName FROM customer ");
    $stmt->execute();
    $stmt->bind_result($cID,$customerName);
    //fetch values
    while ($stmt->fetch()) {
    echo "$cID $customerName"."<br>";0
    }
*/

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