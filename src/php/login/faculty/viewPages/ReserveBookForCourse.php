<?php

session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}
$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

// echo "<form action=\"ReserveBookForCourseUtil.php\">";
// echo "<br><br>";
// $query = "select distinct pd.\"Identifier\" as IDENTIFIER
// 		from PUBLICATION_DETAILS pd
// 		where pd.\"Type\"='Books'
// 		AND pd.\"Identifier\" NOT IN
// 		(
// 			SELECT r.\"Title\"
// 			FROM RESERVES r
// 			WHERE r.\"UnityId\" = '{$UnityId}'
// 			AND r.\"ExpiryTime\" > SYSTIMESTAMP
// 		)
// 		";
// var_dump($query);
// $stid = oci_parse($conn, $query);
// $result = oci_execute($stid);
// echo "<select name=\"Books\">";
// while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
// 	echo "<option value=\"".$row['IDENTIFIER']."\">".$row['IDENTIFIER']."</option>";
// }
// echo "</select>";
// echo "<br><br>";

// echo "<br><br>";
// $query = "select distinct c.\"CourseId\" as ID
// 		from  COURSES c
// 		";
// var_dump($query);
// $stid = oci_parse($conn, $query);
// $result = oci_execute($stid);
// echo "<select name=\"Course\">";
// while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
// 	echo "<option value=\"".$row['ID']."\">".$row['ID']."</option>";
// }
// echo "</select>";
// echo "<br><br>";

// // echo "<input type=\"radio\" name=\"type\" value=\"Conference\">Conference Room<br>";

// // echo "<input type=\"radio\" name=\"type\" value=\"Study\">study Room<br>";
// echo "<br><br>";
// echo "<input type=\"submit\">";
// echo "<br><br>";
// echo"</form>";

//echo "<form action=\"ReserveBookForCourseUtil.php\">";
echo "<br><br>";
$query = "select distinct  T.\"CourseId\", CBR.\"Identifier\"
from TEACHES T, COURSE_BOOK_REFERENCE CBR
where
CBR.\"Identifier\" NOT IN
(
SELECT r.\"Title\"
FROM RESERVES r
WHERE r.\"UnityId\" = '{$UnityId}'
AND r.\"ExpiryTime\" > SYSTIMESTAMP
) AND T.\"UnityId\"='$UnityId'
AND T.\"CourseId\"=CBR.\"Course\"
";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

echo "<Table border='2'>
		<tr>

		<td>
		Course
		</td>

		<td>
		ISBN
		</td>

		<td>
		RESERVE
		</td>

		</tr>
		";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

	echo "<tr>";

	echo "<td>";
	echo $row['CourseId'];
	echo "	</td>";

	echo "<td>";
	echo $row['Identifier'];
	echo "	</td>";

	echo "<td>";
	echo " Click to <a href=\"ReserveBookForCourseUtil.php?"."Course=".$row['CourseId']."&Books=".$row['Identifier']."\">RESERVE</a>";
	echo "</td>";


}



?>