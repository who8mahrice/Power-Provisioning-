<?php
include_once 'dbconfig.php';

if($_POST['del_sID'])
{
	//debug_to_console("Deleted!!!!!!!");
	//$id = $_POST['del_sID'];	
	//$stmt=$db_con->prepare("DELETE FROM tbl_employees WHERE emp_id=:id");
	//$stmt->execute(array(':id'=>$id));	
}


function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
?>