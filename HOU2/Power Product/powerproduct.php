
<?php

include 'power_product_functions.php';
//include 'primary_add.php';
//include 'connect.inc.php';
//include 'css.css';
//require_once 'navi.php';
require_once 'newNav.php';

//$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);


//checks connection
//if ($connection->connect_error) die($connection->connect_error);




?>

<html>
 <head>
  <link rel="stylesheet" type="text/css" href="css/style.css" />

  <!-- needed for css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>  


  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
  <script type="text/javascript" src="assets/jquery-1.11.3-jquery.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link href="assets/datatables.min.css" rel="stylesheet" type="text/css">



 </head>
    <body>
        
        <div class="container">
    
        <div><h2> Add power </h2></div>
        <div id="dis"></div>
        <div id="content">

           <div class="customer">
                <label for="customerName">Customer:</label>          
                <select  id="customerName" size="1" name="customerName"> 
                <option value="">-SELECT-</option> 

                <?php
                include 'connect.inc.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);


//checks connection
if ($connection->connect_error) die($connection->connect_error);



                $query = "SELECT * FROM spaceproduct";  
                $result = mysqli_query($connection, $query);  
                while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row['cID'] ."'>" .$row['cID']. '</option>';
                }
                ?>
                </select>

                <select disabled="disabled" id="customerLocation" name="customerLocation">
                    <option value="">-SELECT-</option> 
                    <?php
                    $query = "SELECT * FROM spaceproduct";  
                    $result = mysqli_query($connection, $query);  
                    while($row = mysqli_fetch_array($result)){
                        echo "<option rel= ".$row['cID']."  value='".$row['location']."'>" .$row['location']. '</option>';
                    }
                    ?>
                </select>
            </div> <!-- END of Customer -->

        <div class="gui" id="gui" hidden>
        

            <div id="primaryPower" class="primaryPower">

            <form id="myForm" class="myForm" name="myForm" method="POST">
            <table>
             <th colspan="2" align="center">Primary Power</th>
                <tr><td></td><td width="100%"  style="font-size: 12px" align="right">Primary Power Only <input type="checkbox" id="primaryOnly" name="primaryOnly"></td></tr>

          
            

                <td><input type='hidden' id='primaryCid' name='primaryCid' value=""></td></tr>
 
                <tr><td>sID </td>
                  
                <td><input type='text' id='primarySid' name='primarySid'></td></tr>

                <tr><td>Panel Name</td>
                <td width="100%">
                    <select id="category1" size="1" name="primaryRpp" required>
                        <option value="">-SELECT-</option> 
                        <option value="RPP-1A-P1">RPP-1A-P1</option>
                        <option value="RPP-1A-P2">RPP-1A-P2</option>
                        <option value="RPP-1A-P3">RPP-1A-P3</option>
                        <option value="RPP-1A-P4">RPP-1A-P4</option>
                        <option value="RPP-1A-P5">RPP-1A-P5</option>
                        <option value="RPP-1A-P6">RPP-1A-P6</option>
                        <option value="RPP-1A-P7">RPP-1A-P7</option>
                        <option value="RPP-1A-P8">RPP-1A-P8</option>
                        <option value="RPP-1A-P9">RPP-1A-P9</option>
                        <option value="RPP-1A-P10">RPP-1A-P10</option>
                    </select>
<!--                </td>
                
                <td>
