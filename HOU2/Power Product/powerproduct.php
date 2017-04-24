
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
//include 'css.css';
require_once 'navi.php';


$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);
?>

<html>
 <head>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
 </head>
 <style>

 div.secondaryPower {
 



 }

 .secondaryPower table {

 }



 div.primaryPower {

    
 }

 </style>
    <body>
      <section id="content">
        <div><h2> Add power </h2></div>

        <div class="primaryPower">
            <table border="0" cellpadding="10" cellspacing="5" bgcolor="#eeeeee">
                <th colspan="2" align="left">Primary Power</th>
                <form action = 'powerproduct.php' method='post'>
                <tr><td>cID </td>
                <td><input type='text' name='cid'></td></tr>
                <tr><td>sID </td>
                <td><input type='text' name='sid'></td></tr>
                <!--   </tr>
                -->
                <tr><td>Panel Name</td>
                <td>
                    <select name="panelName" size="1">
                        <option value="">-SELECT-</option> 
                        <option value="1A-P1-1">1A-P1-1</option>
                        <option value="1A-P1-2">1A-P1-2</option>
                        <option value="1A-P1-3">1A-P1-3</option>
                        <option value="1A-P1-4">1A-P1-4</option>
                        <option value="1A-P1-5">1A-P1-5</option>
                        <option value="1A-P1-6">1A-P1-6</option>
                        <option value="1A-P1-7">1A-P1-7</option>
                        <option value="1A-P1-8">1A-P1-8</option>
                        <option value="1A-P1-9">1A-P1-9</option>
                        <option value="1A-P1-10">1A-P1-10</option>
                        <option value="1A-P2-1">1A-P2-1</option>
                        <option value="1A-P2-2">1A-P2-2</option>
                        <option value="1A-P2-3">1A-P2-3</option>
                        <option value="1A-P2-4">1A-P2-4</option>
                        <option value="1A-P2-5">1A-P2-5</option>
                        <option value="1A-P2-6">1A-P2-6</option>
                        <option value="1A-P2-7">1A-P2-7</option>
                        <option value="1A-P2-8">1A-P2-8</option>
                        <option value="1A-P2-9">1A-P2-9</option>
                        <option value="1A-P2-10">1A-P2-10</option>
                        <option value="1A-P3-1">1A-P3-1</option>
                        <option value="1A-P3-2">1A-P3-2</option>
                        <option value="1A-P3-3">1A-P3-3</option>
                        <option value="1A-P3-4">1A-P3-4</option>
                        <option value="1A-P3-5">1A-P3-5</option>
                        <option value="1A-P3-6">1A-P3-6</option>
                        <option value="1A-P3-7">1A-P3-7</option>
                        <option value="1A-P3-8">1A-P3-8</option>
                        <option value="1A-P3-9">1A-P3-9</option>
                        <option value="1A-P310">1A-P3-10</option>
                        <option value="1A-P4-1">1A-P4-1</option>
                        <option value="1A-P4-2">1A-P4-2</option>
                        <option value="1A-P4-3">1A-P4-3</option>
                        <option value="1A-P4-4">1A-P4-4</option>
                        <option value="1A-P4-5">1A-P4-5</option>
                        <option value="1A-P4-6">1A-P4-6</option>
                        <option value="1A-P4-7">1A-P4-7</option>
                        <option value="1A-P4-8">1A-P4-8</option>
                        <option value="1A-P4-9">1A-P4-9</option>
                        <option value="1A-P4-10">1A-P4-10</option>
                    </select>
                </td>
                </tr>
                <tr><td>Power Type </td>
                <td>
                    <select name="powerType" size="1">
                        <option value="">-SELECT-</option> 
                        <option value="20/120">20/120</option>
                        <option value="30/120">30/120</option>
                        <option value="20/208">20/208</option>
                        <option value="30/208">30/208</option>
                        <option value="50/208">50/208</option>
                        <option value="60/208">60/208</option>
                        echo'   <option value="30/208-3ph">30/208-3ph</option>';
                        echo'   <option value="50/208-3ph">50/208-3ph</option>';
                        echo'   <option value="60/208-3ph">60/208-3ph</option>';
                    </select>
                </td></tr>
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
                </table>
            </div>

        <div class="secondaryPower">
            <table border="0" cellpadding="10" cellspacing="5" bgcolor="#eeeeee">
                <th colspan="2" align="left">Secondary Power</th>
                <form action = 'powerproduct.php' method='post'>
                <tr><td>cID </td>
                <td><input type='text' name='cid'></td></tr>
                <tr><td>sID </td>
                <td><input type='text' name='sid'></td></tr>
                <!--   </tr>
                -->
                <tr><td>Panel Name</td>
                <td>
                    <select name="panelName" size="1">
                        <option value="">-SELECT-</option> 
                        <option value="1A-P1-1">1A-P1-1</option>
                        <option value="1A-P1-2">1A-P1-2</option>
                        <option value="1A-P1-3">1A-P1-3</option>
                        <option value="1A-P1-4">1A-P1-4</option>
                        <option value="1A-P1-5">1A-P1-5</option>
                        <option value="1A-P1-6">1A-P1-6</option>
                        <option value="1A-P1-7">1A-P1-7</option>
                        <option value="1A-P1-8">1A-P1-8</option>
                        <option value="1A-P1-9">1A-P1-9</option>
                        <option value="1A-P1-10">1A-P1-10</option>
                        <option value="1A-P2-1">1A-P2-1</option>
                        <option value="1A-P2-2">1A-P2-2</option>
                        <option value="1A-P2-3">1A-P2-3</option>
                        <option value="1A-P2-4">1A-P2-4</option>
                        <option value="1A-P2-5">1A-P2-5</option>
                        <option value="1A-P2-6">1A-P2-6</option>
                        <option value="1A-P2-7">1A-P2-7</option>
                        <option value="1A-P2-8">1A-P2-8</option>
                        <option value="1A-P2-9">1A-P2-9</option>
                        <option value="1A-P2-10">1A-P2-10</option>
                        <option value="1A-P3-1">1A-P3-1</option>
                        <option value="1A-P3-2">1A-P3-2</option>
                        <option value="1A-P3-3">1A-P3-3</option>
                        <option value="1A-P3-4">1A-P3-4</option>
                        <option value="1A-P3-5">1A-P3-5</option>
                        <option value="1A-P3-6">1A-P3-6</option>
                        <option value="1A-P3-7">1A-P3-7</option>
                        <option value="1A-P3-8">1A-P3-8</option>
                        <option value="1A-P3-9">1A-P3-9</option>
                        <option value="1A-P310">1A-P3-10</option>
                        <option value="1A-P4-1">1A-P4-1</option>
                        <option value="1A-P4-2">1A-P4-2</option>
                        <option value="1A-P4-3">1A-P4-3</option>
                        <option value="1A-P4-4">1A-P4-4</option>
                        <option value="1A-P4-5">1A-P4-5</option>
                        <option value="1A-P4-6">1A-P4-6</option>
                        <option value="1A-P4-7">1A-P4-7</option>
                        <option value="1A-P4-8">1A-P4-8</option>
                        <option value="1A-P4-9">1A-P4-9</option>
                        <option value="1A-P4-10">1A-P4-10</option>
                    </select>
                </td>
                </tr>
                <tr><td>Power Type </td>
                <td>
                    <select name="powerType" size="1">
                        <option value="">-SELECT-</option> 
                        <option value="20/120">20/120</option>
                        <option value="30/120">30/120</option>
                        <option value="20/208">20/208</option>
                        <option value="30/208">30/208</option>
                        <option value="50/208">50/208</option>
                        <option value="60/208">60/208</option>
                        echo'   <option value="30/208-3ph">30/208-3ph</option>';
                        echo'   <option value="50/208-3ph">50/208-3ph</option>';
                        echo'   <option value="60/208-3ph">60/208-3ph</option>';
                    </select>
                </td></tr>
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
                </table>
            </div>            
      </section>
    </body>
</html>

<!--
For power

<tr><td>Space Type </td>
    <td>
    <select name="powerType" size="1">
        echo'   <option value="">-SELECT-</option>  ';
        echo'   <option value="20/120">20/120</option>';
        echo'   <option value="30/120">30/120</option>';
        echo'   <option value="20/208">20/208</option>';
        echo'   <option value="30/208">30/208</option>';
        echo'   <option value="50/208">50/208</option>';
        echo'   <option value="60/208">60/208</option>';
        echo'   <option value="30/208-3ph">30/208-3ph</option>';
        echo'   <option value="50/208-3ph">50/208-3ph</option>';
        echo'   <option value="60/208-3ph">60/208-3ph</option>';
    </select>
    </td></tr>
--> 





