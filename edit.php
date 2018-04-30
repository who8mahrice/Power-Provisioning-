<?php 
session_start();
// $_SESSION[''] = 
// $_SESSION[''] =
require_once 'dbconfig.php';


$isPrimary = false;
$isSecondary = false;

if($_GET['edit_id'])
{
	$id = $_GET['edit_id'];	
	//$stmt=$db_con->prepare("SELECT * FROM primarypowerproduct WHERE sID=:id");
	$stmt=$db_con->prepare("SELECT * from primarypowerproduct WHERE sID=:id UNION select * from secondarypowerproduct WHERE sID=:id");
	// SELECT * from primarypowerproduct WHERE sID=:id UNION select * from secondarypowerproduct WHERE sID=:id;
	$stmt->execute(array(':id'=>$id));	
	$row=$stmt->fetch(PDO::FETCH_ASSOC);

	$cID_current = $row['cID'];
	$sID_current = $row['sID'];
	$panel_current = $row['panelName'];
	$power_current = $row['power_type'];
	$phaseLetter_current = $row['phaseLetter'];
	$mau_current = $row['mau'];
	$location_current = $row['location'];
	$row_current = $row['row'];
	$cab_current = $row['cab'];
	$_SESSION['customer'] = $cID_current;
	$_SESSION['location'] = $location_current;

	debug_to_console("Session Customer: ".$_SESSION['customer']);
	debug_to_console("Session Location: ".$_SESSION['location']);

	/* START of determine if it is primary or secondary for the update product by string parse from $panel_current and taking just the P from 1A-P1-1 or the S from 1A-S1-1  */
	$determinePrimarySecondary1 = substr($panel_current,strpos($panel_current, '-')+1);
	$determinePrimarySecondary = substr($determinePrimarySecondary1, -4, 1);

	if($determinePrimarySecondary =='P'){
		$isPrimary = true;
	} else if($determinePrimarySecondary =='S'){
		$isSecondary = true;
	} else {
		echo "Something wrong in panel selection for Primary or Secondary" + '<br>';
	}
	/* END of determine if it is primary or secondary for the update product by string parse from $panel_current and taking just the P from 1A-P1-1 or the S from 1A-S1-1 */

	// Get rppName from $panel_current aka panelName
	$stmt2=$db_con->prepare("SELECT * FROM primaryrpp WHERE panelName=:panel UNION SELECT * FROM secondaryrpp WHERE panelName=:panel");
	$stmt2->execute(array(':panel'=>$panel_current));
	$row2=$stmt2->fetch(PDO::FETCH_ASSOC);

	$rppName = $row2['rppName'];

	if($isPrimary == true) {

		

	} else if ($isSecondary == true) {

	} else
	echo "Messed UP in checking for RPP";

	echo "CURRENT: ".$cID_current.' sID: '.$sID_current.' Panel Name: '.$panel_current.' Power Type: '.$power_current.' Phase Letter: ' . $phaseLetter_current . ' MAU: ' . $mau_current . ' Location: ' . $location_current . ' Row: ' . $row_current . ' Cab: ' . $cab_current;
}


function debug_to_console( $data ) {
    $output = $data;
    // if ( is_array( $output ) )
    //     $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>
<style type="text/css">
#dis{
	display:none;
}
</style>
<head>
	<link rel="stylesheet" type="text/css" href="css/edit.css" />
