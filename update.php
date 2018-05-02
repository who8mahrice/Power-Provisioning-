<?php
session_start();

require_once 'dbconfig.php';
require_once 'connect.inc.php';

$goodToGo = true;
$message = " ";

	
	if($_POST)
	{
		if(isset($_POST['editCid']) && !empty($_POST['editCid'])
			&& isset($_POST['editLocation']) && !empty($_POST['editLocation'])
			&& isset($_POST['editSid']) && !empty($_POST['editSid'])
			// && isset($_POST['editRpp']) && !empty($_POST['editRpp'])
			// && isset($_POST['editPanel']) && !empty($_POST['editPanel'])
			// && isset($_POST['editPowerType']) && !empty($_POST['editPowerType'])
			// && isset($_POST['editPhaseLetters']) && !empty($_POST['editPhaseLetters'])
			&& isset($_POST['editRow']) && !empty($_POST['editRow'])
			&& isset($_POST['editCab']) && !empty($_POST['editCab'])
			&& isset($_POST['editMau']) && !empty($_POST['editMau']))
		{
			debug_to_console("In Update.exe");

			$updateCid = $_POST['editCid'];
			$updateLocation = $_POST['editLocation'];
			$updateSid = $_POST['editSid'];
			$updateRpp = $_POST['editRpp'];
			$updatePanel=$_POST['editPanel'];
			$updatePowerType = $_POST['editPowerType'];
			$updatePhaseLetters = $_POST['editPhaseLetters'];
			$updateRow = $_POST['editRow'];
			$updateCab = $_POST['editCab'];
			$updateMau = $_POST['editMau'];

			$previous_sid = $_SESSION['sid'];
			debug_to_console("Previous sID ".$previous_sid);
			debug_to_console("Current sID".$updateSid);

			if($updateSid != $previous_sid){
				list($goodToGo, $message) = check_sid($updateSid,$db_con);
			} else {
				debug_to_console("SID IS THE SAME");
			}
			

			//script_to_alert($goodToGo);

			// Takes string and takes  letter after 1A-[PS]
			$determinePrimarySecondary1 = substr($updatePanel,strpos($updatePanel, '-')+1);
			$determinePrimarySecondary = substr($determinePrimarySecondary1, -4, 1);

			//debug_to_console($determinePrimarySecondary);

			if($determinePrimarySecondary == 'P'  AND  $goodToGo == true ){
				debug_to_console("In UPDATE PRIMARY");
				// $stmt = $db_con->prepare("UPDATE primarypowerproduct SET cID=:cID, sID=:sID, panelName=:panelName, power_type=:power_type, phaseLetter=:phaseLetter, mau=:mau, location=:location, row=:row, cab=:cab WHERE cID='$updateCid' ");

			$stmt = $db_con->prepare("UPDATE primarypowerproduct SET cID=:cID, sID=:sID, panelName=:panelName, power_type=:power_type, phaseLetter=:phaseLetter, mau=:mau, location=:location, row=:row, cab=:cab WHERE sID=:qsID");


			$stmt->bindParam(":cID", $updateCid);
			$stmt->bindParam(":location", $updateLocation);
			$stmt->bindParam(":sID", $updateSid);
			$stmt->bindParam(":panelName", $updatePanel);
			$stmt->bindParam(":power_type", $updatePowerType);
			$stmt->bindParam(":phaseLetter", $updatePhaseLetters);
			$stmt->bindParam(":row", $updateRow);
			$stmt->bindParam(":cab", $updateCab);
			$stmt->bindParam(":mau", $updateMau);
			$stmt->bindParam(":qsID", $previous_sid);

	

			// 	// test works
			// $stmt = $db_con->prepare("UPDATE primarypowerproduct SET cID=:cID, sID=:sID, mau=:mau, location=:location, row=:row, cab=:cab WHERE sID=:qsID");


			} else if($determinePrimarySecondary == 'S'  AND $goodToGo == true) {
				$stmt = $db_con->prepare("UPDATE secondarypowerproduct SET cID=:cID, sID=:sID, panelName=:panelName, power_type=:power_type, phaseLetter=:phaseLetter, mau=:mau, location=:location, row=:row, cab=:cab WHERE sID=:qsID");

				// // test works
				// $stmt = $db_con->prepare("UPDATE secondarypowerproduct SET cID=:cID, sID=:sID, mau=:mau, location=:location, row=:row, cab=:cab WHERE sID=:qsID");

			$stmt->bindParam(":cID", $updateCid);
			$stmt->bindParam(":location", $updateLocation);
			$stmt->bindParam(":sID", $updateSid);
			$stmt->bindParam(":panelName", $updatePanel);
			$stmt->bindParam(":power_type", $updatePowerType);
			$stmt->bindParam(":phaseLetter", $updatePhaseLetters);
			$stmt->bindParam(":row", $updateRow);
			$stmt->bindParam(":cab", $updateCab);
			$stmt->bindParam(":mau", $updateMau);
			$stmt->bindParam(":qsID", $previous_sid);

			
				
			} else {
				script_to_alert("Something wrong in panel selection for Primary or Secondary" . "Error: " . $message);
			}

			// $stmt = $db_con->prepare("UPDATE primarypowerproduct SET cID=:cID, sID=:sID, panelName=:panelName, power_type=:power_type, phaseLetter=:phaseLetter, mau=:mau, location=:location, row=:row, cab=:cab WHERE cID=:cID");

			// $stmt->bindParam(":cID", $updateCid);
			// $stmt->bindParam(":location", $updateLocation);
			// $stmt->bindParam(":sID", $updateSid);
			// $stmt->bindParam(":panelName", $updatePanel);
			// $stmt->bindParam(":power_type", $updatePowerType);
			// $stmt->bindParam(":phaseLetter", $updatePhaseLetters);
			// $stmt->bindParam(":row", $updateRow);
			// $stmt->bindParam(":cab", $updateCab);
			// $stmt->bindParam(":mau", $updateMau);
			// $stmt->bindParam(":qsID", $updateSid);
			
			//debug_to_console("UPDATED: " +$updateCid +' '+$updateSid + '' +$updatePanel + ' '+$updatePowerType + ' ' +$updatePhaseLetters +' '+$updateMau + '' +$updateLocation +' ' +$updateRow +' '+$updateCab);

		if($goodToGo == true){
			if($stmt->execute())
			{
				debug_to_console($message);
				debug_to_console("Successfully updated");
				script_to_alert($message);
				
			}
			else{
				debug_to_console("Query Problem");
			}
		} else {
			debug_to_console($message);
			debug_to_console("goodToGo IS FALSE!!!!!!!!!!!!!!");
			script_to_alert($message);
			
			
		}
			

		} else {
			echo "Something wrong in Update".'<br>';
		}

 
}// End of if $_POST