-->                
                <select disabled="disabled" id="category2" name="primaryPanel" required>  
                        <option value="">-SELECT-</option> 
                        <option rel="RPP-1A-P1" value="1A-P1-1">1A-P1-1</option>
                        <option rel="RPP-1A-P1" value="1A-P1-2">1A-P1-2</option>
                        <option rel="RPP-1A-P1" value="1A-P1-3">1A-P1-3</option>
                        <option rel="RPP-1A-P1" value="1A-P1-4">1A-P1-4</option>

                        <option rel="RPP-1A-P2" value="1A-P1-5">1A-P1-5</option>
                        <option rel="RPP-1A-P2" value="1A-P1-6">1A-P1-6</option>
                        <option rel="RPP-1A-P2" value="1A-P1-7">1A-P1-7</option>
                        <option rel="RPP-1A-P2" value="1A-P1-8">1A-P1-8</option>

                        <option rel="RPP-1A-P3" value="1A-P1-9">1A-P1-9</option>
                        <option rel="RPP-1A-P3" value="1A-P1-10">1A-P1-10</option>
                        <option rel="RPP-1A-P3" value="1A-P2-1">1A-P2-1</option>
                        <option rel="RPP-1A-P3" value="1A-P2-2">1A-P2-2</option>
                        
                        <option rel="RPP-1A-P4" value="1A-P2-3">1A-P2-3</option>
                        <option rel="RPP-1A-P4" value="1A-P2-4">1A-P2-4</option>
                        <option rel="RPP-1A-P4" value="1A-P2-5">1A-P2-5</option>
                        <option rel="RPP-1A-P4" value="1A-P2-6">1A-P2-6</option>

                        <option rel="RPP-1A-P5" value="1A-P2-7">1A-P2-7</option>
                        <option rel="RPP-1A-P5" value="1A-P2-8">1A-P2-8</option>
                        <option rel="RPP-1A-P5" value="1A-P2-9">1A-P2-9</option>
                        <option rel="RPP-1A-P5" value="1A-P2-10">1A-P2-10</option>

                        <option rel="RPP-1A-P6" value="1A-P3-1">1A-P3-1</option>
                        <option rel="RPP-1A-P6" value="1A-P3-2">1A-P3-2</option>
                        <option rel="RPP-1A-P6" value="1A-P3-3">1A-P3-3</option>
                        <option rel="RPP-1A-P6" value="1A-P3-4">1A-P3-4</option>

                        <option rel="RPP-1A-P7" value="1A-P3-5">1A-P3-5</option>
                        <option rel="RPP-1A-P7" value="1A-P3-6">1A-P3-6</option>
                        <option rel="RPP-1A-P7" value="1A-P3-7">1A-P3-7</option>
                        <option rel="RPP-1A-P7" value="1A-P3-8">1A-P3-8</option>

                        <option rel="RPP-1A-P8" value="1A-P3-9">1A-P3-9</option>
                        <option rel="RPP-1A-P8" value="1A-P3-10">1A-P3-10</option>
                        <option rel="RPP-1A-P8" value="1A-P4-1">1A-P4-1</option>
                        <option rel="RPP-1A-P8" value="1A-P4-2">1A-P4-2</option>

                        <option rel="RPP-1A-P9" value="1A-P4-3">1A-P4-3</option>
                        <option rel="RPP-1A-P9" value="1A-P4-4">1A-P4-4</option>
                        <option rel="RPP-1A-P9" value="1A-P4-5">1A-P4-5</option>
                        <option rel="RPP-1A-P9" value="1A-P4-6">1A-P4-6</option>

                        <option rel="RPP-1A-P10" value="1A-P4-7">1A-P4-7</option>
                        <option rel="RPP-1A-P10" value="1A-P4-8">1A-P4-8</option>
                        <option rel="RPP-1A-P10" value="1A-P4-9">1A-P4-9</option>
                        <option rel="RPP-1A-P10" value="1A-P4-10">1A-P4-10</option>
                </select>
                </td>
                </tr>

          <!--      </td>  -->
                </tr>
                <tr>
                <td></td>
                <td>
               

                <tr><td>Power Type </td>
                <td>
                    <select  id="category3" name="primaryPowerType" required>
                        <option value="">-SELECT-</option> 
                        <option value="20-120">20/120</option> <!-- Had to change value from 20/120 to 20-120 because console error for character '/'   -->
                        <option value="30-120">30/120</option>
                        <option value="20-208">20/208</option>
                        <option value="30-208">30/208</option>
                        <option value="50-208">50/208</option>
                        <option value="60-208">60/208</option>
                        <option value="30-208-3ph">30/208-3ph</option>';
                        <option value="50-208-3ph">50/208-3ph</option>';
                        <option value="60-208-3ph">60/208-3ph</option>';
                    </select>



                   <select disabled="disabled" id="category4" name="primaryPhaseLetters" required>  
                        <option value="">-SELECT-</option> 
                        <option rel="20-120" value="A">A</option> 
                        <option rel="20-120" value="B">B</option>
                        <option rel="20-120" value="C">C</option>

                        <option rel="30-120" value="A">A</option>
                        <option rel="30-120" value="B">B</option>
                        <option rel="30-120" value="C">C</option>


                        <option rel="20-208" value="A,B">A,B</option>
                        <option rel="20-208" value="A,C">A,C</option>
                        <option rel="20-208" value="B,C">B,C</option>

                        <option rel="30-208" value="A,B">A,B</option>
                        <option rel="30-208" value="A,C">A,C</option>
                        <option rel="30-208" value="B,C">B,C</option>

                        <option rel="50-208" value="A,B">A,B</option>
                        <option rel="50-208" value="A,C">A,C</option>
                        <option rel="50-208" value="B,C">B,C</option>

                        <option rel="60-208" value="A,B">A,B</option>
                        <option rel="60-208" value="A,C">A,C</option>
                        <option rel="60-208" value="B,C">B,C</option>

                        <option rel="30-208-3ph" value="A,B,C">A,B,C</option>

                        <option rel="50-208-3ph" value="A,B,C">A,B,C</option>

                        <option rel="60-208-3ph" value="A,B,C">A,B,C</option>  

                    </select>
                </td>
                </tr>


