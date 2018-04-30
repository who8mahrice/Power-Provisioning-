<?php
session_start();

//require_once 'navi.php';
require_once 'newNav.php';
//$customer = "";
//$location = "";




//include 'query_functions.php';
//include 'css.css';
//require_once 'navi.php';

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Customer Query</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link href="assets/datatables.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="assets/jquery-1.11.3-jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  /*
  $("#btn-view").hide();
  
  $("#btn-add").click(function(){
    $(".content-loader").fadeOut('slow', function()
    {
      $(".content-loader").fadeIn('slow');
      $(".content-loader").load('add_form.php');
      $("#btn-add").hide();
      $("#btn-view").show();
    });
  });
  

  $("#btn-view").click(function(){
    
    $("body").fadeOut('slow', function()
    {
      $("body").load('index.php');
      $("body").fadeIn('slow');
      window.location.href="index.php";
    });
  });
  */
});
</script>

</head>


<style>
/* CSS STYLING IN HERE */ 
#customerLocation option{
            display:none;
        }


#customerLocation option.label{
            display:block;
}

#customerLocationSession option{
            display:none;
        }


#customerLocationSession option.label{
            display:block;
}


</style>

<body>
<div class="container">
      
        <h2 class="form-signin-heading">Customer Records.</h2><hr />
        <?php
include 'connect.inc.php';
        // echo "<div class='customer'>";
        //         echo "<label for='customerName'>Customer:</label>";       
        //         echo "<select  id='customerName' size='1' name='customerName'>";
        //        echo "<option>-SELECT-</option>"; 



$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);


// START of checks connection
if ($connection->connect_error) die($connection->connect_error);
// END of checks connection

//if($_SESSION['customer'] != ""){
if(isset($_SESSION['customer']) && !empty($_SESSION['customer']) 
  && isset($_SESSION['location']) && !empty($_SESSION['location']))
{
  echo "<div class='customer'>";
  echo "<label for='customerNameSession'>Customer:</label>";       
  echo "<select  id='customerNameSession' name='customerNameSession' value='".$_SESSION['customer']."''>";
  echo "<option value='".$_SESSION['customer']."'>" .$_SESSION['customer']. '</option>'; // test
  echo "<option>-SELECT-</option>"; 
  $query = "SELECT * FROM spaceproduct";  
  $result = mysqli_query($connection, $query);  
  while($row = mysqli_fetch_array($result)){
    echo "<option value='".$row['cID'] ."'>" .$row['cID']. '</option>';
  }

  echo'</select>';

  echo "<select disabled='disabled' id='customerLocationSession' name='customerLocationSession' value='".$_SESSION['location']."'>";
 echo "<option value='".$_SESSION['location']."'>" .$_SESSION['location']. '</option>'; // test
  echo'<option>-SELECT-</option>'; // current one


  $query = "SELECT * FROM spaceproduct";  
  $result = mysqli_query($connection, $query);  
  while($row = mysqli_fetch_array($result)){
    echo "<option rel= ".$row['cID']."  value='".$row['location']."'>" .$row['location']. '</option>';
                    //$customer = $row['cID'];
                    //$location = $row['location'];
  }

  echo' </select>';

debug_to_console($_SESSION['customer']."-Session_Name");
debug_to_console($_SESSION['location']."-Session_Location");   
        
 session_unset(); 
 session_destroy(); 

debug_to_console($_SESSION['customer']);
debug_to_console($_SESSION['location']);

 



} else {

  echo "<div class='customer'>";
  echo "<label for='customerName'>Customer:</label>";       
  echo "<select  id='customerName' size='1' name='customerName'>";
  echo "<option>-SELECT-</option>"; 
  $query = "SELECT * FROM spaceproduct";  
  $result = mysqli_query($connection, $query);  
  while($row = mysqli_fetch_array($result)){
    echo "<option value='".$row['cID'] ."'>" .$row['cID']. '</option>';
  }

  echo'</select>';

  echo'<select disabled="disabled" id="customerLocation" name="customerLocation">';
  echo'<option value="">-SELECT-</option>';


  $query = "SELECT * FROM spaceproduct";  
  $result = mysqli_query($connection, $query);  
  while($row = mysqli_fetch_array($result)){
    echo "<option rel= ".$row['cID']."  value='".$row['location']."'>" .$row['location'].'</option>';
  }
 // end of else

echo' </select>';
}

function debug_to_console( $data ) {
    $output = $data;
    // if ( is_array( $output ) )
    //     $output = implode( ',', $output);


    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
      }
?>

                <!-- <input type='hidden' name="cID" id="cID" value=""> -->
            </div>
            <hr />
            <div id='test'> </div>

          </div>
        </tbody>
        </table>
        
        </div>

    </div>
    
    <br />
    
    <div class="container">


    </div>
 


<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/datatables.min.js"></script>
<script type="text/javascript" src="js/query.js"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
  $('#example').DataTable();

  $('#example')
  .removeClass( 'display' )
  .addClass('table table-bordered');
});
</script>
</body>
</html>

