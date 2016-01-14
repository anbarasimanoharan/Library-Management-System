<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$checkoutDay = $_REQUEST['date'];
$id =$_REQUEST['id'];

$waitlist_sql = "SELECT DISTINCT cq.\"DateOfQueue\",MAX(cq.\"WaitlistNumber\")+1 as WAITLIST_NO 
				 FROM CAMERA_QUEUE cq
				 WHERE cq.\"DateOfQueue\" = CAST('{$checkoutDay}' as TIMESTAMP)
				 AND cq.\"ID\" = '${id}'
				 GROUP BY cq.\"DateOfQueue\"";
$stid = oci_parse($conn,$waitlist_sql);
oci_execute($stid);
oci_fetch_all($stid, $waitlist_result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if(sizeof($waitlist_result) > 0) {
	$waitlistNumber = $waitlist_result[0]['WAITLIST_NO'];
} else {
	$waitlistNumber = 0 ; 
}
$insert_to_queue_sql = "INSERT INTO CAMERA_QUEUE VALUES(
						'{$UnityId}', CAST('{$checkoutDay}' AS TIMESTAMP),'{$id}',$waitlistNumber)";
var_dump($insert_to_queue_sql);
$stid = oci_parse($conn,$insert_to_queue_sql);
$result=oci_execute($stid);
if(!$result) {
	echo "Error while adding to queue";
} else {
	if($waitlistNumber == 0)
		$notification = "Camera with ID ".$id." has been reserved for ".$checkoutDay.". Please collect between 8AM to 10AM on this date to avoid cancellation.";
	else 
		$notification = "Camera with ID ".$id." has been reserved for ".$checkoutDay."with waitlist number ".$waitlistNumber.". You will be informed if it becomes available.";
	
	$insert_to_notification_sql = "INSERT INTO NOTIFICATION VALUES(
									'{$UnityId}',SYSTIMESTAMP,'{$notification}')";
	$stid = oci_parse($conn,$insert_to_notification_sql);
	$result=oci_execute($stid);
	if(!$result) 
		echo "Error while pushing notifications";
	else {
		echo "$notification";
		echo "<a href=\"Notifications.php\">Notifications!</a>";
		echo "<br> <br>";
	}
}
require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");

?>