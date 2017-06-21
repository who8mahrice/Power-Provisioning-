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
			
			calculatePrimaryPower($primaryCid, $primarySid, $primaryPowerType, $primaryPhaseLetters,$primaryLocation, $primaryRow, $primaryCab, $primaryMau, $connection);

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


		calculateSecondaryPower($secondaryCid, $secondarySid, $secondaryPowerType, $secondaryPhaseLetters,$secondaryLocation, $secondaryRow, $secondaryCab, $secondaryMau, $connection);

		addSecondaryPower($secondaryCid,$secondarySid,$secondaryPanel,$secondaryPowerType,$secondaryMau,$secondaryLocation,$secondaryRow,$secondaryCab,$connection);

		//calculateSecondaryPower($secondaryCid, $secondarySid, $secondaryPowerType, $secondaryPhaseLetters, $secondaryMau, $connection);

		}
		else{
			echo 'Please fill in the fields';
		}
}

//function calculatePrimaryPower($primaryCid,$primarySid,$primaryPowerType,$primaryPhaseLetters,$primaryMau){

function calculatePrimaryPower($primaryCid, $primarySid, $primaryPowerType, $primaryPhaseLetters,$primaryLocation, $primaryRow, $primaryCab, $primaryMau, $connection){

	$previousValues = false;
	$previousValueA = false;
	$previousValueB = false;
	$previousValueC = false;

	$primaryPhaseLetter = explode( "," , $primaryPhaseLetters);
	$numOfPhases = count($primaryPhaseLetter);
	$primaryAmps = (int)substr($primaryPowerType,0, -4);
	$mau = $primaryMau;

	$circuit_watts_calc = $primaryAmps*120*pow(sqrt(3),$numOfPhases-1)*0.8;
	$per_phase_va_calc = 120*$primaryAmps*0.8;
	$per_phase_watts_calc = $circuit_watts_calc/$numOfPhases;





	// $sql to query the lastest cab power product that was inserted 
	$checkCabs = "SELECT sID, cID, location, row, cab FROM primarypowerproduct where cID=$primaryCid AND location=$primaryLocation AND row=$primaryRow AND cab=$primaryCab ORDER BY sID DESC LIMIT 1" ;
	$result = $connection->query($checkCabs);

	if ($result->num_rows > 0) { //(
		$previousValues = true;
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    	$sid = $row["sID"];
	    	echo $sid.'<br>';
	  }
	} //)
	
	if ($previousValues == true){
	$sqlPhase = "SELECT sID, numberOfPhases, phaseLetter, ratio_A,  totalWatts_A, totalPhaseVa_A, totalPhaseWatts_A, ratio_B,  totalWatts_B ,  totalPhaseVa_B ,  totalPhaseWatts_B , ratio_C,  totalWatts_C , totalPhaseVa_C , totalPhaseWatts_C FROM primaryphase where sID=$sid";

	$result = $connection->query($sqlPhase);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    $aa =$row["numberOfPhases"];
		$ratioAs =$row["ratio_A"];
		$totalWattsAs =$row["totalWatts_A"];
		$totalPhaseVaAs =$row["totalPhaseVa_A"];
		$totalPhaseWattsAs =$row["totalPhaseWatts_A"];
		$ratioBs =$row["ratio_B"];
		$totalWattsBs =$row["totalWatts_B"];
		$totalPhaseVaBs =$row["totalPhaseVa_B"];
		$totalPhaseWattsBs =$row["totalPhaseWatts_B"];
		$ratioCs =$row["ratio_C"];
		$totalWattsCs =$row["totalWatts_C"];
		$totalPhaseVaCs =$row["totalPhaseVa_C"];
		$totalPhaseWattsCs = $row["totalPhaseWatts_C"];
		



		//list($a, $ratioA, $totalWattsA, $totalPhaseVaA, $totalPhaseWattsA, $ratioB, $totalWattsB, $totalPhaseVaB, $totalPhaseWattsB, $ratioC, $totalWattsC, $totalPhaseVaC, $totalPhaseWattsC) = returner($aa, $ratioAs,$totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

		list($a,$ratioA,$totalWattsA,$totalPhaseVaA,$totalPhaseWattsA,$ratioB,$totalWattsB,$totalPhaseVaB,$totalPhaseWattsB,$ratioC,$totalWattsC,$totalPhaseVaC,$totalPhaseWattsC) = returner($aa,$ratioAs, $totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

	    	//echo "sID: " . $row["sID"]. " numberOfPhases: ".$row["numberOfPhases"]." ratio_A: " . $row["ratio_A"]. " totalWatts_A: " . $row["totalWatts_A"]." totalPhaseVa_A: ".$row["totalPhaseVa_A"]." totalPhaseWatts_A: ".$row["totalPhaseWatts_A"]. " ratio_B: " . $row["ratio_B"]. " totalWatts_B: ".$row["totalWatts_B"]."  totalPhaseVa_B: " . $row["totalPhaseVa_B"]. " totalPhaseWatts_B: " . $row["totalPhaseWatts_B"]." ratio_C: ".$row["ratio_C"]." totalWatts_C: ".$row["totalWatts_C"]."   totalPhaseVa_C: " . $row["totalPhaseVa_C"]. " totalPhaseWatts_C: " . $row["totalPhaseWatts_C"]."<br>";

	  } // end of while

	 //echo 'Singles: '.$a.' '.$ratioA.' '.$totalWattsA.' '.$totalPhaseVaA.' '.$totalPhaseWattsA.' '.$ratioB.' '.$totalWattsB.' '.$totalPhaseVaB.' '.$totalPhaseWattsB.' '.$ratioC.' '.$totalWattsC.' '.$totalPhaseVaC.' '.$totalPhaseWattsC.'<br>';


	 	foreach($primaryPhaseLetter as $item) {		

			if($item == 'A'){
				//echo 'This is for Phase A '.'<br>';
				$previousValueA = true;

				 $pair_ratio_calc_A = min($circuit_watts_calc,($circuit_watts_calc-max($totalWattsAs + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc;   // Takes previous_total_watts

				 $pair_allowed_watts_calc_A =  $pair_ratio_calc_A * $circuit_watts_calc;

				 $pair_total_watts_calc_A = $totalWattsAs +  $pair_ratio_calc_A * $circuit_watts_calc;   // Takes previous_total_watts

				 $pair_circuit_phase_va_calc_A = $pair_ratio_calc_A * $per_phase_va_calc;


				 $pair_total_phase_va_calc_A = $totalPhaseVaAs  + $pair_circuit_phase_va_calc_A;   // Takes prvious_total_phase_va

				 $pair_circuit_phase_watts_calc_A = $pair_ratio_calc_A * $per_phase_watts_calc;


				 $pair_total_phase_watts_calc_A = $totalPhaseWattsAs + $pair_circuit_phase_watts_calc_A;  // Takes prvious_total_phase_watts

				 echo 'This is for Phase A'.' pair_ratio_calc_A: '.$pair_ratio_calc_A.' pair_allowed_watts_calc_A: '.$pair_allowed_watts_calc_A.' pair_total_watts_calc_A: '.$pair_total_watts_calc_A.' pair_circuit_phase_va_calc_A: '.$pair_circuit_phase_va_calc_A.' pair_total_phase_va_calc_A: '.$pair_total_phase_va_calc_A.' pair_circuit_phase_watts_calc_A: '.$pair_circuit_phase_watts_calc_A.' pair_total_phase_watts_calc_A: '.$pair_total_phase_watts_calc_A.'<br>'.'<br>';

			}
			else if ($item == 'B'){
				//echo 'This is for Phase B'.'<br>';
				$previousValueB = true;

				$pair_ratio_calc_B = min($circuit_watts_calc,($circuit_watts_calc-max($totalWattsBs + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc;   // Takes previous_total_watts

				 $pair_allowed_watts_calc_B =  $pair_ratio_calc_B * $circuit_watts_calc;

				 $pair_total_watts_calc_B = $totalWattsBs +  $pair_ratio_calc_B * $circuit_watts_calc;   // Takes previous_total_watts

				 $pair_circuit_phase_va_calc_B = $pair_ratio_calc_B * $per_phase_va_calc;


				 $pair_total_phase_va_calc_B = $totalPhaseVaBs  + $pair_circuit_phase_va_calc_B;   // Takes prvious_total_phase_va

				 $pair_circuit_phase_watts_calc_B = $pair_ratio_calc_B * $per_phase_watts_calc;


				 $pair_total_phase_watts_calc_B = $totalPhaseWattsBs + $pair_circuit_phase_watts_calc_B;  // Takes prvious_total_phase_watts

				 echo 'This is for Phase B'.' pair_ratio_calc_B: '.$pair_ratio_calc_B.' pair_allowed_watts_calc_B: '.$pair_allowed_watts_calc_B.' pair_total_watts_calc_B: '.$pair_total_watts_calc_B.' pair_circuit_phase_va_calc_B: '.$pair_circuit_phase_va_calc_B.' pair_total_phase_va_calc_B: '.$pair_total_phase_va_calc_B.' pair_circuit_phase_watts_calc_B: '.$pair_circuit_phase_watts_calc_B.' pair_total_phase_watts_calc_B: '.$pair_total_phase_watts_calc_B.'<br>'.'<br>';

			}
			else if ($item == 'C'){
				//echo 'This is for Phase C'.'<br>';
				$previousValueC = true;

				$pair_ratio_calc_C = min($circuit_watts_calc,($circuit_watts_calc-max($totalWattsCs + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc;   // Takes previous_total_watts

				 $pair_allowed_watts_calc_C =  $pair_ratio_calc_C * $circuit_watts_calc;

				 $pair_total_watts_calc_C = $totalWattsCs +  $pair_ratio_calc_C * $circuit_watts_calc;   // Takes previous_total_watts

				 $pair_circuit_phase_va_calc_C = $pair_ratio_calc_C * $per_phase_va_calc;


				 $pair_total_phase_va_calc_C = $totalPhaseVaCs  + $pair_circuit_phase_va_calc_C;   // Takes prvious_total_phase_va

				 $pair_circuit_phase_watts_calc_C = $pair_ratio_calc_C * $per_phase_watts_calc;


				 $pair_total_phase_watts_calc_C = $totalPhaseWattsCs + $pair_circuit_phase_watts_calc_C;  // Takes prvious_total_phase_watts

				 echo 'This is for Phase C'.' pair_ratio_calc_C: '.$pair_ratio_calc_C.' pair_allowed_watts_calc_C: '.$pair_allowed_watts_calc_C.' pair_total_watts_calc_C: '.$pair_total_watts_calc_C.' pair_circuit_phase_va_calc_C: '.$pair_circuit_phase_va_calc_C.' pair_total_phase_va_calc_C: '.$pair_total_phase_va_calc_C.' pair_circuit_phase_watts_calc_C: '.$pair_circuit_phase_watts_calc_C.' pair_total_phase_watts_calc_C: '.$pair_total_phase_watts_calc_C.'<br>'.'<br>';

			}
			else {
				echo 'Something wong here';
			}
		
		} // end of for

	} else {
	    echo "sID is not in the Primary Phase Table".'<br>';
		}
	}
	else {
		echo 'No previous values here'.'<br>';
		$ratio_calc = min($circuit_watts_calc,($circuit_watts_calc-max($circuit_watts_calc-$mau,0)))/$circuit_watts_calc; // will need to add previous current values of total watts here: max(PREVIOUS_TOTAL_WATTS + $circuit_watts_calc-$mau,0)
	    $allowed_watts_calc =  $ratio_calc * $circuit_watts_calc;
	    $total_watts_calc =  $ratio_calc * $circuit_watts_calc; // will need to add previous current values of total watts here: PREVIOUS_TOTAL_WATTS + $ratio_calc * $circuit_watts_calc
	    $circuit_phase_va_calc = $ratio_calc * $per_phase_va_calc; // Number for subtraction
	    $total_phase_va_calc = $circuit_phase_va_calc;// number for subtraction.  Will need to add previous current values of total phase va here: PREVIOUS_TOTAL_PHASE_VA  + $circuit_phase_va
	    $circuit_phase_watts_calc = $ratio_calc * $per_phase_watts_calc;
	    $total_phase_watts_calc = $circuit_phase_watts_calc;// will need to add previous current values of total phase watts here: TOTAL_PHASE_WATTS + $circuit_phase_watts.
	}


   // echo '# of Phases: '.$numOfPhases.'<br>'.'# of amps: '.$primaryAmps.'<br>'.'MAU: '.$mau.'<br>'.'Circuit Watts: '.$circuit_watts_calc.'<br>'. 'Per phase va: '.$per_phase_va_calc.'<br>'.'Per phase watts: '.$per_phase_va_calc.'<br>'.'Ratio: '.$ratio_calc.'<br>'. 'Allowed watts: '.$allowed_watts_calc.'<br>'.'Total watts: '.$total_watts_calc.'<br>'.'Circuit phase va: '.$circuit_phase_va_calc.'<br>'.'Total phase va: '.$total_phase_va_calc.'<br>'.'Circuit phase watts: '.$circuit_phase_watts_calc.'<br>'.'Total phase watts: '.$total_phase_watts_calc.'<br>'; 


    $sql = "INSERT INTO primaryphase (cID, sID, amps, numberOfPhases, phaseLetter, circuitWatts, perPhaseVa, perPhaseWatts,ratio_A, allowedWatts_A, totalWatts_A, circuitPhaseVa_A, totalPhaseVa_A, circuitPhaseWatts_A, totalPhaseWatts_A, ratio_B, allowedWatts_B , totalWatts_B , circuitPhaseVa_B , totalPhaseVa_B , circuitPhaseWatts_B , totalPhaseWatts_B , ratio_C, allowedWatts_C , totalWatts_C , circuitPhaseVa_C , totalPhaseVa_C , circuitPhaseWatts_C , totalPhaseWatts_C)VALUES(?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
   

	// echo '# of Phases: '.$numOfPhases . ' # of AMPs: '.$amps.' MAU: '.$mau;

	 if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
	mysqli_stmt_bind_param($stmt,"ssiisdddddddddddddddddddddddd", $cID, $sID, $amps, $numberOfPhases, $phaseLetter, $circuitWatts, $perPhaseVa, $perPhaseWatts, $ratio_A, $allowedWatts_A, $totalWatts_A, $circuitPhaseVa_A, $totalPhaseVa_A, $circuitPhaseWatts_A, $totalPhaseWatts_A, $ratio_B, $allowedWatts_B , $totalWatts_B , $circuitPhaseVa_B , $totalPhaseVa_B , $circuitPhaseWatts_B , $totalPhaseWatts_B , $ratio_C, $allowedWatts_C , $totalWatts_C , $circuitPhaseVa_C , $totalPhaseVa_C , $circuitPhaseWatts_C , $totalPhaseWatts_C);



		$cID = $primaryCid;
		$sID = $primarySid;
		$amps = $primaryAmps;
		$numberOfPhases = $numOfPhases;
		$phaseLetter = $primaryPhaseLetters; // $primaryPhaseLetters with an s at the end is coming from GUI. $primaryPhaseLetter w/o the s is an array to for the foreach below.
		$circuitWatts = $circuit_watts_calc;
		$perPhaseVa = $per_phase_va_calc;
		$perPhaseWatts = $per_phase_watts_calc; 

		// Assigns which phases get values in the DB
		foreach($primaryPhaseLetter as $item){
			echo 'Phase '.$item.'<br>';			

			if($item == 'A'){
				if ($previousValueA == true){
					echo 'New pair of A has been set'.'<br>';

					$ratio_A = $pair_ratio_calc_A;
					$allowedWatts_A = $pair_allowed_watts_calc_A;
					$totalWatts_A = $pair_total_watts_calc_A;
					$circuitPhaseVa_A = $pair_circuit_phase_va_calc_A;
					$totalPhaseVa_A = $pair_total_phase_va_calc_A;
					$circuitPhaseWatts_A = $pair_circuit_phase_watts_calc_A;
					$totalPhaseWatts_A = $pair_total_phase_watts_calc_A;

				} else{
					echo 'Values of A has been set'.'<br>';
					$ratio_A = $ratio_calc;
					$allowedWatts_A = $allowed_watts_calc;
					$totalWatts_A = $total_watts_calc;
					$circuitPhaseVa_A = $circuit_phase_va_calc;
					$totalPhaseVa_A = $total_phase_va_calc;
					$circuitPhaseWatts_A = $circuit_phase_watts_calc;
					$totalPhaseWatts_A = $total_phase_watts_calc;

					echo 'Values of A has been set'.' ratio_A '.$ratio_A.' allowedWatts_A '.$allowedWatts_A.' totalWatts_A '.$totalWatts_A.' circuitPhaseVa_A '.$circuitPhaseVa_A.' totalPhaseVa_A '.$totalPhaseVa_A.' circuitPhaseWatts_A '.$circuitPhaseWatts_A.' totalPhaseWatts_A '.$totalPhaseWatts_A.'<br>';
				}
			}
			else if ($item == 'B'){
				if ($previousValueB == true){
					echo 'New pair of B has been set'.'<br>';

					$ratio_B = $pair_ratio_calc_B;
					$allowedWatts_B = $pair_allowed_watts_calc_B;
					$totalWatts_B = $pair_total_watts_calc_B;
					$circuitPhaseVa_B = $pair_circuit_phase_va_calc_B;
					$totalPhaseVa_B = $pair_total_phase_va_calc_B;
					$circuitPhaseWatts_B = $pair_circuit_phase_watts_calc_B;
					$totalPhaseWatts_B = $pair_total_phase_watts_calc_B;

				}else{
					echo 'Values of B has been set'.'<br>';
					$ratio_B = $ratio_calc;
					$allowedWatts_B = $allowed_watts_calc;
					$totalWatts_B = $total_watts_calc;
					$circuitPhaseVa_B = $circuit_phase_va_calc;
					$totalPhaseVa_B = $total_phase_va_calc;
					$circuitPhaseWatts_B = $circuit_phase_watts_calc;
					$totalPhaseWatts_B = $total_phase_watts_calc;
					echo 'Values of B has been set'.' ratio_B '.$ratio_B.' allowedWatts_B '.$allowedWatts_B.' totalWatts_B '.$totalWatts_B.' circuitPhaseVa_B '.$circuitPhaseVa_B.' totalPhaseVa_B '.$totalPhaseVa_B.' circuitPhaseWatts_B '.$circuitPhaseWatts_B.' totalPhaseWatts_B '.$totalPhaseWatts_B.'<br>';
				}
			}
			else if ($item == 'C'){

				if ($previousValueC == true){
					echo 'New pair of C has been set'.'<br>';
					$ratio_C = $pair_ratio_calc_C;
					$allowedWatts_C = $pair_allowed_watts_calc_C;
					$totalWatts_C = $pair_total_watts_calc_C;
					$circuitPhaseVa_C = $pair_circuit_phase_va_calc_C;
					$totalPhaseVa_C = $pair_total_phase_va_calc_C;
					$circuitPhaseWatts_C = $pair_circuit_phase_watts_calc_C;
					$totalPhaseWatts_C = $pair_total_phase_watts_calc_C;

				}else{
					//echo 'Values of C has been set'.'<br>';
					$ratio_C = $ratio_calc;
					$allowedWatts_C = $allowed_watts_calc;
					$totalWatts_C = $total_watts_calc;
					$circuitPhaseVa_C = $circuit_phase_va_calc;
					$totalPhaseVa_C = $total_phase_va_calc;
					$circuitPhaseWatts_C = $circuit_phase_watts_calc;
					$totalPhaseWatts_C = $total_phase_watts_calc;
					echo 'Values of C has been set'.' ratio_C '.$ratio_C.' allowedWatts_C '.$allowedWatts_C.' totalWatts_C '.$totalWatts_C.' circuitPhaseVa_C '.$circuitPhaseVa_C.' totalPhaseVa_C '.$totalPhaseVa_C.' circuitPhaseWatts_C '.$circuitPhaseWatts_C.' totalPhaseWatts_C '.$totalPhaseWatts_C.'<br>';
				}
			}
			else {
				echo 'Something wong here';
			}
		
		}

/*
 	 //To insert NULL VALUES, if not by default		
		 if($counter != 3 ){
		 	$differenceInArrays = array_diff($emptyArray,$testPhase);
			 print_r($differenceInArrays);
			 echo '<br>';
			 echo '<br>';

			 // ************************* change this to Switch statements *************************
		 	foreach($differenceInArrays as $nulls){
		 		if($nulls == 'A'){
						echo 'NULL values of A has been set'.'<br>';
					}
					else if ($nulls == 'B'){
						echo 'NULL values of B has been set'.'<br>';
					}
					else if ($nulls == 'C'){
						echo 'NULL values of C has been set'.'<br>';
					}
					else {
						echo 'Something wong here in NULLS';
					}
				}
 		}
*/ 



			mysqli_stmt_execute($stmt);

	    echo "Records inserted successfully.";

	} 

	else{
	    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);


}



function calculateSecondaryPower($secondaryCid, $secondarySid, $secondaryPowerType, $secondaryPhaseLetters,$secondaryLocation, $secondaryRow, $secondaryCab, $secondaryMau, $connection){

	$previousValues = false;
	$previousValueA = false;
	$previousValueB = false;
	$previousValueC = false;

	$secondaryPhaseLetter = explode( "," , $secondaryPhaseLetters);
	$numOfPhases = count($secondaryPhaseLetter);
	$secondaryAmps = (int)substr($secondaryPowerType,0, -4);
	$mau = $secondaryMau;

	$circuit_watts_calc = $secondaryAmps*120*pow(sqrt(3),$numOfPhases-1)*0.8;
	$per_phase_va_calc = 120*$secondaryAmps*0.8;
	$per_phase_watts_calc = $circuit_watts_calc/$numOfPhases;





	// $sql to query the lastest cab power product that was inserted 
	$checkCabs = "SELECT sID, cID, location, row, cab FROM secondarypowerproduct where cID=$secondaryCid AND location=$secondaryLocation AND row=$secondaryRow AND cab=$secondaryCab ORDER BY sID DESC LIMIT 1" ;
	$result = $connection->query($checkCabs);

	if ($result->num_rows > 0) { //(
		$previousValues = true;
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    	$sid = $row["sID"];
	    	echo $sid.'<br>';
	  }
	} //)
	
	if ($previousValues == true){
	$sqlPhase = "SELECT sID, numberOfPhases, phaseLetter, ratio_A,  totalWatts_A, totalPhaseVa_A, totalPhaseWatts_A, ratio_B,  totalWatts_B ,  totalPhaseVa_B ,  totalPhaseWatts_B , ratio_C,  totalWatts_C , totalPhaseVa_C , totalPhaseWatts_C FROM secondaryphase where sID=$sid";

	$result = $connection->query($sqlPhase);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    $aa =$row["numberOfPhases"];
		$ratioAs =$row["ratio_A"];
		$totalWattsAs =$row["totalWatts_A"];
		$totalPhaseVaAs =$row["totalPhaseVa_A"];
		$totalPhaseWattsAs =$row["totalPhaseWatts_A"];
		$ratioBs =$row["ratio_B"];
		$totalWattsBs =$row["totalWatts_B"];
		$totalPhaseVaBs =$row["totalPhaseVa_B"];
		$totalPhaseWattsBs =$row["totalPhaseWatts_B"];
		$ratioCs =$row["ratio_C"];
		$totalWattsCs =$row["totalWatts_C"];
		$totalPhaseVaCs =$row["totalPhaseVa_C"];
		$totalPhaseWattsCs = $row["totalPhaseWatts_C"];
		



		//list($a, $ratioA, $totalWattsA, $totalPhaseVaA, $totalPhaseWattsA, $ratioB, $totalWattsB, $totalPhaseVaB, $totalPhaseWattsB, $ratioC, $totalWattsC, $totalPhaseVaC, $totalPhaseWattsC) = returner($aa, $ratioAs,$totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

		list($a,$ratioA,$totalWattsA,$totalPhaseVaA,$totalPhaseWattsA,$ratioB,$totalWattsB,$totalPhaseVaB,$totalPhaseWattsB,$ratioC,$totalWattsC,$totalPhaseVaC,$totalPhaseWattsC) = returner($aa,$ratioAs, $totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

	    	//echo "sID: " . $row["sID"]. " numberOfPhases: ".$row["numberOfPhases"]." ratio_A: " . $row["ratio_A"]. " totalWatts_A: " . $row["totalWatts_A"]." totalPhaseVa_A: ".$row["totalPhaseVa_A"]." totalPhaseWatts_A: ".$row["totalPhaseWatts_A"]. " ratio_B: " . $row["ratio_B"]. " totalWatts_B: ".$row["totalWatts_B"]."  totalPhaseVa_B: " . $row["totalPhaseVa_B"]. " totalPhaseWatts_B: " . $row["totalPhaseWatts_B"]." ratio_C: ".$row["ratio_C"]." totalWatts_C: ".$row["totalWatts_C"]."   totalPhaseVa_C: " . $row["totalPhaseVa_C"]. " totalPhaseWatts_C: " . $row["totalPhaseWatts_C"]."<br>";

	  } // end of while

	 //echo 'Singles: '.$a.' '.$ratioA.' '.$totalWattsA.' '.$totalPhaseVaA.' '.$totalPhaseWattsA.' '.$ratioB.' '.$totalWattsB.' '.$totalPhaseVaB.' '.$totalPhaseWattsB.' '.$ratioC.' '.$totalWattsC.' '.$totalPhaseVaC.' '.$totalPhaseWattsC.'<br>';


	 	foreach($secondaryPhaseLetter as $item) {		

			if($item == 'A'){
				//echo 'This is for Phase A '.'<br>';
				$previousValueA = true;

				 $pair_ratio_calc_A = min($circuit_watts_calc,($circuit_watts_calc-max($totalWattsAs + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc;   // Takes previous_total_watts

				 $pair_allowed_watts_calc_A =  $pair_ratio_calc_A * $circuit_watts_calc;

				 $pair_total_watts_calc_A = $totalWattsAs +  $pair_ratio_calc_A * $circuit_watts_calc;   // Takes previous_total_watts

				 $pair_circuit_phase_va_calc_A = $pair_ratio_calc_A * $per_phase_va_calc;


				 $pair_total_phase_va_calc_A = $totalPhaseVaAs  + $pair_circuit_phase_va_calc_A;   // Takes prvious_total_phase_va

				 $pair_circuit_phase_watts_calc_A = $pair_ratio_calc_A * $per_phase_watts_calc;


				 $pair_total_phase_watts_calc_A = $totalPhaseWattsAs + $pair_circuit_phase_watts_calc_A;  // Takes prvious_total_phase_watts

				 echo 'This is for Phase A'.' pair_ratio_calc_A: '.$pair_ratio_calc_A.' pair_allowed_watts_calc_A: '.$pair_allowed_watts_calc_A.' pair_total_watts_calc_A: '.$pair_total_watts_calc_A.' pair_circuit_phase_va_calc_A: '.$pair_circuit_phase_va_calc_A.' pair_total_phase_va_calc_A: '.$pair_total_phase_va_calc_A.' pair_circuit_phase_watts_calc_A: '.$pair_circuit_phase_watts_calc_A.' pair_total_phase_watts_calc_A: '.$pair_total_phase_watts_calc_A.'<br>'.'<br>';

			}
			else if ($item == 'B'){
				//echo 'This is for Phase B'.'<br>';
				$previousValueB = true;

				$pair_ratio_calc_B = min($circuit_watts_calc,($circuit_watts_calc-max($totalWattsBs + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc;   // Takes previous_total_watts

				 $pair_allowed_watts_calc_B =  $pair_ratio_calc_B * $circuit_watts_calc;

				 $pair_total_watts_calc_B = $totalWattsBs +  $pair_ratio_calc_B * $circuit_watts_calc;   // Takes previous_total_watts

				 $pair_circuit_phase_va_calc_B = $pair_ratio_calc_B * $per_phase_va_calc;


				 $pair_total_phase_va_calc_B = $totalPhaseVaBs  + $pair_circuit_phase_va_calc_B;   // Takes prvious_total_phase_va

				 $pair_circuit_phase_watts_calc_B = $pair_ratio_calc_B * $per_phase_watts_calc;


				 $pair_total_phase_watts_calc_B = $totalPhaseWattsBs + $pair_circuit_phase_watts_calc_B;  // Takes prvious_total_phase_watts

				 echo 'This is for Phase B'.' pair_ratio_calc_B: '.$pair_ratio_calc_B.' pair_allowed_watts_calc_B: '.$pair_allowed_watts_calc_B.' pair_total_watts_calc_B: '.$pair_total_watts_calc_B.' pair_circuit_phase_va_calc_B: '.$pair_circuit_phase_va_calc_B.' pair_total_phase_va_calc_B: '.$pair_total_phase_va_calc_B.' pair_circuit_phase_watts_calc_B: '.$pair_circuit_phase_watts_calc_B.' pair_total_phase_watts_calc_B: '.$pair_total_phase_watts_calc_B.'<br>'.'<br>';

			}
			else if ($item == 'C'){
				//echo 'This is for Phase C'.'<br>';
				$previousValueC = true;

				$pair_ratio_calc_C = min($circuit_watts_calc,($circuit_watts_calc-max($totalWattsCs + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc;   // Takes previous_total_watts

				 $pair_allowed_watts_calc_C =  $pair_ratio_calc_C * $circuit_watts_calc;

				 $pair_total_watts_calc_C = $totalWattsCs +  $pair_ratio_calc_C * $circuit_watts_calc;   // Takes previous_total_watts

				 $pair_circuit_phase_va_calc_C = $pair_ratio_calc_C * $per_phase_va_calc;


				 $pair_total_phase_va_calc_C = $totalPhaseVaCs  + $pair_circuit_phase_va_calc_C;   // Takes prvious_total_phase_va

				 $pair_circuit_phase_watts_calc_C = $pair_ratio_calc_C * $per_phase_watts_calc;


				 $pair_total_phase_watts_calc_C = $totalPhaseWattsCs + $pair_circuit_phase_watts_calc_C;  // Takes prvious_total_phase_watts

				 echo 'This is for Phase C'.' pair_ratio_calc_C: '.$pair_ratio_calc_C.' pair_allowed_watts_calc_C: '.$pair_allowed_watts_calc_C.' pair_total_watts_calc_C: '.$pair_total_watts_calc_C.' pair_circuit_phase_va_calc_C: '.$pair_circuit_phase_va_calc_C.' pair_total_phase_va_calc_C: '.$pair_total_phase_va_calc_C.' pair_circuit_phase_watts_calc_C: '.$pair_circuit_phase_watts_calc_C.' pair_total_phase_watts_calc_C: '.$pair_total_phase_watts_calc_C.'<br>'.'<br>';

			}
			else {
				echo 'Something wong here';
			}
		
		} // end of for

	} else {
	    echo "sID is not in the Secondary Phase Table".'<br>';
		}
	}
	else {
		echo 'No previous values here'.'<br>';
		$ratio_calc = min($circuit_watts_calc,($circuit_watts_calc-max($circuit_watts_calc-$mau,0)))/$circuit_watts_calc; // will need to add previous current values of total watts here: max(PREVIOUS_TOTAL_WATTS + $circuit_watts_calc-$mau,0)
	    $allowed_watts_calc =  $ratio_calc * $circuit_watts_calc;
	    $total_watts_calc =  $ratio_calc * $circuit_watts_calc; // will need to add previous current values of total watts here: PREVIOUS_TOTAL_WATTS + $ratio_calc * $circuit_watts_calc
	    $circuit_phase_va_calc = $ratio_calc * $per_phase_va_calc; // Number for subtraction
	    $total_phase_va_calc = $circuit_phase_va_calc;// number for subtraction.  Will need to add previous current values of total phase va here: PREVIOUS_TOTAL_PHASE_VA  + $circuit_phase_va
	    $circuit_phase_watts_calc = $ratio_calc * $per_phase_watts_calc;
	    $total_phase_watts_calc = $circuit_phase_watts_calc;// will need to add previous current values of total phase watts here: TOTAL_PHASE_WATTS + $circuit_phase_watts.
	}


   // echo '# of Phases: '.$numOfPhases.'<br>'.'# of amps: '.$secondaryAmps.'<br>'.'MAU: '.$mau.'<br>'.'Circuit Watts: '.$circuit_watts_calc.'<br>'. 'Per phase va: '.$per_phase_va_calc.'<br>'.'Per phase watts: '.$per_phase_va_calc.'<br>'.'Ratio: '.$ratio_calc.'<br>'. 'Allowed watts: '.$allowed_watts_calc.'<br>'.'Total watts: '.$total_watts_calc.'<br>'.'Circuit phase va: '.$circuit_phase_va_calc.'<br>'.'Total phase va: '.$total_phase_va_calc.'<br>'.'Circuit phase watts: '.$circuit_phase_watts_calc.'<br>'.'Total phase watts: '.$total_phase_watts_calc.'<br>'; 


    $sql = "INSERT INTO secondaryphase (cID, sID, amps, numberOfPhases, phaseLetter, circuitWatts, perPhaseVa, perPhaseWatts,ratio_A, allowedWatts_A, totalWatts_A, circuitPhaseVa_A, totalPhaseVa_A, circuitPhaseWatts_A, totalPhaseWatts_A, ratio_B, allowedWatts_B , totalWatts_B , circuitPhaseVa_B , totalPhaseVa_B , circuitPhaseWatts_B , totalPhaseWatts_B , ratio_C, allowedWatts_C , totalWatts_C , circuitPhaseVa_C , totalPhaseVa_C , circuitPhaseWatts_C , totalPhaseWatts_C)VALUES(?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
   

	// echo '# of Phases: '.$numOfPhases . ' # of AMPs: '.$amps.' MAU: '.$mau;

	 if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
	mysqli_stmt_bind_param($stmt,"ssiisdddddddddddddddddddddddd", $cID, $sID, $amps, $numberOfPhases, $phaseLetter, $circuitWatts, $perPhaseVa, $perPhaseWatts, $ratio_A, $allowedWatts_A, $totalWatts_A, $circuitPhaseVa_A, $totalPhaseVa_A, $circuitPhaseWatts_A, $totalPhaseWatts_A, $ratio_B, $allowedWatts_B , $totalWatts_B , $circuitPhaseVa_B , $totalPhaseVa_B , $circuitPhaseWatts_B , $totalPhaseWatts_B , $ratio_C, $allowedWatts_C , $totalWatts_C , $circuitPhaseVa_C , $totalPhaseVa_C , $circuitPhaseWatts_C , $totalPhaseWatts_C);



		$cID = $secondaryCid;
		$sID = $secondarySid;
		$amps = $secondaryAmps;
		$numberOfPhases = $numOfPhases;
		$phaseLetter = $secondaryPhaseLetters; // $secondaryPhaseLetters with an s at the end is coming from GUI. $secondaryPhaseLetter w/o the s is an array to for the foreach below.
		$circuitWatts = $circuit_watts_calc;
		$perPhaseVa = $per_phase_va_calc;
		$perPhaseWatts = $per_phase_watts_calc; 

		// Assigns which phases get values in the DB
		foreach($secondaryPhaseLetter as $item){
			echo 'Phase '.$item.'<br>';			

			if($item == 'A'){
				if ($previousValueA == true){
					echo 'New pair of A has been set'.'<br>';

					$ratio_A = $pair_ratio_calc_A;
					$allowedWatts_A = $pair_allowed_watts_calc_A;
					$totalWatts_A = $pair_total_watts_calc_A;
					$circuitPhaseVa_A = $pair_circuit_phase_va_calc_A;
					$totalPhaseVa_A = $pair_total_phase_va_calc_A;
					$circuitPhaseWatts_A = $pair_circuit_phase_watts_calc_A;
					$totalPhaseWatts_A = $pair_total_phase_watts_calc_A;

				} else{
					echo 'Values of A has been set'.'<br>';
					$ratio_A = $ratio_calc;
					$allowedWatts_A = $allowed_watts_calc;
					$totalWatts_A = $total_watts_calc;
					$circuitPhaseVa_A = $circuit_phase_va_calc;
					$totalPhaseVa_A = $total_phase_va_calc;
					$circuitPhaseWatts_A = $circuit_phase_watts_calc;
					$totalPhaseWatts_A = $total_phase_watts_calc;

					echo 'Values of A has been set'.' ratio_A '.$ratio_A.' allowedWatts_A '.$allowedWatts_A.' totalWatts_A '.$totalWatts_A.' circuitPhaseVa_A '.$circuitPhaseVa_A.' totalPhaseVa_A '.$totalPhaseVa_A.' circuitPhaseWatts_A '.$circuitPhaseWatts_A.' totalPhaseWatts_A '.$totalPhaseWatts_A.'<br>';
				}
			}
			else if ($item == 'B'){
				if ($previousValueB == true){
					echo 'New pair of B has been set'.'<br>';

					$ratio_B = $pair_ratio_calc_B;
					$allowedWatts_B = $pair_allowed_watts_calc_B;
					$totalWatts_B = $pair_total_watts_calc_B;
					$circuitPhaseVa_B = $pair_circuit_phase_va_calc_B;
					$totalPhaseVa_B = $pair_total_phase_va_calc_B;
					$circuitPhaseWatts_B = $pair_circuit_phase_watts_calc_B;
					$totalPhaseWatts_B = $pair_total_phase_watts_calc_B;

				}else{
					echo 'Values of B has been set'.'<br>';
					$ratio_B = $ratio_calc;
					$allowedWatts_B = $allowed_watts_calc;
					$totalWatts_B = $total_watts_calc;
					$circuitPhaseVa_B = $circuit_phase_va_calc;
					$totalPhaseVa_B = $total_phase_va_calc;
					$circuitPhaseWatts_B = $circuit_phase_watts_calc;
					$totalPhaseWatts_B = $total_phase_watts_calc;
					echo 'Values of B has been set'.' ratio_B '.$ratio_B.' allowedWatts_B '.$allowedWatts_B.' totalWatts_B '.$totalWatts_B.' circuitPhaseVa_B '.$circuitPhaseVa_B.' totalPhaseVa_B '.$totalPhaseVa_B.' circuitPhaseWatts_B '.$circuitPhaseWatts_B.' totalPhaseWatts_B '.$totalPhaseWatts_B.'<br>';
				}
			}
			else if ($item == 'C'){

				if ($previousValueC == true){
					echo 'New pair of C has been set'.'<br>';
					$ratio_C = $pair_ratio_calc_C;
					$allowedWatts_C = $pair_allowed_watts_calc_C;
					$totalWatts_C = $pair_total_watts_calc_C;
					$circuitPhaseVa_C = $pair_circuit_phase_va_calc_C;
					$totalPhaseVa_C = $pair_total_phase_va_calc_C;
					$circuitPhaseWatts_C = $pair_circuit_phase_watts_calc_C;
					$totalPhaseWatts_C = $pair_total_phase_watts_calc_C;

				}else{
					//echo 'Values of C has been set'.'<br>';
					$ratio_C = $ratio_calc;
					$allowedWatts_C = $allowed_watts_calc;
					$totalWatts_C = $total_watts_calc;
					$circuitPhaseVa_C = $circuit_phase_va_calc;
					$totalPhaseVa_C = $total_phase_va_calc;
					$circuitPhaseWatts_C = $circuit_phase_watts_calc;
					$totalPhaseWatts_C = $total_phase_watts_calc;
					echo 'Values of C has been set'.' ratio_C '.$ratio_C.' allowedWatts_C '.$allowedWatts_C.' totalWatts_C '.$totalWatts_C.' circuitPhaseVa_C '.$circuitPhaseVa_C.' totalPhaseVa_C '.$totalPhaseVa_C.' circuitPhaseWatts_C '.$circuitPhaseWatts_C.' totalPhaseWatts_C '.$totalPhaseWatts_C.'<br>';
				}
			}
			else {
				echo 'Something wong here';
			}
		
		}

/*
 	 //To insert NULL VALUES, if not by default		
		 if($counter != 3 ){
		 	$differenceInArrays = array_diff($emptyArray,$testPhase);
			 print_r($differenceInArrays);
			 echo '<br>';
			 echo '<br>';

			 // ************************* change this to Switch statements *************************
		 	foreach($differenceInArrays as $nulls){
		 		if($nulls == 'A'){
						echo 'NULL values of A has been set'.'<br>';
					}
					else if ($nulls == 'B'){
						echo 'NULL values of B has been set'.'<br>';
					}
					else if ($nulls == 'C'){
						echo 'NULL values of C has been set'.'<br>';
					}
					else {
						echo 'Something wong here in NULLS';
					}
				}
 		}
*/ 



			mysqli_stmt_execute($stmt);

	    echo "Records inserted successfully.";

	} 

	else{
	    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);


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

	    echo 'Records inserted successfully.'.'<br>';
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


function returner($aa,$ratioAs,$totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs) {



	// return array($row["numberOfPhases"], $row["ratio_A"], $row["totalWatts_A"], $row["totalPhaseVa_A"],$row["totalPhaseWatts_A"], $row["ratio_B"], $row["totalWatts_B"], $row["totalPhaseVa_B"],$row["totalPhaseWatts_B"], $row["ratio_C"], $row["totalWatts_C"], $row["totalPhaseVa_C"],$row["totalPhaseWatts_C"]);


	return array($aa,$ratioAs,$totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

}




?>