<!--
                <tr><td>Location </td>
-->
                <td><input type='hidden' id='primaryLocation' name='primaryLocation'  value=""></td></tr>

                <tr><td>Row </td>
                <td><input type='text' id='primaryRow' name='primaryRow' value=""></td></tr>

                <tr><td>Cab </td>
                <td><input type='text' id='primaryCab' name='primaryCab' value=""></td></tr>
<!--
                <tr><td>MAC </td>
                <td><input type='text' name='mac'></td></tr>
-->
                <tr><td>MAU </td>
                <td><input type='text' id='primaryMau' name='primaryMau'></td></tr>
                <!--
                <tr><td><input type="button" name="clear" value="Clear Form" onclick="clearForm(this.form);" ></td></tr>
                -->
                <tr><td>
                   <!--  
                    <input type="submit" id="primaryAdd"  align="left" name="button" value="primary"> 
                -->  
                
                 <button type="submit" id="primaryAdd" class="btn btn-primary" name="primaryAdd">
                    Add Primary
                    </button>  
                 
                
                </td></tr>
                </table>

                </div> <!-- END OF PRIMARY POWER DIV -->




  
<!--                
                <tr><td><td width="100%"><input type="submit" id="addAll" value="Add All" align="left" name="addAll" style="height: 18px; width: 180px; left: 250; top: 250;"></td></td></tr>
-->


<!--    ---------------------------- Secondary Power-----------------------------     -->
                <div id="secondaryPower" class="secondaryPower">
                <table>
                <th colspan="2" align="center">Secondary Power</th>
                <tr><td></td><td width="100%" style="font-size: 12px" align="right">Secondary Power Only <input type="checkbox" id="secondaryOnly" name="secondaryOnly"></td><tr>

<!--
                 <tr><td>cID </td>
