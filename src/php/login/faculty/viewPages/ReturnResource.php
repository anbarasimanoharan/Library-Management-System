<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];
$ID = $_GET['ID'];
$checkoutDate=$_GET['CHECKOUT_DATE'];
$IS_BOOK = $_GET['IS_BOOK'];
$IDENTIFER =$_GET['IDENTIFIER'];
$TYPE = $_GET['TYPE'];
// update checkout- add return date.
$updateCheckout= "UPDATE PUBLICATION_CHECKOUT SET \"ReturnDate\"= SYSTIMESTAMP where \"ID\"=$ID AND \"UnityId\"='$UnityId'
AND \"CheckoutDate\" = '$checkoutDate'";
var_dump($updateCheckout);

//update book
$updateBookQuery = "UPDATE PUBLICATIONS SET \"IsAvailable\"='Y' where \"ID\" =$ID";
var_dump($updateBookQuery);




// check if there are ppl in waitListQueue for The same TYPE,same $IDENTIFER

$queryWaitList = "select \"UnityId\" from PUBLICATION_WAITLIST where \"Identifier\"='$IDENTIFER' AND \"Type\"='$TYPE'";
var_dump($queryWaitList);


$stid4 = oci_parse($conn, $queryWaitList);
$result1=oci_execute($stid4);


$res = array();
$noOfRows = oci_fetch_all($stid4, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
oci_free_statement($stid4);


if (!$result1) {
	echo oci_error();
}else{
	//working fine.
}


echo "for previous PUBILCATION_WAITLIST select query - $noOfRows";

$query1 =null;

$query2 =null;
if($IS_BOOK == "Y"){
	$query1 = $updateCheckout;
	$query2 =$updateBookQuery;

}
$stid = oci_parse($conn, $query1);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}
$stid = oci_parse($conn, $query2);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}


if($noOfRows >0 || isset($res[0]['UnityId'])){
	//update book
	sleep(2);
	echo "Inside noOfRows: $noOfRows, ".($res[0]['UnityId']) ;
	$updateBookQuery = "UPDATE PUBLICATIONS SET \"IsAvailable\"='N' where \"ID\" =$ID";
	var_dump($updateBookQuery);

	$stid = oci_parse($conn, $updateBookQuery);
	$result = oci_execute($stid);
}

//header( "Location: CheckedOut.php" );


require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");


?>