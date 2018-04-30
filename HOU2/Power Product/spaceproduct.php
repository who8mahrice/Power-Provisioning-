<?php

//include 'connect.inc.php';
include 'space_product_functions.php';
//require_once 'navi.php';

require_once 'newNav.php';

?>

<html>
<header>
    <!-- ajax jquery.min.js is needed for button dropdown menu -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>



    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
    <link href="assets/datatables.min.css" rel="stylesheet" type="text/css">
</header>
<style>
/*
    table{
        border: 1px solid black;
    }
*/   
    
</style>
<link rel="stylesheet" type="text/css" href="css/new_customer.css" />
<body>
    <div class="container">
    <div class=content>
    <div><h2> Add Space Product </h2></div>
        <table border="0" cellpadding="10" cellspacing="5" bgcolor="#eeeeee">
            <form action = 'spaceproduct.php' method='post'>
            
            <!-- <th colspan="2" align="center">New Space</th> -->
            <div class="row">
                    <div class="col-xs-5" id="custUI">
            <div class="header"><h3>New Space </h3></div>
                    <hr class="half-rule"/>
            <div class="form-group">
                <label for="cID">Customer ID</label>
                <input class="form-control" type='text' class="form-control" id="cID" name='cID'>
            </div>
            <div class="form-group">
                <label for="cID">Service ID</label>
                <input class="form-control" type='text' class="form-control" id="sID" name='sID'>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input class="form-control" type='text' class="form-control" id="location" name='location'>
            </div>
            <div class="form-group">
                <label for="cID">Space Type</label>
                <select name="spaceType" class="spaceType" size="1">
                    <option value="">-SELECT-</option>
                    <option value="Cage">Cage</option>
                    <option value="Shared">Shared</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="addSpace" value="Add Space" style="height: 37px; width: 100%; left: 250; top: 250; bottom: 50; margin-bottom: 15px;">
                    Add Customer
                    </button>


<!-- Start DEL 
            <form action = 'spaceproduct.php' method='post'>
                <tr><td><label for="cID">cID</label></td>
                <td><input type='text' name='cID'></td></tr>
                <tr><td><label for="sID">sID</label></td>
                <td><input type='text' name='sID'></td></tr>
                <tr><td><label for="spaceType">Space Type</label></td>
                <td>
                <select name="spaceType" class="spaceType" size="1">
                    <option value="">-SELECT-</option>
                    <option value="Cage">Cage</option>
                    <option value="Shared">Shared</option>
                </select>
                </td></tr>

                <tr><td><label for="location">Location</label></td>
                <td><input type='text' name='location'></td></tr>
End DEL-->    
                <!--
                <tr><td><td><input type="submit" value="Add Space" name="addSpace" ></td></td></tr>
                -->
 <!-- Start DEL            
                <tr><td><td><button type="submit" class="btn btn-primary" name="addSpace" id="newCustomer" style="height: 37px; width: 100%; left: 250; top: 250;">
                    Add Customer
                    </button></td></td></tr>
            </form>
End DEL-->            
        </div>
    </form>
        </table>
        </div>
                </div> <!-- row -->
    </div> <!-- End of Container -->
</body>

</html>