-->
                <td><input type='hidden' id='secondaryCid' name='secondaryCid' value=""></td></tr>

                <tr><td>sID </td>
                <td><input type='text' id='secondarySid' name='secondarySid'></td></tr>

                <tr><td>Panel Name</td>
                <td>
                    <select id="category5" name="secondaryRpp" required>
                        <option value="">-SELECT-</option> 
                        <option value="RPP-1A-S1">RPP-1A-S1</option>
                        <option value="RPP-1A-S2">RPP-1A-S2</option>
                        <option value="RPP-1A-S3">RPP-1A-S3</option>
                        <option value="RPP-1A-S4">RPP-1A-S4</option>
                        <option value="RPP-1A-S5">RPP-1A-S5</option>
                        <option value="RPP-1A-S6">RPP-1A-S6</option>
                        <option value="RPP-1A-S7">RPP-1A-S7</option>
                        <option value="RPP-1A-S8">RPP-1A-S8</option>
                        <option value="RPP-1A-S9">RPP-1A-S9</option>
                        <option value="RPP-1A-S10">RPP-1A-S10</option>


                    </select>
                
               
                <select disabled="disabled" id="category6" name="secondaryPanel" required>  
                        <option value="">-SELECT-</option> 
                        <option rel="RPP-1A-S1" value="1A-S1-1">1A-S1-1</option>
                        <option rel="RPP-1A-S1" value="1A-S1-2">1A-S1-2</option>
                        <option rel="RPP-1A-S1" value="1A-S1-3">1A-S1-3</option>
                        <option rel="RPP-1A-S1" value="1A-S1-4">1A-S1-4</option>

                        <option rel="RPP-1A-S2" value="1A-S1-5">1A-S1-5</option>
                        <option rel="RPP-1A-S2" value="1A-S1-6">1A-S1-6</option>
                        <option rel="RPP-1A-S2" value="1A-S1-7">1A-S1-7</option>
                        <option rel="RPP-1A-S2" value="1A-S1-8">1A-S1-8</option>

                        <option rel="RPP-1A-S3" value="1A-S1-9">1A-S1-9</option>
                        <option rel="RPP-1A-S3" value="1A-S1-10">1A-S1-10</option>
                        <option rel="RPP-1A-S3" value="1A-S2-1">1A-S2-1</option>
                        <option rel="RPP-1A-S3" value="1A-S2-2">1A-S2-2</option>
                        
                        <option rel="RPP-1A-S4" value="1A-S2-3">1A-S2-3</option>
                        <option rel="RPP-1A-S4" value="1A-S2-4">1A-S2-4</option>
                        <option rel="RPP-1A-S4" value="1A-S2-5">1A-S2-5</option>
                        <option rel="RPP-1A-S4" value="1A-S2-6">1A-S2-6</option>

                        <option rel="RPP-1A-S5" value="1A-S2-7">1A-S2-7</option>
                        <option rel="RPP-1A-S5" value="1A-S2-8">1A-S2-8</option>
                        <option rel="RPP-1A-S5" value="1A-S2-9">1A-S2-9</option>
                        <option rel="RPP-1A-S5" value="1A-S2-10">1A-S2-10</option>

                        <option rel="RPP-1A-S6" value="1A-S3-1">1A-S3-1</option>
                        <option rel="RPP-1A-S6" value="1A-S3-2">1A-S3-2</option>
                        <option rel="RPP-1A-S6" value="1A-S3-3">1A-S3-3</option>
                        <option rel="RPP-1A-S6" value="1A-S3-4">1A-S3-4</option>

                        <option rel="RPP-1A-S7" value="1A-S3-5">1A-S3-5</option>
                        <option rel="RPP-1A-S7" value="1A-S3-6">1A-S3-6</option>
                        <option rel="RPP-1A-S7" value="1A-S3-7">1A-S3-7</option>
                        <option rel="RPP-1A-S7" value="1A-S3-8">1A-S3-8</option>

                        <option rel="RPP-1A-S8" value="1A-S3-9">1A-S3-9</option>
                        <option rel="RPP-1A-S8" value="1A-S3-10">1A-S3-10</option>
                        <option rel="RPP-1A-S8" value="1A-S4-1">1A-S4-1</option>
                        <option rel="RPP-1A-S8" value="1A-S4-2">1A-S4-2</option>

                        <option rel="RPP-1A-S9" value="1A-S4-3">1A-S4-3</option>
                        <option rel="RPP-1A-S9" value="1A-S4-4">1A-S4-4</option>
                        <option rel="RPP-1A-S9" value="1A-S4-5">1A-S4-5</option>
                        <option rel="RPP-1A-S9" value="1A-S4-6">1A-S4-6</option>

                        <option rel="RPP-1A-S10" value="1A-S4-7">1A-S4-7</option>
                        <option rel="RPP-1A-S10" value="1A-S4-8">1A-S4-8</option>
                        <option rel="RPP-1A-S10" value="1A-S4-9">1A-S4-9</option>
                        <option rel="RPP-1A-S10" value="1A-S4-10">1A-S4-10</option>
                </select>
                </td>
                </tr>


                <tr><td>  </td><td>   </td></tr>
                <tr><td> </td><td></td></tr>
                <tr><td>Power Type </td>
                <td>
                    <select  id="category7" name="secondaryPowerType" required>
                        <option value="">-SELECT-</option> 
                        <option value="20-120">20/120</option> <!-- Had to change value from 20/120 to 20-120 because console error for character '/'   -->
                        <option value="30-120">30/120</option>
                        <option value="20-208">20/208</option>
                        <option value="30-208">30/208</option>
                        <option value="50-208">50/208</option>
                        <option value="60-208">60/208</option>
                        <option value="30-208-3ph">30/208-3ph</option>';
                        <option value="50-208-3ph">50/208-3ph</option>';
                        <option value="60-208-3ph">60/208-3ph</option>';
                    </select>


                   <select disabled="disabled" id="category8" name="secondaryPhaseLetters" required>  
                        <option value="">-SELECT-</option> 
                        <option rel="20-120" value="A">A</option> 
                        <option rel="20-120" value="B">B</option>
                        <option rel="20-120" value="C">C</option>

                        <option rel="30-120" value="A">A</option>
                        <option rel="30-120" value="B">B</option>
                        <option rel="30-120" value="C">C</option>


                        <option rel="20-208" value="A,B">A,B</option>
                        <option rel="20-208" value="A,C">A,C</option>
                        <option rel="20-208" value="B,C">B,C</option>

                        <option rel="30-208" value="A,B">A,B</option>
                        <option rel="30-208" value="A,C">A,C</option>
                        <option rel="30-208" value="B,C">B,C</option>

                        <option rel="50-208" value="A,B">A,B</option>
                        <option rel="50-208" value="A,C">A,C</option>
                        <option rel="50-208" value="B,C">B,C</option>

                        <option rel="60-208" value="A,B">A,B</option>
                        <option rel="60-208" value="A,C">A,C</option>
                        <option rel="60-208" value="B,C">B,C</option>

                        <option rel="30-208-3ph" value="A,B,C">A,B,C</option>

                        <option rel="50-208-3ph" value="A,B,C">A,B,C</option>

                        <option rel="60-208-3ph" value="A,B,C">A,B,C</option>  

                    </select>
                </td>
                </tr>
