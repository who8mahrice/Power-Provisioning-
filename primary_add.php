<?php
//session_start();
include 'connect.inc.php';

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);


//checks connection
if ($connection->connect_error) die($connection->connect_error);





if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	echo '<script>';
	echo 'alert("Primary add is primary!")';
	echo '</script>';
	//if ($_POST['button'] == 'primary') {
	//	echo '<script>';
	//echo 'alert("Whoa this Primary isset works")';
	//echo '</script>';
	if (isset($_POST['primaryCid']) && !empty($_POST['primaryCid']) 
		&& isset($_POST['primarySid']) &&  !empty($_POST['primarySid'])
		&& isset($_POST['primaryRpp']) && !empty($_POST['primaryRpp']) 
		&& isset($_POST['primaryPanel']) &&  !empty($_POST['primaryPanel'])
		&& isset($_POST['primaryPowerType']) && !empty($_POST['primaryPowerType']) 
		&& isset($_POST['primaryPhaseLetters']) &&  !empty($_POST['primaryPhaseLetters'])
		&& isset($_POST['primaryLocation']) && !empty($_POST['primaryLocation']) 
		&& isset($_POST['primaryRow']) &&  !empty($_POST['primaryRow'])
		&& isset($_POST['primaryCab']) && !empty($_POST['primaryCab']) 
		&& isset($_POST['primaryMau']))
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

			//echo 'Its in the DB';
			
			calculatePrimaryPower($primaryCid, $primarySid, $primaryPowerType, $primaryPhaseLetters,$primaryLocation, $primaryRow, $primaryCab, $primaryMau, $connection, $primaryRpp, $primaryPanel);

			addPrimaryPower($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryPhaseLetters,$primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection);

			reserveSecondary($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryPhaseLetters, $primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection);

			$connection->close();
			unset($_POST);
			$_POST = array();

			//session_unset();
			//session_destroy();
		} 
		else{
			echo 'Please fill in all the Primary fields';
		}

	//$connection->close();
	//}
}




