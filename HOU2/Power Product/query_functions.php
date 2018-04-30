<?php
//echo '<div class="content-loader">';
require_once 'dbconfig.php';

$customer = $_POST['customer'];
//echo $customer;
$location = $_POST['location'];
//echo $location;

//echo'<body>';
echo '<div class="content-loader">';
echo '<table cellspacing="0" width="100%" id="example" class="table table-striped table-hover table-responsive">';
echo '<thead>';
echo '<tr>
        <th>Cus sID</th>
        <th>Panel Name</th>
        <th>Power Type</th>
        <th>Phase Letter</th>
        <th>MAU</th>
        <th>Location</th>
        <th>Row</th>
        <th>Cab</th>
        <th>Edit</th>
        <th>Delete</th>
        </tr>';
echo '</thead>';
echo '<tbody>';
//$stmt = $db_con->prepare("SELECT * FROM primarypowerproduct WHERE cID='$customer' AND location='$location'");
$stmt = $db_con->prepare("SELECT * FROM primarypowerproduct WHERE cID='$customer' AND location='$location' UNION SELECT * FROM secondarypowerproduct WHERE cID='$customer' AND location='$location' ORDER BY id");

        $stmt->execute();
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
echo '<tr>';
echo '<td>';
echo $row['sID'];
echo '</td>';
echo '<td>';
echo $row['panelName'];
echo '</td>';
echo '<td>';
echo $row['power_type'];
echo '</td>';
echo '<td>';
echo $row['phaseLetter'];
echo '</td>';
echo '<td>';
echo $row['mau'];
echo '</td>';
echo '<td>';
echo $row['location'];
echo '</td>';
echo '<td>';
echo $row['row'];
echo '</td>';
echo '<td>';
echo $row['cab'];
echo '</td>';

//echo '<td>';
echo '<td align="center">';
echo '<a id="';
echo $row['sID'];
echo '" class="edit-link" href="#" title="Edit">';
//debug_to_console($row['sID']);
echo '<img src="edit.ico" width="20px" />';
echo '</a>';
echo '</td>';


echo '<td align="center">';
echo '<a id="';
echo $row['sID'];
echo '" class="delete-link" href="#" title="Delete">';
//echo '"'; 
//echo $row['panelName'];
//echo '"';
//echo 'class="delete-link" href="#" title="Delete">;';
echo '<img src="delete.png" width="20px" />';
echo '</a>';
echo '</td>';
echo '</tr>';
}
echo '</tbody>';

echo '</table>';
echo '</div>';

echo'<script type="text/javascript" src="js/query.js"></script>';
echo '<script type="text/javascript" charset="utf-8">';
echo '$(document).ready(function() {';
echo "$('#example').DataTable();";
echo "$('#example').removeClass( 'display' ).addClass('table table-bordered');});";
echo '</script>';

echo '<div id="output"></div>';

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
//echo '</body>';

/*
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
echo '';
*/



?>
