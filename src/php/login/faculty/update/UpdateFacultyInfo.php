<?php
session_start();
//UnityId,StudentNo,Name,PhoneNo,AlternatePhoneNo,HomeAddress,DateOfBirth,Sex,Nationality,Department,
//Classification,DegreeProgram,Category
$conn = null;
require_once('../../../connections/Connection.php');


$FacultyNo = $_REQUEST['FacultyNo'];//
$Name = $_REQUEST['Name'];//
$Nationality = $_REQUEST['Nationality'];//
//$Department = $_REQUEST['Department'];//
//$Category = $_REQUEST['Category'];//

$UnityId = $_SESSION['NAME'];//

$query = "UPDATE LIBRARYPATRON
SET \"Name\"='$Name',
\"Nationality\"='$Nationality'
 WHERE \"UnityId\"='$UnityId'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	header('Location: ../HomePage.php');
}
?>