function calculatePrimaryPower($primaryCid, $primarySid, $primaryPowerType, $primaryPhaseLetters,$primaryLocation, $primaryRow, $primaryCab, $primaryMau, $connection, $primaryRpp, $primaryPanel) {
	echo '<script>';
	echo 'alert("In the calculate POWER!")';
	echo '</script>';

	$previousValues = false;
	$previousValueA = false;
	$previousValueB = false;
	$previousValueC = false;

	$ppl = $primaryPhaseLetters;
	$primaryPhaseLetter = explode( "," , $primaryPhaseLetters);
	$numOfPhases = count($primaryPhaseLetter);
	$primaryAmps = (int)substr($primaryPowerType,0, -4);
	$mau = $primaryMau;

	$circuit_watts_calc = $primaryAmps*120*pow(sqrt(3),$numOfPhases-1)*0.8;
	$per_phase_va_calc = 120*$primaryAmps*0.8;
	$per_phase_watts_calc = $circuit_watts_calc/$numOfPhases;

	/* =========================================== MAIN =========================================== */
	$rpp = $primaryRpp;
	$name = $primaryPanel; // USER INPUT Panel Name.

	$grabMain="SELECT a.mainName, a.phaseA, a.phaseB, a.phaseC FROM primaryMain a, primaryPanel b, primaryRPP c, primarySection d WHERE d.panelName ='$name' AND c.panelName ='$name' AND b.panelName ='$name' AND b.mainName=a.mainName";

	$resultMain = $connection->query($grabMain);

	if ($resultMain->num_rows > 0) { //(
	    while($row = $resultMain->fetch_assoc()) {

	    	$main = $row["mainName"];
	    	$phaseA_Main = $row["phaseA"];
	    	$phaseB_Main = $row["phaseB"];
	    	$phaseC_Main = $row["phaseC"];

	    	//echo 'Main Panel: '.$main.' Phase A: '.$phaseA_Main.' Phase B: '.$phaseB_Main.' Phase C: '.$phaseC_Main.'<br>';
	  }
	} //)
	else {
		echo 'No main query here'.'<br>';
	}

	/* =========================================== Section =========================================== */
	$grabSection = "SELECT panelName, PhaseA, PhaseB, PhaseC, PhaseAB, PhaseBC, PhaseAC, PhaseABC, Phase_Left_A, Phase_Left_B, Phase_Left_C FROM primarysection where panelName='$name'";

	$resultSection = $connection->query($grabSection);

	if ($resultSection->num_rows > 0) { //(
	    while($row = $resultSection->fetch_assoc()) {

	    	$panel = $row["panelName"];
	    	$PhaseA_Section = $row["PhaseA"];
	    	$PhaseB_Section = $row["PhaseB"];
	    	$PhaseC_Section = $row["PhaseC"];
	    	$PhaseAB_Section = $row["PhaseAB"];
	    	$PhaseBC_Section = $row["PhaseBC"];
	    	$PhaseAC_Section = $row["PhaseAC"];
	    	$PhaseABC_Section = $row["PhaseABC"];
	    	$Phase_Left_A = $row["Phase_Left_A"];
	    	$Phase_Left_B = $row["Phase_Left_B"];
	    	$Phase_Left_C = $row["Phase_Left_C"];

	    	echo 'Panel: '.$panel.' Phase A: '.$PhaseA_Section.' Phase B: '.$PhaseB_Section.' Phase C: '.$PhaseC_Section.' Phase AB: '.$PhaseAB_Section.' Phase BC: '.$PhaseBC_Section.' Phase AC: '.$PhaseAC_Section.' Phase ABC: '.$PhaseABC_Section.' Phase_Left_A: '.$Phase_Left_A.' Phase_Left_B: '.$Phase_Left_B.' Phase_Left_C: '.$Phase_Left_C.'<br>'.'<br>';
	  }
	} //)
	else {
		echo 'No panel here'.'<br>';
	}





	/* =========================================== Previous Power Check =========================================== */
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
		



		list($a,$ratioA,$totalWattsA,$totalPhaseVaA,$totalPhaseWattsA,$ratioB,$totalWattsB,$totalPhaseVaB,$totalPhaseWattsB,$ratioC,$totalWattsC,$totalPhaseVaC,$totalPhaseWattsC) = returner($aa,$ratioAs, $totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

	    	//echo "sID: " . $row["sID"]. " numberOfPhases: ".$row["numberOfPhases"]." ratio_A: " . $row["ratio_A"]. " totalWatts_A: " . $row["totalWatts_A"]." totalPhaseVa_A: ".$row["totalPhaseVa_A"]." totalPhaseWatts_A: ".$row["totalPhaseWatts_A"]. " ratio_B: " . $row["ratio_B"]. " totalWatts_B: ".$row["totalWatts_B"]."  totalPhaseVa_B: " . $row["totalPhaseVa_B"]. " totalPhaseWatts_B: " . $row["totalPhaseWatts_B"]." ratio_C: ".$row["ratio_C"]." totalWatts_C: ".$row["totalWatts_C"]."   totalPhaseVa_C: " . $row["totalPhaseVa_C"]. " totalPhaseWatts_C: " . $row["totalPhaseWatts_C"]."<br>";

	  } // end of while

	 //echo 'Singles: '.$a.' '.$ratioA.' '.$totalWattsA.' '.$totalPhaseVaA.' '.$totalPhaseWattsA.' '.$ratioB.' '.$totalWattsB.' '.$totalPhaseVaB.' '.$totalPhaseWattsB.' '.$ratioC.' '.$totalWattsC.' '.$totalPhaseVaC.' '.$totalPhaseWattsC.'<br>';


	  	$oldTotalPhaseVaSection_A = $totalPhaseVaAs;
	  	$oldTotalPhaseVaSection_B = $totalPhaseVaBs;
	  	$oldTotalPhaseVaSection_C = $totalPhaseVaCs;

	  	// foreach is to assign the values to seperate phases
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

				 // For section values:
			  	$newTotalPhaseVaSection_A = $pair_total_phase_va_calc_A;

//				 echo 'This is for Phase A'.' pair_ratio_calc_A: '.$pair_ratio_calc_A.' pair_allowed_watts_calc_A: '.$pair_allowed_watts_calc_A.' pair_total_watts_calc_A: '.$pair_total_watts_calc_A.' pair_circuit_phase_va_calc_A: '.$pair_circuit_phase_va_calc_A.' pair_total_phase_va_calc_A: '.$pair_total_phase_va_calc_A.' pair_circuit_phase_watts_calc_A: '.$pair_circuit_phase_watts_calc_A.' pair_total_phase_watts_calc_A: '.$pair_total_phase_watts_calc_A.'<br>'.'<br>';

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

				 // For section values:
			  	$newTotalPhaseVaSection_B = $pair_total_phase_va_calc_B;

//				 echo 'This is for Phase B'.' pair_ratio_calc_B: '.$pair_ratio_calc_B.' pair_allowed_watts_calc_B: '.$pair_allowed_watts_calc_B.' pair_total_watts_calc_B: '.$pair_total_watts_calc_B.' pair_circuit_phase_va_calc_B: '.$pair_circuit_phase_va_calc_B.' pair_total_phase_va_calc_B: '.$pair_total_phase_va_calc_B.' pair_circuit_phase_watts_calc_B: '.$pair_circuit_phase_watts_calc_B.' pair_total_phase_watts_calc_B: '.$pair_total_phase_watts_calc_B.'<br>'.'<br>';

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

				 // For section values:
			  	$newTotalPhaseVaSection_C = $pair_total_phase_va_calc_C;

//				 echo 'This is for Phase C'.' pair_ratio_calc_C: '.$pair_ratio_calc_C.' pair_allowed_watts_calc_C: '.$pair_allowed_watts_calc_C.' pair_total_watts_calc_C: '.$pair_total_watts_calc_C.' pair_circuit_phase_va_calc_C: '.$pair_circuit_phase_va_calc_C.' pair_total_phase_va_calc_C: '.$pair_total_phase_va_calc_C.' pair_circuit_phase_watts_calc_C: '.$pair_circuit_phase_watts_calc_C.' pair_total_phase_watts_calc_C: '.$pair_total_phase_watts_calc_C.'<br>'.'<br>';

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

	    // For section values:
	    $newTotalPhaseVaSection = $total_phase_va_calc;

	}

