<?php
//php file for //--test phase

require_once 'dbconfig.php';

$panel = $_POST['panel'];

$stmt3=$db_con->prepare("SELECT * FROM primarysection WHERE panelName=:panel UNION SELECT * FROM secondarysection WHERE panelName=:panel");
	$stmt3->execute(array(':panel'=>$panel));
	$row3=$stmt3->fetch(PDO::FETCH_ASSOC);

	$phase_left_As = $row3['Phase_Left_A'];
	$phase_left_Bs = $row3['Phase_Left_B'];
	$phase_left_Cs = $row3['Phase_Left_C'];

//echo '<span>';

echo '<strong>'."Phase_A_Left: ".'</strong>'.$phase_left_As .'<strong>'." Phase_B_Left: ".'</strong>'.$phase_left_Bs.'<strong>'." Phase_C_Left: ".'</strong>'.$phase_left_Cs;
//echo '</span>';

debug_to_console("Phase_A_Left: ".$phase_left_As ." Phase_B_Left: ".$phase_left_Bs ." Phase_C_Left: ".$phase_left_Cs);


function debug_to_console( $data ) {
    $output = $data;
    // if ( is_array( $output ) )
    //     $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects In Primary_phase.php : " . $output . "' );</script>";
}

?>

