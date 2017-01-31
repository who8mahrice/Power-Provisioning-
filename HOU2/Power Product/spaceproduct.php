<?php

include 'connect.inc.php';
require_once 'navi.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

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
    <th colspan="2" align="center">New Space</th>
    <form action = 'spaceproduct.php' method='post'>
    <tr><td>sID </td>
    <td><input type='text' name='space_sID'></td></tr>
    <tr><td>cID </td>
    <td><input type='text' name='cID'></td></tr>
    <tr><td>Space Type </td>
    <td>
    <select name="spaceType" size="1">
        echo'   <option value="">-SELECT-</option>  ';
        echo'   <option value="Cage">Cage</option>';
        echo'   <option value="Shared">Shared</option>';
    </select>
    </td></tr>
    <tr><td>MAU</td>
    <td><input type='text' name='mau'></td></tr>
    <tr><td>Location </td>
    <td><input type='text' name='location'></td></tr>
    <tr><td># of Rows </td>
    <td><input type='text' name='row'></td></tr>
    <tr><td># of Cabs </td>
    <td><input type='text' name='cab'></td></tr>
    <tr><td><input type="submit" value="Add Space" name="addSpace" ></td></tr>
</form>
</div>
</body>

_END;

if (isset($_POST['space_sID']) && isset($_POST['cID']) && isset($_POST['spaceType']) && isset($_POST['location']) && isset($_POST['mau']) && isset($_POST['row']) && isset($_POST['cab']) && isset($_POST['addSpace'])) {

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

}


//if(isset($_POST['']))
?>
