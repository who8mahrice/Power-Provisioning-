<?php
include 'connect.inc.php';


$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//checks connection
if ($connection->connect_error) die($connection->connect_error);



if (isset($_POST['primaryAdd'])){
	if (isset($_POST['primaryCid']) && !empty($_POST['primaryCid']) 
		&& isset($_POST['primarySid']) &&  !empty($_POST['primarySid'])
		&& isset($_POST['primaryRpp']) && !empty($_POST['primaryRpp']) 
		&& isset($_POST['primaryPanel']) &&  !empty($_POST['primaryPanel'])
		&& isset($_POST['primaryPowerType']) && !empty($_POST['primaryPowerType']) 
		&& isset($_POST['primaryPhaseLetters']) &&  !empty($_POST['primaryPhaseLetters'])
		&& isset($_POST['primaryLocation']) && !empty($_POST['primaryLocation']) 
		&& isset($_POST['primaryRow']) &&  !empty($_POST['primaryRow'])
		&& isset($_POST['primaryCab']) && !empty($_POST['primaryCab']) 
		&& isset($_POST['primaryMau']) &&  !empty($_POST['primaryMau']))
		{
			
			$primaryCid = $_POST['primaryCid'];
			$primarySid = $_POST['primarySid'];
			$primaryRpp = $_POST['primaryRpp'];
			$primaryPanel = $_POST['primaryPanel'];
			$primaryPowerType = $_POST['primaryPowerType'];
			$primaryPhaseLetters = $_POST['primaryPhaseLetters'];
			$primaryLocation = $_POST['primaryLocation'];
			$primaryRow = $_POST['primaryRow'];
			$primaryCab = $_POST['primaryCab'];
			$primaryMau = $_POST['primaryMau'];
			

			addPrimaryPower($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection);





/* Works great here

   $sql = "INSERT INTO primarypowerproduct (cID, sID, panelName, power_type, mau, location, row, cab)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

//iissdsii
   if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt,"ssssdsss", $cID,$sID,$panelName,$power_type,$mau,$location,$row,$cab);

    

    		$cID = $_POST['primaryCid'];
			$sID = $_POST['primarySid'];
			$panelName = $_POST['primaryPanel'];
			$power_type = $_POST['primaryPowerType'];
			$mau = $_POST['primaryMau'];
			$location = $_POST['primaryLocation'];
			$row = $_POST['primaryRow'];
			$cab = $_POST['primaryCab'];
			mysqli_stmt_execute($stmt);

    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
}
mysqli_stmt_close($stmt);
End of works great here */

		}
}

	



if (isset($_POST['secondaryAdd'])){
	if (isset($_POST['secondaryCid']) && !empty($_POST['secondaryCid']) 
		&& isset($_POST['secondarySid']) &&  !empty($_POST['secondarySid'])
		&& isset($_POST['secondaryRpp']) && !empty($_POST['secondaryRpp']) 
		&& isset($_POST['secondaryPanel']) &&  !empty($_POST['secondaryPanel'])
		&& isset($_POST['secondaryPowerType']) && !empty($_POST['secondaryPowerType']) 
		&& isset($_POST['secondaryPhaseLetters']) &&  !empty($_POST['secondaryPhaseLetters'])
		&& isset($_POST['secondaryLocation']) && !empty($_POST['secondaryLocation']) 
		&& isset($_POST['secondaryRow']) &&  !empty($_POST['secondaryRow'])
		&& isset($_POST['secondaryCab']) && !empty($_POST['secondaryCab']) 
		&& isset($_POST['secondaryMau']) &&  !empty($_POST['secondaryMau']))
		{

			$secondaryCid = $_POST['secondaryCid'];
			$secondarySid = $_POST['secondarySid'];
			$secondaryRpp = $_POST['secondaryRpp'];
			$secondaryPanel = $_POST['secondaryPanel'];
			$secondaryPowerType = $_POST['secondaryPowerType'];
			$secondaryPhaseLetters = $_POST['secondaryPhaseLetters'];
			$secondaryLocation = $_POST['secondaryLocation'];
			$secondaryRow = $_POST['secondaryRow'];
			$secondaryCab = $_POST['secondaryCab'];
			$secondaryMau = $_POST['secondaryMau'];

/* Works great here
			   $sql = "INSERT INTO secondarypowerproduct (cID, sID, panelName, power_type, mau, location, row, cab)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

			

   if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt,"ssssdsss", $cID,$sID,$panelName,$power_type,$mau,$location,$row,$cab);

    

    		$cID = $_POST['secondaryCid'];
			$sID = $_POST['secondarySid'];
			$panelName = $_POST['secondaryPanel'];
			$power_type = $_POST['secondaryPowerType'];
			$mau = $_POST['secondaryMau'];
			$location = $_POST['secondaryLocation'];
			$row = $_POST['secondaryRow'];
			$cab = $_POST['secondaryCab'];
			mysqli_stmt_execute($stmt);

    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
}
End of works great here */

		addSecondaryPower($secondaryCid,$secondarySid,$secondaryPanel,$secondaryPowerType,$secondaryMau,$secondaryLocation,$secondaryRow,$secondaryCab,$connection);

		}
		else{
			echo 'Please fill in the fields';
		}
}


function calculatePrimaryPower($primaryCid,$primarySid,$primaryPowerType,$primaryPhaseLetters,$primaryMau){

	

/*
	$sql = "INSERT INTO primaryphase (cID, sID, panelName, power_type, mau, location, row, cab)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

	 if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt,"ssssisss", $cID,$sID,$panelName,$power_type,$mau,$location,$row,$cab);

    

    		$cID = $primaryCid;
			$sID = $primarySid;
			$panelName = $primaryPanel;
			$power_type = $primaryPowerType;
			$mau = $primaryMau;
			$location = $primaryLocation;
			$row = $primaryRow;
			$cab = $primaryCab;
			mysqli_stmt_execute($stmt);

	    echo "Records inserted successfully.";
	} else{
	    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);
*/

}




function addPrimaryPower($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection){


 $sql = "INSERT INTO primarypowerproduct (cID, sID, panelName, power_type, mau, location, row, cab)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

//iissdsii
   if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt,"ssssisss", $cID,$sID,$panelName,$power_type,$mau,$location,$row,$cab);

    

    		$cID = $primaryCid;
			$sID = $primarySid;
			$panelName = $primaryPanel;
			$power_type = $primaryPowerType;
			$mau = $primaryMau;
			$location = $primaryLocation;
			$row = $primaryRow;
			$cab = $primaryCab;
			mysqli_stmt_execute($stmt);

	    echo "Records inserted successfully.";
	} else{
	    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);

    //unset($_POST);
    //echo "<meta http-equiv='refresh' content='2'>";
}

function addSecondaryPower($secondaryCid,$secondarySid,$secondaryPanel,$secondaryPowerType,$secondaryMau,$secondaryLocation,$secondaryRow,$secondaryCab,$connection){


    $sql = "INSERT INTO secondarypowerproduct (cID, sID, panelName, power_type, mau, location, row, cab)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

			

   if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt,"ssssisss", $cID,$sID,$panelName,$power_type,$mau,$location,$row,$cab);

    

    	$cID = $secondaryCid;
		$sID = $secondarySid;
		$panelName = $secondaryPanel;
		$power_type = $secondaryPowerType;
		$mau = $secondaryMau;
		$location = $secondaryLocation;
		$row = $secondaryRow;
		$cab = $secondaryCab;
		mysqli_stmt_execute($stmt);

    	echo "Records inserted successfully.";
	} else{
    	echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);	

}




?>







