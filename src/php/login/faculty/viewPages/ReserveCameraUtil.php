<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$checkoutDay = $_REQUEST['checkoutDate'];

$from_time = strtotime($checkoutDay);

$date = date_create();
date_format($date,'m-d-Y');
$checkoutDateUSA=date_format(date_timestamp_set($date, $from_time),'d/M/Y h:i:s A');

$check_if_friday_sql="SELECT TO_CHAR(CAST('{$checkoutDateUSA}' AS TIMESTAMP),'D') as DAY  from dual";
var_dump($check_if_friday_sql);
$stid = oci_parse($conn, $check_if_friday_sql);
oci_execute($stid);
oci_fetch_all($stid, $check_if_friday_result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if($check_if_friday_result[0]['DAY'] != 6){
	echo "Checkouts are allowed only on Fridays. Select the checkout date for a Friday.";
	echo "<td><a href=\"ReserveCamera.php\">Back to Date Selection</a></td>";
}
else {			
		
	echo "startDateTime " .$checkoutDateUSA . "\n";
	echo "<br><br>";

	$selectRoomQuery ="SELECT DISTINCT c.\"ID\",c.\"MAKE\",c.\"MODEL\",c.\"LENS_CONFIGURATION\",c.\"MEMORY\",c.\"LOCATION\"
					   FROM CAMERA c
					   WHERE c.\"ID\" NOT IN  
								(
									SELECT cq.\"ID\" FROM CAMERA_QUEUE cq
									WHERE cq.\"UnityId\" = '{$UnityId}'
									AND cq.\"DateOfQueue\" = '{$checkoutDateUSA}'
									UNION
									SELECT cc.\"ID\" from CAMERA_CHECKOUT cc
									WHERE cc.\"UnityId\" = '{$UnityId}'
									AND cc.\"ReturnDate\" > SYSTIMESTAMP
								)
						";

	var_dump($selectRoomQuery);
	$stid = oci_parse($conn, $selectRoomQuery);
	$result = oci_execute($stid);

	echo "<table border='1'>
	<tr>
	<th> CAMERA ID </th>
	<th> MAKE </th>
	<th> MODEL </th>
	<th> LENS_CONFIGURATION </th>
	<th> MEMORY </th>
	<th> LOCATION </th>		
	<th> Actions </th>
	</tr>";

	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

		echo "<tr>";
		echo "<td>".$row['ID']."</td>";
		echo "<td>".$row['MAKE']."</td>";
		echo "<td>".$row['MODEL']."</td>";
		echo "<td>".$row['LENS_CONFIGURATION']."</td>";
		echo "<td>".$row['MEMORY']."</td>";
		echo "<td>".$row['LOCATION']."</td>";
		echo "<td><a href=\"AddToQueueCamera.php?id={$row['ID']}&date={$checkoutDateUSA}\">Reserve</a></td>";
		echo "</tr>";

	}

}

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");

?>