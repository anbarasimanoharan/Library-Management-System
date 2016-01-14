<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];


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