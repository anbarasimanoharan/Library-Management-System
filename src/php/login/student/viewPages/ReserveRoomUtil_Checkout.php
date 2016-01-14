<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

//&ROOMNUMBER=".$row['RoomNumber']
//			."&LOCATION=".$row['Location'] ."&STARTIME=".$row['StartTime']
$RoomNumber = $_REQUEST['ROOMNUMBER'];
$Location = $_REQUEST['LOCATION'];
$StartTime = $_REQUEST['STARTIME'];

$updateRoomQuery ="update ROOM_RESERVATION rr SET rr.\"ISCHECKEDOUT\"='Y'  WHERE 
rr.\"RoomNumber\"='$RoomNumber' AND rr.\"Location\"='$Location' 
AND rr.\"StartTime\"='$StartTime' AND rr.\"UnityID\"='$UnityId'";

var_dump($updateRoomQuery);
$stid = oci_parse($conn, $updateRoomQuery);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	header( "Location: RoomCheckInCheckout.php" );
}

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>