</head>
<!-- <script type="text/javascript" src=js/query.js></script> -->
<!-- <script src="js/powerproduct.js"></script> -->

	
    
    <div id="dis">
    
	</div>
	

	<form method='post' id='emp-UpdateForm' action='#'>

		<table class='table table-bordered'>
			<input type='hidden' name='editCid' value='<?php  echo $cID_current; ?>' />
			<input type='hidden' id='editLocation' name='editLocation' value='<?php  echo $location_current; ?>' />
			<!-- <input type="hidden" id="rpp" name="rpp" value=''>
			<input type="hidden" id="panel" name="panel" value='<?php echo $panel_current;  ?>' /> -->

			<tr>
				<td>sID</td>
				<td><input type='text' name='editSid' class='form-control' value='<?php  echo $sID_current; ?>' required></td>
			</tr>
			<?php

			if ($isPrimary == true) {
				$isPrimary = false;
				?>
				<!-- Primary Power Menu -->
				<tr>
					<td>Panel Name</td>
					 
					<td><select id="category1" size="1" name="editRpp" required>
						<option value='<?php echo $rppName; ?>' style="text-decoration: underline;" ><?php echo $rppName; ?></option>
						<option value="">-SELECT-</option> 
						<option value="RPP-1A-P1">RPP-1A-P1</option>
						<option value="RPP-1A-P2">RPP-1A-P2</option>
						<option value="RPP-1A-P3">RPP-1A-P3</option>
						<option value="RPP-1A-P4">RPP-1A-P4</option>
						<option value="RPP-1A-P5">RPP-1A-P5</option>
						<option value="RPP-1A-P6">RPP-1A-P6</option>
						<option value="RPP-1A-P7">RPP-1A-P7</option>
						<option value="RPP-1A-P8">RPP-1A-P8</option>
						<option value="RPP-1A-P9">RPP-1A-P9</option>
						<option value="RPP-1A-P10">RPP-1A-P10</option>
					</select>

					<select disabled="disabled" id="category2" name="editPanel" required>  
						<option rel='<?php echo $rppName;  ?>' value='<?php echo $panel_current;  ?>'><?php echo $panel_current;  ?></option> 
						<option value="">-SELECT-</option> 
						<option rel="RPP-1A-P1" value="1A-P1-1">1A-P1-1</option>
						<option rel="RPP-1A-P1" value="1A-P1-2">1A-P1-2</option>
						<option rel="RPP-1A-P1" value="1A-P1-3">1A-P1-3</option>
						<option rel="RPP-1A-P1" value="1A-P1-4">1A-P1-4</option>

						<option rel="RPP-1A-P2" value="1A-P1-5">1A-P1-5</option>
						<option rel="RPP-1A-P2" value="1A-P1-6">1A-P1-6</option>
						<option rel="RPP-1A-P2" value="1A-P1-7">1A-P1-7</option>
						<option rel="RPP-1A-P2" value="1A-P1-8">1A-P1-8</option>

						<option rel="RPP-1A-P3" value="1A-P1-9">1A-P1-9</option>
						<option rel="RPP-1A-P3" value="1A-P1-10">1A-P1-10</option>
						<option rel="RPP-1A-P3" value="1A-P2-1">1A-P2-1</option>
						<option rel="RPP-1A-P3" value="1A-P2-2">1A-P2-2</option>

						<option rel="RPP-1A-P4" value="1A-P2-3">1A-P2-3</option>
						<option rel="RPP-1A-P4" value="1A-P2-4">1A-P2-4</option>
						<option rel="RPP-1A-P4" value="1A-P2-5">1A-P2-5</option>
						<option rel="RPP-1A-P4" value="1A-P2-6">1A-P2-6</option>

						<option rel="RPP-1A-P5" value="1A-P2-7">1A-P2-7</option>
						<option rel="RPP-1A-P5" value="1A-P2-8">1A-P2-8</option>
						<option rel="RPP-1A-P5" value="1A-P2-9">1A-P2-9</option>
						<option rel="RPP-1A-P5" value="1A-P2-10">1A-P2-10</option>

						<option rel="RPP-1A-P6" value="1A-P3-1">1A-P3-1</option>
						<option rel="RPP-1A-P6" value="1A-P3-2">1A-P3-2</option>
						<option rel="RPP-1A-P6" value="1A-P3-3">1A-P3-3</option>
						<option rel="RPP-1A-P6" value="1A-P3-4">1A-P3-4</option>

						<option rel="RPP-1A-P7" value="1A-P3-5">1A-P3-5</option>
						<option rel="RPP-1A-P7" value="1A-P3-6">1A-P3-6</option>
						<option rel="RPP-1A-P7" value="1A-P3-7">1A-P3-7</option>
						<option rel="RPP-1A-P7" value="1A-P3-8">1A-P3-8</option>

						<option rel="RPP-1A-P8" value="1A-P3-9">1A-P3-9</option>
						<option rel="RPP-1A-P8" value="1A-P3-10">1A-P3-10</option>
						<option rel="RPP-1A-P8" value="1A-P4-1">1A-P4-1</option>
						<option rel="RPP-1A-P8" value="1A-P4-2">1A-P4-2</option>

						<option rel="RPP-1A-P9" value="1A-P4-3">1A-P4-3</option>
						<option rel="RPP-1A-P9" value="1A-P4-4">1A-P4-4</option>
						<option rel="RPP-1A-P9" value="1A-P4-5">1A-P4-5</option>
						<option rel="RPP-1A-P9" value="1A-P4-6">1A-P4-6</option>

						<option rel="RPP-1A-P10" value="1A-P4-7">1A-P4-7</option>
						<option rel="RPP-1A-P10" value="1A-P4-8">1A-P4-8</option>
						<option rel="RPP-1A-P10" value="1A-P4-9">1A-P4-9</option>
						<option rel="RPP-1A-P10" value="1A-P4-10">1A-P4-10</option>
					</select>
				</td>
			</tr>

			<?php
		}

	
		else if($isSecondary == true) {
			$isSecondary = false;
			?>
			<!-- Secondary Power Menu -->
			<tr><td>Panel Name</td>
				<td>
					<select id="category1" name="editRpp" required>
						<option value='<?php echo $rppName; ?>'><?php echo $rppName; ?></option>
						<option value="">-SELECT-</option> 
						<option value="RPP-1A-S1">RPP-1A-S1</option>
						<option value="RPP-1A-S2">RPP-1A-S2</option>
						<option value="RPP-1A-S3">RPP-1A-S3</option>
						<option value="RPP-1A-S4">RPP-1A-S4</option>
						<option value="RPP-1A-S5">RPP-1A-S5</option>
						<option value="RPP-1A-S6">RPP-1A-S6</option>
						<option value="RPP-1A-S7">RPP-1A-S7</option>
						<option value="RPP-1A-S8">RPP-1A-S8</option>
						<option value="RPP-1A-S9">RPP-1A-S9</option>
						<option value="RPP-1A-S10">RPP-1A-S10</option>
					</select>


					<select disabled="disabled" id="category2" name="editPanel" required>  
						<option rel='<?php echo $rppName;  ?>' value='<?php echo $panel_current;  ?>'><?php echo $panel_current;  ?></option> 
						<option value="">-SELECT-</option> 
						<option rel="RPP-1A-S1" value="1A-S1-1">1A-S1-1</option>
						<option rel="RPP-1A-S1" value="1A-S1-2">1A-S1-2</option>
						<option rel="RPP-1A-S1" value="1A-S1-3">1A-S1-3</option>
						<option rel="RPP-1A-S1" value="1A-S1-4">1A-S1-4</option>

						<option rel="RPP-1A-S2" value="1A-S1-5">1A-S1-5</option>
						<option rel="RPP-1A-S2" value="1A-S1-6">1A-S1-6</option>
						<option rel="RPP-1A-S2" value="1A-S1-7">1A-S1-7</option>
						<option rel="RPP-1A-S2" value="1A-S1-8">1A-S1-8</option>

						<option rel="RPP-1A-S3" value="1A-S1-9">1A-S1-9</option>
						<option rel="RPP-1A-S3" value="1A-S1-10">1A-S1-10</option>
						<option rel="RPP-1A-S3" value="1A-S2-1">1A-S2-1</option>
						<option rel="RPP-1A-S3" value="1A-S2-2">1A-S2-2</option>

						<option rel="RPP-1A-S4" value="1A-S2-3">1A-S2-3</option>
						<option rel="RPP-1A-S4" value="1A-S2-4">1A-S2-4</option>
						<option rel="RPP-1A-S4" value="1A-S2-5">1A-S2-5</option>
						<option rel="RPP-1A-S4" value="1A-S2-6">1A-S2-6</option>

						<option rel="RPP-1A-S5" value="1A-S2-7">1A-S2-7</option>
						<option rel="RPP-1A-S5" value="1A-S2-8">1A-S2-8</option>
						<option rel="RPP-1A-S5" value="1A-S2-9">1A-S2-9</option>
						<option rel="RPP-1A-S5" value="1A-S2-10">1A-S2-10</option>

						<option rel="RPP-1A-S6" value="1A-S3-1">1A-S3-1</option>
						<option rel="RPP-1A-S6" value="1A-S3-2">1A-S3-2</option>
						<option rel="RPP-1A-S6" value="1A-S3-3">1A-S3-3</option>
						<option rel="RPP-1A-S6" value="1A-S3-4">1A-S3-4</option>

						<option rel="RPP-1A-S7" value="1A-S3-5">1A-S3-5</option>
						<option rel="RPP-1A-S7" value="1A-S3-6">1A-S3-6</option>
						<option rel="RPP-1A-S7" value="1A-S3-7">1A-S3-7</option>
						<option rel="RPP-1A-S7" value="1A-S3-8">1A-S3-8</option>

						<option rel="RPP-1A-S8" value="1A-S3-9">1A-S3-9</option>
						<option rel="RPP-1A-S8" value="1A-S3-10">1A-S3-10</option>
						<option rel="RPP-1A-S8" value="1A-S4-1">1A-S4-1</option>
						<option rel="RPP-1A-S8" value="1A-S4-2">1A-S4-2</option>

						<option rel="RPP-1A-S9" value="1A-S4-3">1A-S4-3</option>
						<option rel="RPP-1A-S9" value="1A-S4-4">1A-S4-4</option>
						<option rel="RPP-1A-S9" value="1A-S4-5">1A-S4-5</option>
						<option rel="RPP-1A-S9" value="1A-S4-6">1A-S4-6</option>

						<option rel="RPP-1A-S10" value="1A-S4-7">1A-S4-7</option>
						<option rel="RPP-1A-S10" value="1A-S4-8">1A-S4-8</option>
						<option rel="RPP-1A-S10" value="1A-S4-9">1A-S4-9</option>
						<option rel="RPP-1A-S10" value="1A-S4-10">1A-S4-10</option>
					</select>
				</td>
			</tr>
			<?php
			} 
		?>



		<tr>
			<td>Power Type</td>
			<!-- <td><input type='text' name='power_type' class='form-control' value='<?php //DEL echo $row['power_type']; ?>' required></td> -->
			<td>
				<select  id="category3" name="editPowerType" required>
					<option value='<?php echo $power_current ?>'><?php echo $power_current ?></option> 
					<option value="">-SELECT-</option> 
					<option value="20-120">20/120</option> <!-- Had to change value from 20/120 to 20-120 because console error for character '/'   -->
					<option value="30-120">30/120</option>
					<option value="20-208">20/208</option>
					<option value="30-208">30/208</option>
					<option value="50-208">50/208</option>
					<option value="60-208">60/208</option>
					<option value="30-208-3ph">30/208-3ph</option>';
					<option value="50-208-3ph">50/208-3ph</option>';
					<option value="60-208-3ph">60/208-3ph</option>';
				</select>


				<select disabled="disabled" id="category4" name="editPhaseLetters" required>  
					<option rel='<?php echo $power_current ?>' value='<?php echo $phaseLetter_current ?>'><?php echo $phaseLetter_current ?></option> 
					<option value="">-SELECT-</option> 
					<option rel="20-120" value="A">A</option> 
					<option rel="20-120" value="B">B</option>
					<option rel="20-120" value="C">C</option>

					<option rel="30-120" value="A">A</option>
					<option rel="30-120" value="B">B</option>
					<option rel="30-120" value="C">C</option>


					<option rel="20-208" value="A,B">A,B</option>
					<option rel="20-208" value="A,C">A,C</option>
					<option rel="20-208" value="B,C">B,C</option>

					<option rel="30-208" value="A,B">A,B</option>
					<option rel="30-208" value="A,C">A,C</option>
					<option rel="30-208" value="B,C">B,C</option>

					<option rel="50-208" value="A,B">A,B</option>
					<option rel="50-208" value="A,C">A,C</option>
					<option rel="50-208" value="B,C">B,C</option>

					<option rel="60-208" value="A,B">A,B</option>
					<option rel="60-208" value="A,C">A,C</option>
					<option rel="60-208" value="B,C">B,C</option>

					<option rel="30-208-3ph" value="A,B,C">A,B,C</option>
					<option rel="50-208-3ph" value="A,B,C">A,B,C</option>
					<option rel="60-208-3ph" value="A,B,C">A,B,C</option>  

				</select>
			</td>
		</tr>

		<tr>
			<td>Row</td>
			<td><input type='text' name='editRow' value='<?php  echo $row_current; ?>' required></td>
		</tr>


		<tr>
			<td>Cab</td>
			<td><input type='text' name='editCab' value='<?php  echo $cab_current; ?>' required></td>
		</tr>

		<tr>
			<td>MAU</td>
			<td><input type='text' name='editMau' value='<?php  echo $mau_current; ?>' required></td>
		</tr>

		<tr>
			<td colspan="2">
				<button type="submit" class="btn btn-primary" name="btn-update" id="btn-update">
					<span class="glyphicon glyphicon-plus"></span> Update Customer
				</button>

				<button type="button" class="btn btn-danger" name="btn-cancel" id="btn-cancel">
					<span class="glyphicon glyphicon-ban-circle"></span> Cancel Update
				</button>
			</td>
		</tr>


	</table>
</form> 

<script type="text/javascript" src="js/edit.js"></script>

<!--  <script src="js/powerproduct.js"></script>  -->


