
<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}
require_once('../../connections/Connection.php');

echo "<a href=\"HomePage.php\">Profile!</a>";
echo "<br> <br>";
echo "<a href=\"viewPages/AccountBalance.php\">Account Balance!</a>";
echo "<br> <br>";
$UnityId=$_SESSION['NAME'];
$query="SELECT \"isHeld\" AS HOLD FROM STUDENT WHERE \"UnityId\" = '{$UnityId}'";
$stid = oci_parse($conn,$query);
oci_execute($stid);
$nrows = oci_fetch_all($stid, $isHeldResult, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if($nrows == 1) {
	$isHeld = $isHeldResult[0]['HOLD'];
} else {
	echo "No rows returned";
}
if($isHeld == 'Y') {
	echo "Reset balance from Account balance link to access library resources.";
}
else {
	echo "<a href=\"../../checkout/student/publications/CheckoutPublications.php\">To Check Out Resources!</a>";
	echo "<br> <br>";

	echo "<a href=\"viewPages/CheckedOut.php\">Checked Out Resources(BOOKS AND CAMERAS)!</a>";
	echo "<br> <br>";
	echo "<a href=\"viewPages/Notifications.php\">Notifications!</a>";
	echo "<br> <br>";

	echo "<a href=\"viewPages/ReserveRoom.php\">Reserve Room!</a>";
	echo "<br> <br>";
	echo "<a href=\"viewPages/RoomCheckInCheckout.php\">Room CheckIn And Checkout!</a>";
	echo "<br> <br>";


	echo "<a href=\"viewPages/ReserveCamera.php\">Reserve Camera!</a>";
	echo "<br> <br>";


	echo "<a href=\"viewPages/CheckoutCamera.php\">Checkout Camera!</a>";
	echo "<br> <br>";
	echo "<a href=\"viewPages/RequestedResources.php\">Requested Resources!</a>";
	echo "<br> <br>";
	
}

require_once('../../connections/LogoutUtil.php');
logout("../../connections/");

?>