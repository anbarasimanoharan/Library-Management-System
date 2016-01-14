<?php
//"ID=".$row['ID']."UNITY_ID=".$UnityId."DATE_OF_QUEUE=".$row['DateOfQueue']

session_start();
if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$ID = $_REQUEST['ID'];
$ReservationDate = $_REQUEST['DATE_OF_QUEUE'];

$query = "insert into CAMERA_CHECKOUT CC values ('$UnityId','$ID','$ReservationDate',SYSTIMESTAMP,CAST('31/DEC/9999' AS TIMESTAMP),'Y')";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}

$query2 = "insert into CAMERA_CHECKOUT
SELECT CQ.\"UnityId\", CQ.\"ID\", CQ.\"DateOfQueue\", SYSTIMESTAMP, SYSTIMESTAMP,'F'
from  CAMERA_QUEUE CQ Where CQ.\"DateOfQueue\"='$ReservationDate' AND CQ.\"UnityId\"<>'$UnityId' AND CQ.\"ID\"='$ID'";

var_dump($query2);
$stid2 = oci_parse($conn, $query2);
$result = oci_execute($stid2);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}


$updateCameraQuery = "update CAMERA C Set C.\"IS_RESERVED\"='Y' Where C.\"ID\"='$ID'";
var_dump($updateCameraQuery);
$stid3 = oci_parse($conn, $updateCameraQuery);
$result = oci_execute($stid3);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}

$deleteFromCAMERA_QUEUE ="delete From CAMERA_QUEUE where \"ID\"='$ID' AND \"DateOfQueue\"='$ReservationDate'";
var_dump($deleteFromCAMERA_QUEUE);
$stid4 = oci_parse($conn, $deleteFromCAMERA_QUEUE);
$result = oci_execute($stid4);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}

header( "Location: CheckoutCamera.php" );
require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>