// End of checking for previous values

   // echo '# of Phases: '.$numOfPhases.'<br>'.'# of amps: '.$primaryAmps.'<br>'.'MAU: '.$mau.'<br>'.'Circuit Watts: '.$circuit_watts_calc.'<br>'. 'Per phase va: '.$per_phase_va_calc.'<br>'.'Per phase watts: '.$per_phase_va_calc.'<br>'.'Ratio: '.$ratio_calc.'<br>'. 'Allowed watts: '.$allowed_watts_calc.'<br>'.'Total watts: '.$total_watts_calc.'<br>'.'Circuit phase va: '.$circuit_phase_va_calc.'<br>'.'Total phase va: '.$total_phase_va_calc.'<br>'.'Circuit phase watts: '.$circuit_phase_watts_calc.'<br>'.'Total phase watts: '.$total_phase_watts_calc.'<br>'; 


	$differenceTotalPhaseVaSection_A;
	$differenceTotalPhaseVaSection_B;
	$differenceTotalPhaseVaSection_C;
	$TotalPhaseVaSection_A;
	$TotalPhaseVaSection_B;
	$TotalPhaseVaSection_C;


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

					// For section values:
					$differenceTotalPhaseVaSection_A = $newTotalPhaseVaSection_A - $oldTotalPhaseVaSection_A; // takes the old total phase va and minues with the new total phase va.

					// $TotalPhaseVaSection_A = ($oldTotalPhaseVaSection_A + $differenceTotalPhaseVaSection_A)/1000; // take the difference and adds it to old value.

					// $Phase_Left_A = $Phase_Left_A - $TotalPhaseVaSection_A; // final result value, to be updated in DB. For new values that have previous values (Two pairs in a cab)
					$Phase_Left_A = $Phase_Left_A - ($differenceTotalPhaseVaSection_A/1000); // final result value, to be updated in DB. For new values that have previous values (Two pairs in a cab)



					// Minus the number of phase letters left
					//$PhaseA_Section = $PhaseA_Section - 1;



					echo "--------------- The phase main BEFORE: ".$phaseA_Main;
					// For main values:
					$phaseA_Main = $phaseA_Main - ($differenceTotalPhaseVaSection_A/1000); // final result values, to be updated in DB   ------DOUBLE CHECK THIS
					echo " and this is the phase main AFTER ".$phaseA_Main."with a difference of ".($differenceTotalPhaseVaSection_A/1000)." ---------------".'<br>';



				} else{
					echo 'Values of A has been set'.'<br>';
					$ratio_A = $ratio_calc;
					$allowedWatts_A = $allowed_watts_calc;
					$totalWatts_A = $total_watts_calc;
					$circuitPhaseVa_A = $circuit_phase_va_calc;
					$totalPhaseVa_A = $total_phase_va_calc;
					$circuitPhaseWatts_A = $circuit_phase_watts_calc;
					$totalPhaseWatts_A = $total_phase_watts_calc;

					// For section values:
					$Phase_Left_A = $Phase_Left_A - ($newTotalPhaseVaSection/1000); // final result value, to be updated in DB. For new values
					// Minus the number of phase letters left
					//$PhaseA_Section = $PhaseA_Section - 1;

					// For main values:
					$phaseA_Main = $phaseA_Main - ($newTotalPhaseVaSection/1000);



//					echo 'Values of A has been set'.' ratio_A '.$ratio_A.' allowedWatts_A '.$allowedWatts_A.' totalWatts_A '.$totalWatts_A.' circuitPhaseVa_A '.$circuitPhaseVa_A.' totalPhaseVa_A '.$totalPhaseVa_A.' circuitPhaseWatts_A '.$circuitPhaseWatts_A.' totalPhaseWatts_A '.$totalPhaseWatts_A.'<br>';
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

					// For section values:
					$differenceTotalPhaseVaSection_B = $newTotalPhaseVaSection_B - $oldTotalPhaseVaSection_B; // takes the old total phase va and minues with the new total phase va.

					//$TotalPhaseVaSection_B = ($oldTotalPhaseVaSection_B + $differenceTotalPhaseVaSection_B)/1000; // take the difference and adds it to old value.

					//$Phase_Left_B = $Phase_Left_B - $TotalPhaseVaSection_B; // final result value, to be updated in DB. For new values that have previous values (Two pairs in a cab)

					$Phase_Left_B = $Phase_Left_B - ($differenceTotalPhaseVaSection_B/1000); // final result value, to be updated in DB. For new values that have previous values (Two pairs in a cab)


					// Minus the number of phase letters left
					//$PhaseB_Section = $PhaseB_Section - 1;

					echo "--------------- The phase main BEFORE: ".$phaseB_Main;
					// For main values:
					$phaseB_Main = $phaseB_Main - ($differenceTotalPhaseVaSection_B/1000); // final result values, to be updated in DB   ------DOUBLE CHECK THIS
					echo " and this is the phase main AFTER ".$phaseB_Main."with a difference of ".($differenceTotalPhaseVaSection_B/1000)." ---------------".'<br>';

				}else{
					echo 'Values of B has been set'.'<br>';
					$ratio_B = $ratio_calc;
					$allowedWatts_B = $allowed_watts_calc;
					$totalWatts_B = $total_watts_calc;
					$circuitPhaseVa_B = $circuit_phase_va_calc;
					$totalPhaseVa_B = $total_phase_va_calc;
					$circuitPhaseWatts_B = $circuit_phase_watts_calc;
					$totalPhaseWatts_B = $total_phase_watts_calc;

					// For section values:
					$Phase_Left_B = $Phase_Left_B - ($newTotalPhaseVaSection/1000); // final result value, to be updated in DB. For new values
					// Minus the number of phase letters left
					//$PhaseB_Section = $PhaseB_Section - 1;

					// For main values:
					$phaseB_Main = $phaseB_Main - ($newTotalPhaseVaSection/1000);


//					echo 'Values of B has been set'.' ratio_B '.$ratio_B.' allowedWatts_B '.$allowedWatts_B.' totalWatts_B '.$totalWatts_B.' circuitPhaseVa_B '.$circuitPhaseVa_B.' totalPhaseVa_B '.$totalPhaseVa_B.' circuitPhaseWatts_B '.$circuitPhaseWatts_B.' totalPhaseWatts_B '.$totalPhaseWatts_B.'<br>';
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

					// For section values:
					$differenceTotalPhaseVaSection_C = $newTotalPhaseVaSection_C - $oldTotalPhaseVaSection_C; // takes the old total phase va and minues with the new total phase va.

					//$TotalPhaseVaSection_C = ($oldTotalPhaseVaSection_C + $differenceTotalPhaseVaSection_C)/1000; // take the difference and adds it to old value.

					//$Phase_Left_C = $Phase_Left_C - $TotalPhaseVaSection_C; // final result value, to be updated in DB. For new values that have previous values (Two pairs in a cab)
					$Phase_Left_C = $Phase_Left_C - ($differenceTotalPhaseVaSection_C/1000); // final result value, to be updated in DB. For new values that have previous values (Two pairs in a cab)


					// Minus the number of phase letters left
					//$PhaseC_Section = $PhaseC_Section - 1;

					echo "--------------- The phase main BEFORE: ".$phaseC_Main;
					// For main values:
					$phaseC_Main = $phaseC_Main - ($differenceTotalPhaseVaSection_C/1000); // final result values, to be updated in DB   ------DOUBLE CHECK THIS
					echo " and this is the phase main AFTER ".$phaseC_Main."with a difference of ".($differenceTotalPhaseVaSection_C/1000)." ---------------".'<br>';


				}else{
					//echo 'Values of C has been set'.'<br>';
					$ratio_C = $ratio_calc;
					$allowedWatts_C = $allowed_watts_calc;
					$totalWatts_C = $total_watts_calc;
					$circuitPhaseVa_C = $circuit_phase_va_calc;
					$totalPhaseVa_C = $total_phase_va_calc;
					$circuitPhaseWatts_C = $circuit_phase_watts_calc;
					$totalPhaseWatts_C = $total_phase_watts_calc;


					// For section values:
					$Phase_Left_C = $Phase_Left_C - ($newTotalPhaseVaSection/1000); // final result value, to be updated in DB. For new values
					// Minus the number of phase letters left
					//$PhaseC_Section = $PhaseC_Section - 1;

					// For main values:
					$phaseC_Main = $phaseC_Main - ($newTotalPhaseVaSection/1000);

//					echo 'Values of C has been set'.' ratio_C '.$ratio_C.' allowedWatts_C '.$allowedWatts_C.' totalWatts_C '.$totalWatts_C.' circuitPhaseVa_C '.$circuitPhaseVa_C.' totalPhaseVa_C '.$totalPhaseVa_C.' circuitPhaseWatts_C '.$circuitPhaseWatts_C.' totalPhaseWatts_C '.$totalPhaseWatts_C.'<br>';
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
 		//minus section here
 		switch ($ppl) {
	    case "A":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
	        $PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "B":
	        $PhaseB_Section = $PhaseB_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
			$PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "C":
	        $PhaseC_Section = $PhaseC_Section - 1;
	        $PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;        		
	    case "A,B":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseB_Section = $PhaseB_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
			$PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "B,C":
	    	$PhaseB_Section = $PhaseB_Section - 1;
	    	$PhaseC_Section = $PhaseC_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
	        $PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "A,C":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseC_Section = $PhaseC_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
	        $PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "A,B,C":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseB_Section = $PhaseB_Section - 1;
	    	$PhaseC_Section = $PhaseC_Section - 1;
			$PhaseAB_Section = $PhaseAB_Section - 1;
			$PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;    
	    default:
	        echo "No Phase Letter Selected".'<br>';
}



			mysqli_stmt_execute($stmt);

			// UPDATE SECTION
			$updateSection = "UPDATE primarysection SET PhaseA=?, PhaseB=?, PhaseC=?, PhaseAB=?, PhaseBC=?, PhaseAC=?, PhaseABC=?, Phase_Left_A=?, Phase_Left_B=?, Phase_Left_C=? WHERE panelName=?";

 //$section = "update primarysection set (PhaseA,PhaseB,PhaseC,Phase_Left_A,Phase_Left_B,Phase_Left_C) VALUES(?,?,?,?,?,?) where ";


    if($stmtSection = mysqli_prepare($connection, $updateSection)){
    // Bind variables to the prepared statement as parameters
	mysqli_stmt_bind_param($stmtSection,"iiiiiiiddds", $PhaseA_Section,$PhaseB_Section,$PhaseC_Section,$PhaseAB_Section, $PhaseBC_Section, $PhaseAC_Section, $PhaseABC_Section, $Phase_Left_A,$Phase_Left_B,$Phase_Left_C,$panel);

			mysqli_stmt_execute($stmtSection);
}



			// UPDATE MAIN
			$updateMain = "UPDATE primarymain SET phaseA=?, phaseB=?, phaseC=? WHERE mainName=?";

	 if($stmtMain = mysqli_prepare($connection, $updateMain)){
    // Bind variables to the prepared statement as parameters
	mysqli_stmt_bind_param($stmtMain,"ddds", $phaseA_Main,$phaseB_Main,$phaseC_Main,$main);

			mysqli_stmt_execute($stmtMain);
			
	} 
	else {
		echo 'Unable to connect'.'<br>';
	}


	    echo "Records inserted successfully.".'<br>';



	} 

	else{
	    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);


}