// checks if sid is valid or not, meaning no duplicate sids
function check_sid($updateSid, $db_con){
	/* check if sID already exist in the db by checking the $nums value. If query matches the $checksid value then $nums = (int)$row['sID']; will be true by assigning it a converted int value, if not by default $nums will equal 0 and therefore be false  */
	$checksid = $updateSid;
	$nums = 0;
	$pass = true;
	$fail = false;
	$text = " ";

	$stmt = $db_con->prepare("SELECT * FROM primarypowerproduct WHERE sID=:checksid UNION SELECT * FROM secondarypowerproduct WHERE sID=:checksid ");

	$stmt->execute(array(':checksid'=>$checksid));	
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	$nums = (int)$row['sID'];

	//debug_to_console($nums."-+-+-+-+");

	if ($nums > 0){
		$checksid = "s".$checksid." already exist";
		//$goodToGo = false;
		$text = $checksid;
		return array($fail, $text);
		//debug_to_console($checksid);
		//debug_to_console($text);
		
	} else {
		$checksid = "s".$checksid." does not exist";
		$text = $checksid;
		return array($pass, $text);
		//debug_to_console($checksid);
		//debug_to_console($text);

	}
	//return $goodToGo;		
}

function debug_to_console( $data ) {
    $output = $data;
    // if ( is_array( $output ) )
    //     $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function script_to_alert($data){
	echo "<script type='text/javascript'>alert('$data');</script>";

}

// Need to add functions for checks here
?>

