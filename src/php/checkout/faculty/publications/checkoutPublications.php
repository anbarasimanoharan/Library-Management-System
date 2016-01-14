<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../../login/index.php');
	echo "Some thing wrong with session";
}

echo $_SESSION['NAME'] ;
echo "<br><br>";
echo $_SESSION['USER'];
echo "<br><br>";
$conn = null;
require_once('../../../connections/Connection.php');
require_once('checkoutPublicationsUtil.php');
//require_once('update\UpdateStudentInfoUtils.php');
$UnityId = $_SESSION['NAME'] ;
var_dump($conn);
echo "<br><br>";
$no_request = get_no_request_sql($UnityId,$conn);
$can_be_checked_out = get_can_be_checked_out_sql($UnityId,$conn);
$add_to_waitlist = get_add_to_waitlist_sql($UnityId,$conn);

echo "<table border='1'>
<tr>
<th> TYPE </th>
<th> IDENTIFIER </th>
<th> LOCATION </th>	
<th> IS_AVAILABLE </th>
<th> Actions </th>
		
</tr>";
if(sizeof($add_to_waitlist) > 0) {
	foreach($add_to_waitlist as $row) {
		echo "<tr>";
		echo "<td>".$row['TYPE']."</td>";
		echo "<td>".$row['IDENTIFIER']."</td>";
		echo "<td>".$row['Location']."</td>";
		echo "<td>".$row['IsAvailable']."</td>";
		echo "<td><a href=\"../../faculty/addtoWaitlist.php?id={$row['IDENTIFIER']}&type={$row['TYPE']}\">Put me in Queue</a></td>";
		echo "</tr>";
	}
} 
if(sizeof($can_be_checked_out) > 0) {
	foreach($can_be_checked_out as $row) {
		echo "<tr>";
		echo "<td>".$row['TYPE']."</td>";
		echo "<td>".$row['IDENTIFIER']."</td>";
		echo "<td>".$row['Location']."</td>";
		echo "<td>".$row['IsAvailable']."</td>";
		echo "<td><a href=\"../../faculty/performCheckout.php?id={$row['IDENTIFIER']}&type={$row['TYPE']}\">Checkout</a></td>";
		echo "</tr>";
	}
}
if(sizeof($no_request) > 0) {
	foreach($no_request as $row) {
		echo "<tr>";
		echo "<td>".$row['TYPE']."</td>";
		echo "<td>".$row['IDENTIFIER']."</td>";
		echo "<td>".$row['Location']."</td>";
		echo "<td>".$row['IsAvailable']."</td>";
		echo "<td>Not entitled for checkout now</td>";
		echo "</tr>";
	}
}

echo "<a href=\"../../../login/faculty/viewPages/CheckedOut.php\">Checked Out Resources!</a>";
//session_destroy();

// HINT: Use readonly attribute in input text.
//Country: <input type="text" name="country" value="Norway" readonly><br>
?>