<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];


$course = $_REQUEST['Course'];
$isbn = $_REQUEST['Books'];

echo "<br> <br>";

$ReserveBookQuery ="INSERT INTO RESERVES VALUES('{$UnityId}','{$course}','{$isbn}',SYSTIMESTAMP,(SYSTIMESTAMP + INTERVAL '4' MONTH))";

var_dump($ReserveBookQuery);
$stid = oci_parse($conn, $ReserveBookQuery);
$result = oci_execute($stid);
if(!$result) {
	echo "Some error occurred while reserving book. If error persists contact support.";
	echo "<a href=\"ReserveBookForCourse.php\">Back</a>";
	echo "<br> <br>";
}
else {
	$query = "INSERT INTO NOTIFICATION VALUES('{$UnityId}',SYSTIMESTAMP,'Book with ISBN ' || '$isbn' || ' has been reserved for course ' || '$course' || ' and expires in 4 months ')";	
	var_dump($query);
	$stid = oci_parse($conn,$query);
	$result = oci_execute($stid);
	if(!$result) {
		echo " Unexpected error occurred while pushing notification. But book has been reserved for the course";
	} else {
		echo "<a href=\"Notifications.php\">Notifications!</a>";
		echo "<br> <br>";
	}
//ADD TO PUBLICATION DETAILS : update IsReserved = 'Y'

	$query = "UPDATE PUBLICATION_DETAILS SET \"IsReserved\"='Y' 
			where \"Identifier\"='$isbn' AND \"Type\"='Books'";
	var_dump($query);
	$stid = oci_parse($conn,$query);
	$result = oci_execute($stid);
	if(!$result) {
		echo " Unexpected error occurred while pushing notification. But book has been reserved for the course";
	} else {

	}
	
}


?>