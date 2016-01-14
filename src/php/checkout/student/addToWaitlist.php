<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../../login/index.php');
	echo "Some thing wrong with session";
}

echo $_SESSION['NAME'] ;
echo "<br><br>";
echo $_SESSION['USER'];
echo "<br><br>";
$conn = null;
require_once('../../connections/Connection.php');
require_once('publications/checkoutPublicationsUtil.php');
$UnityId = $_SESSION['NAME'] ;
$userType = $_SESSION['USER'];
var_dump($conn);
echo "<br><br>";

$identifier=$_GET['id'];
$type=$_GET['type'];

$max_waitlist_sql="SELECT max(pw.\"Waitlist_No\")+1 as Waitlist_No FROM PUBLICATION_WAITLIST pw WHERE pw.\"Identifier\"='{$identifier}'
		AND pw.\"Type\" = '${type}' GROUP BY pw.\"Type\",pw.\"Identifier\"";
$result=run_sql($conn,$max_waitlist_sql);
var_dump($result);


	$waitlist_No=isset($result[0]['WAITLIST_NO'])==true?$result[0]['WAITLIST_NO']:1;
	$insert_sql="INSERT INTO PUBLICATION_WAITLIST VALUES('{$UnityId}','{$identifier}','{$type}',$waitlist_No)";
	var_dump($insert_sql);
	$parsed = oci_parse($conn,$insert_sql);
	oci_execute($parsed);

	echo "Your waitlist is ".$waitlist_No;
	echo "<a href=\"../../login/student/viewPages/CheckedOut.php\">Checked Out Resources!</a>";
?>
