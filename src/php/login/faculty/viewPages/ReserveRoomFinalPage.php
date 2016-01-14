<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];


//ROOMNUMBER=.".$row['RoomNumber'].
//	"&LOCATION=.".$row['Location']."&FLOOR=.".$row['Floor']."\"> Reserve this book </a> ";
//"&START_TIME=.".$startDateUSA.
//	"&END_TIME=.".$endDateUSA."&OCCUPANCY=.".$occupancy

$RoomNumber = $_REQUEST['ROOMNUMBER'];
$Location = $_REQUEST['LOCATION'];
$Floor = $_REQUEST['FLOOR'];
$startTime = $_REQUEST['START_TIME'];
$endTime = $_REQUEST['END_TIME'];
$occupancy = $_REQUEST['OCCUPANCY'];
$insertIntoRoomReservationQuery = "insert into ROOM_RESERVATION values
('$UnityId','$RoomNumber','$Location','$startTime','$endTime','$occupancy','N')";

var_dump($insertIntoRoomReservationQuery);

$stid = oci_parse($conn, $insertIntoRoomReservationQuery);

$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
	echo "ROOM  $RoomNumber RESERVED<br><br> LOCATION: $Location<br><br> START_TIME: $startTime<br><br> END_TIME : $endTime";
	echo "<br><br><a href=\"../index.php\"> HomePage  </a>";
}


require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");



?>