function addPrimaryPower($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryPhaseLetters, $primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection){


 $sql = "INSERT INTO primarypowerproduct (cID, sID, panelName, power_type, phaseLetter, mau, location, row, cab)VALUES(?, ?, ?, ?, ?,?, ?, ?, ?)";

//iissdsii
   if($stmt = mysqli_prepare($connection, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt,"sssssisss", $cID,$sID,$panelName,$power_type,$phaseLetter, $mau,$location,$row,$cab);

    

    		$cID = $primaryCid;
			$sID = $primarySid;
			$panelName = $primaryPanel;
			$power_type = $primaryPowerType;
			$phaseLetter = $primaryPhaseLetters;
			$mau = $primaryMau;
			$location = $primaryLocation;
			$row = $primaryRow;
			$cab = $primaryCab;
			mysqli_stmt_execute($stmt);

	    echo '-PRIMARY- Customer: ['.$cID.'] '.'sID: s'.$sID.'Location: '.$location.':'.$row.':'.$cab.'<br>';
	} else{
	    echo "-PRIMARY- ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($stmt);

    //unset($_POST);
    //echo "<meta http-equiv='refresh' content='2'>";
}


function returner($aa,$ratioAs,$totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs) {



	// return array($row["numberOfPhases"], $row["ratio_A"], $row["totalWatts_A"], $row["totalPhaseVa_A"],$row["totalPhaseWatts_A"], $row["ratio_B"], $row["totalWatts_B"], $row["totalPhaseVa_B"],$row["totalPhaseWatts_B"], $row["ratio_C"], $row["totalWatts_C"], $row["totalPhaseVa_C"],$row["totalPhaseWatts_C"]);


	return array($aa,$ratioAs,$totalWattsAs,$totalPhaseVaAs,$totalPhaseWattsAs,$ratioBs,$totalWattsBs,$totalPhaseVaBs,$totalPhaseWattsBs,$ratioCs,$totalWattsCs,$totalPhaseVaCs,$totalPhaseWattsCs);

}

//reserveSecondary($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryPhaseLetters, $primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection);

function reserveSecondary($primaryCid,$primarySid,$primaryPanel,$primaryPowerType,$primaryPhaseLetters, $primaryMau,$primaryLocation,$primaryRow,$primaryCab,$connection){

	
	// Insert into Secondary Power Product
	$secondaryPowerProduct = "INSERT INTO secondarypowerproduct (cID, sID, panelName, power_type, phaseLetter, mau, location, row, cab)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";


   if($setPowerProduct = mysqli_prepare($connection, $secondaryPowerProduct)){
    // Bind variables to the prepared statement as parameters
    //mysqli_stmt_bind_param($setPowerProduct,"sssssisss", $cID,$sID,$panelName,$power_type,$phaseLetter, $mau,$location,$row,$cab);
    mysqli_stmt_bind_param($setPowerProduct,"sssssisss", $cID,$sID,$panelName,$power_type,$phaseLetter, $mau,$location,$row,$cab);

    

    		$cID = $primaryCid;
			$sID = $primarySid;
			$panelName = $primaryPanel;
			$power_type = $primaryPowerType;
			$phaseLetter = $primaryPhaseLetters;
			$mau = $primaryMau;
			$location = $primaryLocation;
			$row = $primaryRow;
			$cab = $primaryCab;

			$sID = "reserv";
			$mau = 0;

			// Regex for converting primaryPanel to secondaryPanel;
			$convertToSecondaryPanel = $primaryPanel;
			$panelName = str_replace("-P","-S", $convertToSecondaryPanel);

			mysqli_stmt_execute($setPowerProduct);

	    //echo 'Records inserted successfully.'.'<br>';
	} else{
	    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($connection);
	}

	mysqli_stmt_close($setPowerProduct);

/*
	// Regex for converting primaryPanel to secondaryPanel;
	$convertToSecondaryPanel = $primaryPanel;
	$secondaryPanel = str_replace("-P","-S", $convertToSecondaryPanel);
*/
	// secondary phase letters
	$ppl = $phaseLetter;

	//echo 'This is the Phase '.$ppl.' in Panel '.$secondaryPanel;

	// Query Secondary Section --------------------------------------------------
	$grabSection = "SELECT panelName, PhaseA, PhaseB, PhaseC, PhaseAB, PhaseBC, PhaseAC, PhaseABC, Phase_Left_A, Phase_Left_B, Phase_Left_C FROM secondarysection where panelName='$panelName'";

	$resultSection = $connection->query($grabSection);

	if ($resultSection->num_rows > 0) { //(
	    while($row = $resultSection->fetch_assoc()) {

	    	$panel = $row["panelName"];
	    	$PhaseA_Section = $row["PhaseA"];
	    	$PhaseB_Section = $row["PhaseB"];
	    	$PhaseC_Section = $row["PhaseC"];
	    	$PhaseAB_Section = $row["PhaseAB"];
	    	$PhaseBC_Section = $row["PhaseBC"];
	    	$PhaseAC_Section = $row["PhaseAC"];
	    	$PhaseABC_Section = $row["PhaseABC"];
	    	$Phase_Left_A = $row["Phase_Left_A"];
	    	$Phase_Left_B = $row["Phase_Left_B"];
	    	$Phase_Left_C = $row["Phase_Left_C"];

	    	//echo 'Panel: '.$panel.' Phase A: '.$PhaseA_Section.' Phase B: '.$PhaseB_Section.' Phase C: '.$PhaseC_Section.' Phase AB: '.$PhaseAB_Section.' Phase BC: '.$PhaseBC_Section.' Phase AC: '.$PhaseAC_Section.' Phase ABC: '.$PhaseABC_Section.' Phase_Left_A: '.$Phase_Left_A.' Phase_Left_B: '.$Phase_Left_B.' Phase_Left_C: '.$Phase_Left_C.'<br>'.'<br>';
	  }
	} //)
	else {
		echo 'No panel here'.'<br>';
	}

	// Update values into Secondary Section --------------------------------------------------
	switch ($ppl) {
	    case "A":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
	        $PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "B":
	        $PhaseB_Section = $PhaseB_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
			$PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "C":
	        $PhaseC_Section = $PhaseC_Section - 1;
	        $PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;        		
	    case "A,B":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseB_Section = $PhaseB_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
			$PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "B,C":
	    	$PhaseB_Section = $PhaseB_Section - 1;
	    	$PhaseC_Section = $PhaseC_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
	        $PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "A,C":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseC_Section = $PhaseC_Section - 1;
	        $PhaseAB_Section = $PhaseAB_Section - 1;
	        $PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;
	    case "A,B,C":
	        $PhaseA_Section = $PhaseA_Section - 1;
	        $PhaseB_Section = $PhaseB_Section - 1;
	    	$PhaseC_Section = $PhaseC_Section - 1;
			$PhaseAB_Section = $PhaseAB_Section - 1;
			$PhaseBC_Section = $PhaseBC_Section - 1;
			$PhaseAC_Section = $PhaseAC_Section - 1;
			$PhaseABC_Section = $PhaseABC_Section - 1;
	        break;    
	    default:
	        echo "No Phase Letter Selected".'<br>';
}

	// No updates to $Phase_Left_A, $Phase_Left_B, and $Phase_Left_C in this function. -- go back to here maybe later?
	$secondarySection = "UPDATE secondarysection SET PhaseA=?, PhaseB=?, PhaseC=?, PhaseAB=?, PhaseBC=?, PhaseAC=?, PhaseABC=?, Phase_Left_A=?, Phase_Left_B=?, Phase_Left_C=? WHERE panelName=?";

	if($setSection = mysqli_prepare($connection, $secondarySection)){
    // Bind variables to the prepared statement as parameters
	mysqli_stmt_bind_param($setSection,"iiiiiiiddds", $PhaseA_Section,$PhaseB_Section,$PhaseC_Section,$PhaseAB_Section, $PhaseBC_Section, $PhaseAC_Section, $PhaseABC_Section, $Phase_Left_A,$Phase_Left_B,$Phase_Left_C,$secondaryPanel);

			mysqli_stmt_execute($setSection);
     }
}


function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}




?>

<!--
<style type="text/css">
#dis{
	display:none;
}
</style>

<div id="dis">

</div>
-->