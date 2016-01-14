<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];


$selectRoomQuery ="SELECT rr.\"RoomNumber\",rr.\"Location\"
,rr.\"StartTime\",rr.\"EndTime\",rr.\"ISCHECKEDOUT\"
FROM ROOM_RESERVATION rr
WHERE rr.\"UnityID\"='$UnityId'";

var_dump($selectRoomQuery);
$stid = oci_parse($conn, $selectRoomQuery);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//header( "Location: AccountBalance.php" );
}

$currentTime = strtotime("now");

echo "<table border=\"2\">";
echo "<tr>";
echo "<td>";
echo "Room No ";
echo "</td>";
echo "<td>";
echo "Location ";
echo "</td>";
echo "<td>";
echo" StartTime ";
echo "</td>";
echo "<td>";
echo" EndTime ";
echo "</td>";
echo "<td>";
echo" CheckOut ";
echo "</td>";
echo "<td>";
echo" CheckIn ";
echo "</td>";
echo "</tr>";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	echo "<tr>";
	echo "<td>";
	echo $row['RoomNumber'];
	echo "</td>";
	echo "<td>";
	echo $row['Location'];
	echo "</td>";
	//,rr.\"StartTime\",rr.\"EndTime\",rr.\"ISCHECKEDOUT\"

	echo "<td>";
	echo $row['StartTime'];
	echo "</td>";
	echo "<td>";
	echo $row['EndTime'];
	echo "</td>";
	echo "<td>";
	$startTime = $row['StartTime'];
	$startTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $startTime)->getTimestamp();
	$duration_min= round(($currentTime - $startTime) / 60,0);

	if($duration_min<60 && $duration_min>0){
		if($row['ISCHECKEDOUT'] == 'Y'){
			echo "Room Checked out";
		}else{
			echo "<a href = \"ReserveRoomUtil_Checkout.php?UNITY_ID=$UnityId"."&ROOMNUMBER=".$row['RoomNumber']
			."&LOCATION=".$row['Location'] ."&STARTIME=".$row['StartTime']  ."\"> click Here for checkout</a>";
		}
	}else{

		echo "<br><br>You can only checkout after startTime and upto 1hr<br><br>";
	}
	echo "</td>";

	echo "<td>";
	$endTime = $row['EndTime'];
	$endTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $endTime)->getTimestamp();
	$duration_min= round(($endTime - $currentTime) / 60,0);


	if( $duration_min>0 && $row['ISCHECKEDOUT']=='Y'){
		echo "<a href = \"ReserveRoomUtil_CheckIn.php?UNITY_ID=$UnityId"."&ROOMNUMBER=".$row['RoomNumber']
		."&LOCATION=".$row['Location'] ."&STARTIME=".$row['StartTime']  ."\"> Click Here for CheckIn</a>";

	}else if ($duration_min<0 ){
		echo "<br><br>Your reservation has ended <br><br>";
	}else{
		echo "<br><br>You can only CheckedIn after checking out<br><br>";
	}
	echo "</td>";


	echo "</tr>";
}

echo "</table>";


require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");


?>