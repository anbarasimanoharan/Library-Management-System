<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];


// "<a href= \"RenewResource.php?ID=".$row['ID']."&CHECKOUT_DATE=".
// 		$row['CheckoutDate']."&IS_BOOK=Y&IDENTIFIER=".$row['Identifier']."&TYPE=".$row['Type']."		\"> Renew </a>";

$ID=$_REQUEST['ID'];
$CheckoutDate=$_REQUEST['CHECKOUT_DATE'];
$Identifier=$_REQUEST['IDENTIFIER'];
$Type=$_REQUEST['TYPE'];
//DUEDATE=".$row['DueDate']
$DueDate = $_REQUEST['DUEDATE'];

$queryCheckIfPplinQueue= "Select * from PUBLICATION_WAITLIST PW
where PW.\"Identifier\"='$Identifier' AND PW.\"Type\"='$Type' ";


var_dump($queryCheckIfPplinQueue);
$stid = oci_parse($conn, $queryCheckIfPplinQueue);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}
$results=array();
$numrows = oci_fetch_all($stid, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
echo "";

echo  $numrows. " rows .<br />\n";
var_dump($results);
oci_free_statement($stid);

if($numrows>0){
	// there are ppl in WAITLIST/QUEUE
	echo "Can't renew , as there are ppl in the queue for the book";
}else{
	$updateQuery="UPDATE PUBLICATION_CHECKOUT PC SET PC.\"ReturnDate\"=SYSTIMESTAMP
	WHERE PC.\"UnityId\"='$UnityId'  AND PC.\"ID\"='$ID'  AND PC.\"CheckoutDate\"='$CheckoutDate'";
	echo "<br><br> Checkedout date, DueDate <br><br>";
	var_dump($CheckoutDate,$DueDate);
	$endTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $CheckoutDate)->getTimestamp();

	$startTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $DueDate)->getTimestamp();
	$duration_days= (int)(($startTime - $endTime) / 86400);
	$insertQuery = null;
	if($duration_days >0){
		$insertQuery ="insert into PUBLICATION_CHECKOUT PC
		values('$UnityId','$ID',SYSTIMESTAMP,(SELECT SYSTIMESTAMP + interval '$duration_days' DAY FROM DUAL),
		CAST ('31-DEC-9999' AS TIMESTAMP)) ";
	}
	else{
		$duration_hrs= (int)(($startTime - $endTime) / 3600);

		$insertQuery ="insert into PUBLICATION_CHECKOUT PC
		values('$UnityId','$ID',SYSTIMESTAMP,(SELECT SYSTIMESTAMP + interval '$duration_hrs' HOUR FROM DUAL),
		CAST ('31-DEC-9999' AS TIMESTAMP)) ";
	}
	var_dump($updateQuery);
	$stid = oci_parse($conn, $updateQuery);
	$result = oci_execute($stid);
	if (!$result) {
		echo oci_error();
	}else{
		//working fine.
	}

	var_dump($insertQuery);
	$stid = oci_parse($conn, $insertQuery);
	$result = oci_execute($stid);
	if (!$result) {
		echo oci_error();
	}else{
		//working fine.
	}

}
require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>