<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}
$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$query = "SELECT \"Balance\" AS BALANCE FROM LIBRARYPATRON WHERE \"UnityId\"='".$UnityId."'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
$nrows = oci_fetch_all($stid, $balance, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if($nrows == 1) {
	$balanceAmount = $balance[0]['BALANCE'];
	var_dump($balanceAmount);
	$query = "INSERT INTO ACCOUNT_HISTORY VALUES('{$UnityId}',SYSTIMESTAMP,{$balanceAmount}*-1,1)";
	$stid = oci_parse($conn, $query);
	$result = oci_execute($stid);
	var_dump($query);
	if(!$result) {
		echo "Error while updating transaction table";
	} else {
		echo "Updated transaction successfully";
	}
	$query = "UPDATE STUDENT SET \"isHeld\"='N' WHERE \"UnityId\"='".$UnityId."'";
	$stid = oci_parse($conn, $query);
	$result = oci_execute($stid);
	var_dump($query);
	if(!$result) {
		echo "Error while updating hold status";
	} else {
		echo "Updated successfully";
	}
} else {
	echo "Some error occurred";
}

$query = "update LIBRARYPATRON set \"Balance\"=0 where \"UnityId\"='".$UnityId."'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	
	header( "Location: AccountBalance.php" );
}

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>