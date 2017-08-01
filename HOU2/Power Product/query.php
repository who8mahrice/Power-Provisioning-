<?php




include 'query_functions.php';
//include 'css.css';
require_once 'navi.php';




?>


<html>
 <head>
  <link rel="stylesheet" type="text/css" href="css/style.css" />

  <!-- For section popover  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

 </head>


 <style>
  table {
      
    background-color: #eeeeee;
    width:300px;
 }

 th,td {
    padding: 1px;

 }

 td{
   
    white-space:nowrap;  /*white-space:nowarp goes with <td width="100%"> Panel Name row to fit both drop down menus in one row */
}

.customer{
	 
    width: 313px;
    height: 300px;
     position: absolute; 

    display: inline-block; 
}

.outputPrimaryCustomer table{
	width: 500px;

}
.outputPrimaryCustomer {
	
    float: left;
    padding: 340px 0px 0px 0px; /* top right bottom left */
    position: relative;
  /*   background-color: blue; */
    display: inline-block;
    
  

}

.wholeOutput{
	float: right;
	position: absolute;
	display: inline-block;
/*	background-color: red; */
}

.outputSecondaryCustomer table{
	width: 500px;

}
.outputSecondaryCustomer {
	
    float: right;
    padding: 340px 0px 0px 0px; /* top right bottom left */
    position: absolute;
    display: inline-block;
     /* background-color: yellow; */
    
    
  

}

 </style>
 <body>
     <section id="content">
     <div><h2> Query Customer </h2></div>
     	<div class="customer">
	     <form action = 'query.php' method='post'>
	     	<table>
             
                <tr><td>Customer </td>
                <td><input type='text' name='customer'></td></tr>
                <tr><td>Location </td>
                <td><input type='text' name='location'></td></tr>
                    <td>sIDs </td><td>
                	<textarea style="resize:none" name="searchsID" rows="10" cols="6" class="searchsID" placeholder="sIDs Here" ></textarea>
                </td></tr>
                <tr><td><td><input type="submit" value="Query Customer" align="center" name="queryCustomer"></td></td></tr>
             </table>
	     </form>
	    </div>
	    <div class="output">
	    </div> 
     </section>
 </body>

