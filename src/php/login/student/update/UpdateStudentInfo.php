<?php
session_start();
//UnityId,StudentNo,Name,PhoneNo,AlternatePhoneNo,HomeAddress,DateOfBirth,Sex,Nationality,Department,
//Classification,DegreeProgram,Category
$conn = null;
require_once('../../../connections/Connection.php');
var_dump($_POST);
var_dump($_GET);
//$StudentNo = $_REQUEST['StudentNo'];
$Name = $_REQUEST['Name'];
$PhoneNo = $_REQUEST['PhoneNo'];
$AlternatePhoneNo = $_REQUEST['AlternatePhoneNo'];
$HomeAddress = $_REQUEST['HomeAddress'];
$DateOfBirth = $_REQUEST['DateOfBirth'];
$Sex = $_REQUEST['Sex'];
$Nationality = $_REQUEST['Nationality'];
//$Department = $_REQUEST['Department'];
$Classification = $_REQUEST['Classification'];
$DegreeProgram = $_REQUEST['DegreeProgram'];
//$Category = $_REQUEST['Category'];

$UnityId = $_SESSION['NAME'];


$DegreeClassificationQuery = "SELECT * from DEGREE_CLASSIFICATION
WHERE \"Degree\"='$DegreeProgram' AND \"Classification\"='$Classification'";

var_dump($DegreeClassificationQuery);

$stid = oci_parse($conn, $DegreeClassificationQuery);
$result = oci_execute($stid);
//exit(0);
if (!$result) {
	echo oci_error();
}else{
	//	header('Location: ../HomePage.php');
}

$nrows = oci_fetch_all($stid, $isHeldResult, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if($nrows == 0) {
	echo "Invalid degree program corresponding to classification has been added. Please check the appropriate ones.";
	echo "<br><br> Click <a href=\"../HomePage.php\"> here to get redirected to home page</a>";
	exit(0);
}


$query = "UPDATE STUDENT
SET \"PhoneNo\"='$PhoneNo',
\"AlternatePhoneNo\"='$AlternatePhoneNo',\"HomeAddress\"='$HomeAddress',
\"DateOfBirth\"='$DateOfBirth',\"Sex\"='$Sex'
WHERE \"UnityId\"='$UnityId'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
//exit(0);
if (!$result) {
	echo oci_error();
}else{
	//	header('Location: ../HomePage.php');
}

$query = "UPDATE LIBRARYPATRON
SET \"Name\"='$Name',\"Nationality\"='$Nationality'
WHERE \"UnityId\"='$UnityId'		";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
//exit(0);
if (!$result) {
	echo oci_error();
}else{
	header('Location: ../HomePage.php');
}

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
//\"Classification\"='$Classification',
?>