<!--
                <tr><td>Location </td>
-->
                <td><input type='hidden' id='secondaryLocation' name='secondaryLocation' value=""></td></tr>

                <tr><td>Row </td>
                <td><input type='text' id='secondaryRow' name='secondaryRow' value=""></td></tr>

                <tr><td>Cab </td>
                <td><input type='text' id='secondaryCab' name='secondaryCab' value=""></td></tr>
<!--
                <tr><td>MAC </td>
                <td><input type='text' name='mac'></td></tr>
-->
                <tr><td>MAU </td>
                <td><input type='text' id='secondaryMau' name='secondaryMau'></td></tr>
<!-- Old add secondary button
                <tr><td><input type="submit" value="Add product" align="left" name="secondaryAdd"></td>
-->
<!-- Old add ALL button
                <td width="100%"><input type="submit" id="addAll" value="Add All" align="left" name="addAll" style="height: 18px; width: 200px; left: 250; top: 250;"></td></tr>
-->
                <tr>
                <td>
                 <button type="submit" id="secondaryAdd" class="btn btn-primary" name="secondaryAdd" style="height: 37px; width: 125px; margin-right: 5px;">
                    Add Secondary
                    </button>  
                </td>
                <td width="100%">
                 <button type="submit" class="btn btn-primary" name="addAll" id="addAll" style="height: 37px; width: 100%; left: 250; top: 250;">
                    Add All
                    </button>  
                </td></tr>


                </table>


 
                </div> <!-- End of Secondary -->

                </form>
              </div> <!-- End of Gui -->

        </div> <!-- End of Content -->
        <!--
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/datatables.min.js"></script>
        -->

        <!--
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      -->

      </div> <!-- End of Container -->
      <script src="js/powerproduct.js"></script>
    </body>
</html>





