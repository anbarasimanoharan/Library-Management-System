<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$startDay = $_REQUEST['startDate'];
$startTime = $_REQUEST['startTime'];

$endDay = $_REQUEST['endDate'];
$endTime = $_REQUEST['endTime'];

$occupancy = $_REQUEST['occupancy'];
$type = $_REQUEST['type'];
echo "$UnityId $startDay $startTime  $endDay $endTime $occupancy";
echo "<br> <br>";
$from_time = strtotime($startDay." ".$startTime);
$to_time = strtotime($endDay." ".$endTime);
echo "differnce in time between $to_time , $from_time: ";
$duration_min= round(abs($to_time - $from_time) / 60,2). " minute";
echo"$duration_min";

if($duration_min >180){
	// if duration is more than 3 hrs.. then shouldn't proceed
	echo "<br><br>  Can't reserve a room for more than 3 hrs!!";
	echo "<br> <br> Click <a href=\"ReserveRoom.php\">here </a>to go Back to previous Page: Room Reservations";
	exit(0);
}

echo "<br><br>";
echo "DATETIME in USA FORMAT";
echo "<br><br>";

$date = date_create();
date_format($date,'m-d-Y H:i:s');
$startDateUSA=date_format(date_timestamp_set($date, $from_time),'d/M/Y h:i:s A');

$endDateUSA=date_format(date_timestamp_set($date, $to_time),'d/M/Y h:i:s A');


echo "startDateTime " .$startDateUSA . "\n";
echo "<br><br>";
echo "endDateTime " .$endDateUSA. "\n";
echo "<br><br>";

$selectRoomQuery ="SELECT r.\"RoomNumber\",r.\"Location\",r.\"Floor\"
FROM ROOM r
WHERE r.\"RoomNumber\" NOT IN (
SELECT rr.\"RoomNumber\" FROM ROOM_RESERVATION rr
WHERE NOT (rr.\"EndTime\"   < CAST('{$startDateUSA}' AS TIMESTAMP)
OR
rr.\"StartTime\" > CAST('{$endDateUSA}' AS TIMESTAMP)))
AND r.\"Capacity\" >= $occupancy
AND r.\"Type\" = '{$type}'
ORDER BY r.\"RoomNumber\"";

var_dump($selectRoomQuery);
$stid = oci_parse($conn, $selectRoomQuery);
$result = oci_execute($stid);
echo "<table border=\"2\">";
echo "<tr>";
echo "<td>";
echo "Room No ";
echo "</td>";
echo "<td>";
echo "Location ";
echo "</td>";
echo "<td>";
echo" Floor ";
echo "</td>";
echo "<td>";
echo" Reserve ";
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
	echo "<td>";
	echo $row['Floor'];
	echo "</td>";

	echo "<td>";
	echo" <a href=\"ReserveRoomFinalPage.php?ROOMNUMBER=".$row['RoomNumber'].
	"&LOCATION=".$row['Location']."&FLOOR=".$row['Floor']."&START_TIME=".$startDateUSA.
	"&END_TIME=".$endDateUSA."&OCCUPANCY=".$occupancy."\"> Reserve this Room </a> ";
	echo "</td>";


	echo "</tr>";

}

echo "</table>";



require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");


?>