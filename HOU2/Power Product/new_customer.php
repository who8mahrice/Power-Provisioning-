<?php



include 'new_customer_functions.php';
//include 'css.css';
//require_once 'navi.php';
require_once 'newNav.php';


?>

<html>
 <head>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>  


  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
  <script type="text/javascript" src="assets/jquery-1.11.3-jquery.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link href="assets/datatables.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/new_customer.css" />
 </head>
<!--
             <style>
                div #newCust {
                   margin: 0 auto;
                }
            </style>
-->            
    <body>   
        <!-- <div><h2> Add Customer </h2></div> -->
       <!-- <div class="content container-fluid" id="newCustomer">
       -->
            <div class="container" id="content">
              <div><h2> Add Customer </h2></div>
                <div class="row">
                    <div class="col-xs-5" id="custUI">
                    <form action = 'new_customer.php' method='post'>
                    <div class="header"><h3>New Customer </h3></div>
                    <hr class="half-rule"/>
                        <div class="form-group">
                            <label for="cID">Customer ID</label>
                            <input class="form-control" type='text' class="form-control" id="cID" name='cID'>
                        </div>
                        <div class="form-group">
                            <label for="customerName">Customer Name</label>
                            <input class="form-control" type='text' id="customerName" name='customerName'>
                        </div>
                            <div class="form-group">
                                 <!--
                                 <input class="form-control" type="submit" value="Add Customer" name="newCustomer"> 
                                 -->
                                 <button type="submit" class="btn btn-primary" name="newCustomer" id="newCustomer" style="height: 37px; width: 100%; left: 250; top: 250;">Add Customer
                                 </button> 
                                

                             </div>
                    </form>
                    </div>
                </div> <!-- row -->
        </div>
    </body>
</html>


<!-- OLD new customer

<body>
        
        <div><h2> Add Customer </h2></div>
        <div class="content">

            <table border="0" cellpadding="10" cellspacing="5" bgcolor="#eeeeee">
                <th colspan="2" align="center">New Customer</th>
                <form action = 'new_customer.php' method='post'>
                <tr><td>cID </td>
                <td><input type='text' name='cID'></td></tr>
                <tr><td>Customer Name </td>
                <td><input type='text' name='customerName'></td></tr>
                <tr><td><td><input type="submit" value="Add Customer" name="newCustomer"></td></td></tr>
                </form>
        </div>
        
    </body>


-->

