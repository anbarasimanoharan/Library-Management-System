<?php



function fetchInfo($query,$conn){
	$stid = oci_parse($conn, $query);
	var_dump($query);

	oci_execute($stid);


	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

		$i =1;
		echo "<tr>\n";
			
		foreach ($row as $item) {
			$column_name  = oci_field_name($stid, $i);
			{
				echo "    <td>" .$item  ."</td>\n";
			}
			$i++;

			
		}
		echo "</tr>\n";
	}

}


session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$queryBooks ="select * from PUBLICATION_WAITLIST where \"UnityId\"='$UnityId'";

$queryRooms = "select * from ROOM_RESERVATION where \"StartTime\">SYSTIMESTAMP AND \"UnityID\"='$UnityId'";

$queryCamera ="select * from CAMERA_QUEUE where \"DateOfQueue\">SYSTIMESTAMP AND \"UnityId\"='$UnityId'";


echo "<table border='1'>\n";
echo "<tr>";

echo "<td>";
echo "UNITY_ID";
echo "</td>";

echo "<td>";
echo "ISBN";
echo "</td>";

echo "<td>";
echo "BOOK TYPE";
echo "</td>";

echo "<td>";
echo "QUEUE ID";
echo "</td>";

echo "</tr>";

fetchInfo($queryBooks,$conn);
echo "</table>\n";
//------------------------------------------------
echo "<table border='1'>\n";

echo "<tr>";

echo "<td>";
echo "UNITY_ID";
echo "</td>";

echo "<td>";
echo "ROOM NO";
echo "</td>";

echo "<td>";
echo "LOCATION";
echo "</td>";

echo "<td>";
echo "FROM";
echo "</td>";

echo "<td>";
echo "TO";
echo "</td>";

echo "<td>";
echo "OCCUPANCY";
echo "</td>";


echo "<td>";
echo "--";
echo "</td>";

echo "</tr>";

fetchInfo($queryRooms,$conn);
echo "</table>\n";
//===========================================================
echo "<table border='1'>\n";
echo "<tr>";

echo "<td>";
echo "UNITY_ID";
echo "</td>";

echo "<td>";
echo "RESERVATION DATE";
echo "</td>";

echo "<td>";
echo "MODEL";
echo "</td>";

echo "<td>";
echo "-";
echo "</td>";
echo "</tr>";

fetchInfo($queryCamera,$conn);
echo "</table>\n";



?>