<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

echo "<form action=\"ReserveRoomUtil.php\">";
echo "Start Time";
echo "<br><br>";
echo "<input type=\"date\" name=\"startDate\" > ";
echo "<input type=\"time\" name=\"startTime\">";
echo "<br><br>";
echo "End Time";
echo "<br><br>";
echo "<input type=\"date\" name=\"endDate\" > ";
echo "<input type=\"time\" name=\"endTime\">";

echo "<br><br>";
$query = "select distinct R.\"Capacity\"
		from ROOM R
		where R.\"Type\"='Conference'
		OR
		R.\"Type\"='Study' ";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
echo "<select name=\"occupancy\">";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

	echo "<option value=\"".$row['Capacity']."\">".$row['Capacity']."</option>";

}
echo "</select>";
echo "<br><br>";
echo "Type of room";

echo "<br><br>";
echo "<input type=\"radio\" name=\"type\" value=\"Conference\">Conference Room<br>";

echo "<input type=\"radio\" name=\"type\" value=\"Study\">study Room<br>";
echo "<br><br>";
echo "<input type=\"submit\">";
echo "<br><br>";
echo"</form>";
// <select>
// <option value="volvo">Volvo</option>
// <option value="saab">Saab</option>
// <option value="mercedes">Mercedes</option>
// <option value="audi">Audi</option>
// </select>


require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");


?>