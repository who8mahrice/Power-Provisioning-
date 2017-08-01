<?php
include 'connect.inc.php';


$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//checks connection
if ($connection->connect_error) die($connection->connect_error);

if(isset($_POST["queryCustomer"]))  
 {  
 	if (isset($_POST['customer']) && !empty($_POST['customer'])
 	&& isset($_POST['location']) && !empty($_POST['location'])
 	&& isset($_POST['searchsID']) && !empty($_POST['searchsID']))
 	{
 		$cIDs = $_POST['customer'];
	 	$locations =  $_POST['location'];
	 	$searchsID = $_POST['searchsID'];

	 	echo $searchsID;


 	}
 	else {
	 	if (isset($_POST['customer']) && !empty($_POST['customer'])
	 	&& isset($_POST['location']) && !empty($_POST['location']))
	 	{
	 		$cIDs = $_POST['customer'];
	 		$locations =  $_POST['location'];

	 	}
	 	searchCustomer($cIDs,$locations,$connection);
 	}

 }




function searchCustomer($cIDs,$locations,$connection){

//$grabPrimaryCustomer = "SELECT sID, power_type, panelName, location, row, cab FROM primarypowerproduct WHERE cID='$cIDs' AND location='$locations'";

$grabPrimaryCustomer = "SELECT primarypowerproduct.sID, primarypowerproduct.power_type, primaryphase.phaseLetter, primarypowerproduct.panelName,  primarypowerproduct.location, primarypowerproduct.row, primarypowerproduct.cab
FROM primarypowerproduct
INNER JOIN `primaryphase` on primaryphase.sID = primarypowerproduct.sID and primarypowerproduct.cID='$cIDs' and primarypowerproduct.location='$locations'";


//$grabSecondaryCustomer = "SELECT sID, power_type, panelName, location, row, cab FROM secondarypowerproduct WHERE cID='$cIDs' AND location='$locations'";


$grabSecondaryCustomer = "SELECT DISTINCT secondarypowerproduct.sID, secondarypowerproduct.power_type, secondaryphase.phaseLetter,secondarypowerproduct.panelName, secondarypowerproduct.location, secondarypowerproduct.row, secondarypowerproduct.cab
FROM secondarypowerproduct
INNER JOIN `secondaryphase` on secondaryphase.sID = secondarypowerproduct.sID and secondarypowerproduct.cID='$cIDs' and secondarypowerproduct.location='$locations'";


$primaryRow ="0";
$primaryCab ="0";
$secondaryRow ="0";
$secondaryCab ="0";

$primaryCustomers = mysqli_query($connection, $grabPrimaryCustomer);  

$secondaryCustomers = mysqli_query($connection, $grabSecondaryCustomer);  
//$resultCustomer = $connection->query($grabCustomer);
			echo'<div class="wholeOutput">';	
	    	echo'<div class="outputPrimaryCustomer">';	
	    	echo "<table>";
	    	echo '<th>sID</th>
	    	<th>Power Type</th>
	    	<th>Phase</th>
	    	<th>Panel</th>
	    	<th>Location</th>
	    	<th>Row</th>
	    	<th>Cabinet</th>';


while($primaryCustomer = mysqli_fetch_array($primaryCustomers)){
			$rows = $primaryCustomer['row'];
			$cabs = $primaryCustomer['cab'];

			if($primaryRow === $rows && $primaryCab === $cabs) {

		    	echo "<tr><td>".$primaryCustomer['sID']."</td>
		    	<td>".$primaryCustomer['power_type']."</td>
		    	<td>".$primaryCustomer['phaseLetter']."</td>
		    	<td>".$primaryCustomer['panelName']."</td>
		    	<td>".$primaryCustomer['location']."</td>
		    	<td>".$primaryCustomer['row']."</td>
		    	<td>".$primaryCustomer['cab']."</td>
		    	</tr>";
		    }
	    	else {


	    		$primaryRow = $rows;
	    		$primaryCab = $cabs;
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".$primaryCustomer['sID']."</td>
		    	<td>".$primaryCustomer['power_type']."</td>
		    	<td>".$primaryCustomer['phaseLetter']."</td>
		    	<td>".$primaryCustomer['panelName']."</td>
		    	<td>".$primaryCustomer['location']."</td>
		    	<td>".$primaryCustomer['row']."</td>
		    	<td>".$primaryCustomer['cab']."</td>
		    	</tr>";

	    	}

	    }

	    	echo "</table>";
	    	echo"</div>";


	    	echo'<div class="outputSecondaryCustomer">';	
	    	echo "<table>";
	    	echo '<th>sID</th>
	    	<th>Power Type</th>
	    	<th>Phase</th>
	    	<th>Panel</th>
	    	<th>Location</th>
	    	<th>Row</th>
	    	<th>Cabinet</th>';

while($secondaryCustomer = mysqli_fetch_array($secondaryCustomers)){
			$rows = $secondaryCustomer['row'];
			$cabs = $secondaryCustomer['cab'];

			if($secondaryRow === $rows && $secondaryCab === $cabs) {

	    	echo "<tr><td>".$secondaryCustomer['sID']."</td>
	    	<td>".$secondaryCustomer['power_type']."</td>
	    	<td>".$secondaryCustomer['phaseLetter']."</td>
	    	<td>".$secondaryCustomer['panelName']."</td>
	    	<td>".$secondaryCustomer['location']."</td>
	    	<td>".$secondaryCustomer['row']."</td>
	    	<td>".$secondaryCustomer['cab']."</td>
	    	</tr>";
	    }
	    	else {


	    		$secondaryRow = $rows;
	    		$secondaryCab = $cabs;
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".' '."</td></tr>";
	    		echo "<tr><td>".$secondaryCustomer['sID']."</td>
	    	<td>".$secondaryCustomer['power_type']."</td>
	    	<td>".$secondaryCustomer['phaseLetter']."</td>
	    	<td>".$secondaryCustomer['panelName']."</td>
	    	<td>".$secondaryCustomer['location']."</td>
	    	<td>".$secondaryCustomer['row']."</td>
	    	<td>".$secondaryCustomer['cab']."</td>
	    	</tr>";

	    	}

	    	}

	    	echo "</table>";
	    	echo"</div>";	
	    	echo"</div>";	  //div for wholeOutput    	
}

?>
