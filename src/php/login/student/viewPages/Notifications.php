<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$insert_camera_notif_sql="SELECT 'Camera with ID ' || c.\"ID\" || ' and with due date ' || (c.\"CheckoutDate\" + INTERVAL '6' DAY) || ' is ' || (FLOOR(EXTRACT(DAY from (SYSTIMESTAMP - (c.\"CheckoutDate\" + INTERVAL '6' DAY)))/30))*30 || ' days past due . Please return to avoid reduced fine.' as NOTIF
FROM CAMERA_CHECKOUT c
WHERE c.\"UnityId\" = '{$UnityId}'
AND EXTRACT(DAY from (SYSTIMESTAMP - (c.\"CheckoutDate\" + INTERVAL '6' DAY))) > 30
AND c.\"ReturnDate\" > SYSTIMESTAMP
AND c.\"ID\" || ' camera with due date ' || (c.\"CheckoutDate\" + INTERVAL '6' DAY) || ' is ' || (FLOOR(EXTRACT(DAY from (SYSTIMESTAMP - (c.\"CheckoutDate\" + INTERVAL '6' DAY)))/30))*30 || ' days past due . Please return to avoid reduced fine.'
NOT IN (SELECT CAST(n.\"INFORMATION\" as VARCHAR2(500)) FROM NOTIFICATION n WHERE n.\"UNITYID\"='{$UnityId}')";

var_dump($insert_camera_notif_sql);
$stid = oci_parse($conn,$insert_camera_notif_sql);
$result = oci_execute($stid);

$nrows=oci_fetch_all($stid, $camera_notif, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if($nrows > 0){
	foreach($camera_notif as $notif) {
		$notification = $notif['NOTIF'];
		$insert_notification_sql="INSERT INTO NOTIFICATION VALUES('{$UnityId}',
							  SYSTIMESTAMP,'{$notification}')";
		var_dump($insert_notification_sql);
		$stid = oci_parse($conn,$insert_notification_sql);
		$result = oci_execute($stid);
	}
}


$insert_publication_notif_sql="SELECT ' Publication with ID ' || p.\"ID\" || ' and due date ' || p.\"DueDate\" || ' is ' || (FLOOR(EXTRACT(DAY from (SYSTIMESTAMP - p.\"DueDate\"))/30))*30 || ' past due . Please return to avoid reduced fine.'   as NOTIF
FROM PUBLICATION_CHECKOUT p
WHERE p.\"UnityId\" = '{$UnityId}'
AND EXTRACT(DAY from (SYSTIMESTAMP - p.\"DueDate\")) > 30
AND p.\"ReturnDate\" > SYSTIMESTAMP
AND p.\"ID\" || ' publication with due date ' || p.\"DueDate\" || ' is ' || (FLOOR(EXTRACT(DAY from (SYSTIMESTAMP - p.\"DueDate\"))/30))*30 || ' past due . Please return to avoid reduced fine.' 
NOT IN (SELECT CAST(n.\"INFORMATION\" as VARCHAR2(500)) FROM NOTIFICATION n WHERE n.\"UNITYID\"='{$UnityId}')";

var_dump($insert_publication_notif_sql);
$stid = oci_parse($conn,$insert_publication_notif_sql);
$result = oci_execute($stid);

$nrows=oci_fetch_all($stid, $publication_notif, null, null, OCI_FETCHSTATEMENT_BY_ROW);
if($nrows > 0){
	foreach($publication_notif as $notif) {
		$notification = $notif['NOTIF'];
		$insert_notification_sql="INSERT INTO NOTIFICATION VALUES('{$UnityId}',
		SYSTIMESTAMP,'{$notification}')";
		var_dump($insert_notification_sql);
		$stid = oci_parse($conn,$insert_notification_sql);
		$result = oci_execute($stid);
	}
}

$query = "select N.\"TIME\",N.\"INFORMATION\"
		from NOTIFICATION N
		where N.\"UNITYID\"='".$UnityId."'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

echo "<table border=\"2\">";
echo "<tr>";

echo "<td>";
echo "TIME";
echo "</td>";
echo "<td>";
echo "INFORMATION";
echo "</td>";

echo "</tr>";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	echo "<tr>";

	echo "<td>";
	echo $row['TIME'];
	//TODO: add link to the book
	echo "</td>";
	echo "<td>";
	echo $row['INFORMATION']->load();
	//TODO: add link to the book
	echo "</td>";

	echo "</tr>";

}

echo "</table>";

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");

?>