<?php


include 'connect.inc.php';


$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//checks connection
if ($connection->connect_error) die($connection->connect_error);
$primaryCid = 2091;
$primaryLocation = '212.1';
$primaryRow = '1';
$primaryCab = '12';

// $sql to query the lastest cab power product that was inserted 
$checkCabs = "SELECT sID, cID, location, row, cab FROM primarypowerproduct where cID=$primaryCid AND location=$primaryLocation AND row=$primaryRow AND cab=$primaryCab ORDER BY sID DESC LIMIT 1" ;
$result = $connection->query($checkCabs);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {


    	$sid = $row["sID"];
    	echo $sid;

/*         
    	$row["cID"];
    	$row["location"];
    	$row["row"];
    	$row["cab"];
*/



/* variables to recalculate

 ratio_calc = min($circuit_watts_calc,($circuit_watts_calc-max(PREVIOUS_TOTAL_WATTS + $circuit_watts_calc-$mau,0)))/$circuit_watts_calc   // Takes previous_total_watts


 $total_watts_calc = PREVIOUS_TOTAL_WATTS + $ratio_calc * $circuit_watts_calc   // Takes previous_total_watts


 $total_phase_va_calc = PREVIOUS_TOTAL_PHASE_VA  + $circuit_phase_va   // Takes prvious_total_phase_va


 $total_phase_watts_calc = PREVIOUS_TOTAL_PHASE_WATTS + $circuit_phase_watts  // Takes prvious_total_phase_watts

*/





        //  echo "cID: " . $row["cID"]. " sID ".$row["sID"]." - Location: " . $row["location"]. "Row " . $row["row"]."Cab ".$row["cab"]. "<br>";
    }

  	// $sqlPhase for using the lastest power product 
$sqlPhase = "SELECT sID, numberOfPhases, phaseLetter, ratio_A,  totalWatts_A, totalPhaseVa_A, totalPhaseWatts_A, ratio_B,  totalWatts_B ,  totalPhaseVa_B ,  totalPhaseWatts_B , ratio_C,  totalWatts_C , totalPhaseVa_C , totalPhaseWatts_C FROM primaryphase where sID=$sid";

$result = $connection->query($sqlPhase);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

    $aa =$row["numberOfPhases"];
	$bb =$row["ratio_A"];
	$cc =$row["totalWatts_A"];
	$dd =$row["totalPhaseVa_A"];
	$ee =$row["totalPhaseWatts_A"];
	$ff =$row["ratio_B"];
	$gg =$row["totalWatts_B"];
	$hh =$row["totalPhaseVa_B"];
	$ii =$row["totalPhaseWatts_B"];
	$jj =$row["ratio_C"];
	$kk =$row["totalWatts_C"];
	$ll =$row["totalPhaseVa_C"];
	$mm = $row["totalPhaseWatts_C"];
	//echo 'Doubles'.$aa.' '.$bb.' '.$cc.' '.$dd.' '.$ee.' '.$ff.' '.$gh.' '.$hh.' '.$ii.' '.$jj.' '.$kk.' '.$ll.' '.$mm.'<br';

	list($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m) = returner($aa,$bb,$cc,$dd,$ee,$ff,$gg,$hh,$ii,$jj,$kk,$ll,$mm);

    	//echo "sID: " . $row["sID"]. " numberOfPhases: ".$row["numberOfPhases"]." ratio_A: " . $row["ratio_A"]. " totalWatts_A: " . $row["totalWatts_A"]." totalPhaseVa_A: ".$row["totalPhaseVa_A"]." totalPhaseWatts_A: ".$row["totalPhaseWatts_A"]. " ratio_B: " . $row["ratio_B"]. " totalWatts_B: ".$row["totalWatts_B"]."  totalPhaseVa_B: " . $row["totalPhaseVa_B"]. " totalPhaseWatts_B: " . $row["totalPhaseWatts_B"]." ratio_C: ".$row["ratio_C"]." totalWatts_C: ".$row["totalWatts_C"]."   totalPhaseVa_C: " . $row["totalPhaseVa_C"]. " totalPhaseWatts_C: " . $row["totalPhaseWatts_C"]."<br>";

  }
  echo 'Singles: '.$a.' '.$b.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h.' '.$i.' '.$j.' '.$k.' '.$l.' '.$m;
}else {
    echo "sID is not in the Primary Phase Table";
}

//echo 'Singles: '.$a.' '.$b.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h.' '.$i.' '.$j.' '.$k.' '.$l.' '.$m;
} else {
    echo "0 results";
}



//echo $sid;
$connection->close();

function returner($aa,$bb,$cc,$dd,$ee,$ff,$gg,$hh,$ii,$jj,$kk,$ll,$mm) {



	// return array($row["numberOfPhases"], $row["ratio_A"], $row["totalWatts_A"], $row["totalPhaseVa_A"],$row["totalPhaseWatts_A"], $row["ratio_B"], $row["totalWatts_B"], $row["totalPhaseVa_B"],$row["totalPhaseWatts_B"], $row["ratio_C"], $row["totalWatts_C"], $row["totalPhaseVa_C"],$row["totalPhaseWatts_C"]);


	return array($aa,$bb,$cc,$dd,$ee,$ff,$gg,$hh,$ii,$jj,$kk,$ll,$mm);

}


?>