<?php


session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

//$row['ID']."&CHECKOUT_DATE=".$row['CheckoutDate']
$ID = $_REQUEST['ID'];
$checkoutDate = $_REQUEST['CHECKOUT_DATE'];

$updateCamera_Checkout = "update CAMERA_CHECKOUT SET \"ReturnDate\"=SYSTIMESTAMP, \"IsCheckedOut\"='D'
where \"UnityId\"='$UnityId' AND \"ID\"='$ID'";

$updateCamera ="update CAMERA SET \"IS_RESERVED\"='N' where \"ID\"='$ID'";

var_dump($updateCamera_Checkout);
$stid = oci_parse($conn, $updateCamera_Checkout);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}
var_dump($updateCamera);
$stid2 = oci_parse($conn, $updateCamera);
$result = oci_execute($stid2);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>