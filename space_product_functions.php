<?php
include 'connect.inc.php';
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);

//if (isset($_POST['space_sID']) && isset($_POST['cID']) && isset($_POST['spaceType']) && isset($_POST['location']) && isset($_POST['mau']) && isset($_POST['row']) && isset($_POST['cab']) && isset($_POST['addSpace'])) {

if (isset($_POST['cID']) && isset($_POST['sID']) && isset($_POST['spaceType']) && isset($_POST['location'])) {

    $message = "nothing here";
    $sID=$_POST['sID'];

/* //-------------This section is the old Add Space Product, might add other stuff here later-------------------  
    //prepare and bind
    $stmt = $connection->prepare("INSERT INTO spaceproduct(space_sID, cID, spaceType, mau, location, row, cab) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('iisdsii',$_POST['space_sID'],$_POST['cID'],$_POST['spaceType'],$_POST['mau'],$_POST['location'],$_POST['row'],$_POST['cab']);
    //Parameters are already set, execute
    $stmt->execute();


    $stmt = $connection->prepare("SELECT space_sID, cID, spaceType, mau, location, row, cab FROM spaceproduct");
    $stmt->execute();
    $stmt->bind_result($space_sID,$cID,$spaceType,$mau,$location,$row,$cab);


    //displays all of spaceproducts rows.
    while ($stmt->fetch()) {
    echo "$space_sID, $cID, $spaceType, $mau, $location, $row, $cab"."<br>";
    }
*/

    //prepare and bind
    $stmt = $connection->prepare("INSERT INTO spaceproduct(cID, sID, spaceType, location) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss',$_POST['cID'],$_POST['sID'],$_POST['spaceType'],$_POST['location']);
    //Parameters are already set, execute
    $stmt->execute();


    $stmt = $connection->prepare("SELECT cID, sID, spaceType, location FROM spaceproduct WHERE sID='$sID' ");
    $stmt->execute();
    $stmt->bind_result($cID,$sID,$spaceType,$location);


    //displays all of spaceproducts rows.
    while ($stmt->fetch()) {
    echo "$cID, $sID, $spaceType, $location"."<br>";

/* //-------------Use this section for pop-up alerts only-------------

        echo '<script language="javascript">';
        $message="Customer: "." $cID ".'\r\n'." Service ID: ". "$sID".'\r\n'."Space Type: "." $spaceType ".'\r\n'. "Location: ". "$location";
        echo 'alert(" '.$message.' ")';
        //echo 'alert("message successfully sent")';
        echo '</script>';
*/
    }
    $stmt->close();

}
?>