<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];


$query = "select CQ.\"DateOfQueue\", CQ.\"ID\",CQ.\"WaitlistNumber\" ,
		C.\"MAKE\",C.\"MODEL\",C.\"LENS_CONFIGURATION\" ,C.\"LOCATION\"
		,C.\"IS_RESERVED\",C.\"MEMORY\"
		from CAMERA_QUEUE CQ,CAMERA C
		where C.\"ID\"=CQ.\"ID\" AND CQ.\"UnityId\"='".$UnityId."'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}

echo "<table border=\"2\">";
echo "<tr>";

echo "<td>";
echo "Camera ID";
echo "</td>";

echo "<td>";
echo "MAKE";
echo "</td>";

echo "<td>";
echo "MODEL";
echo "</td>";


echo "<td>";
echo "LENS_CONFIGURATION";
echo "</td>";

echo "<td>";
echo "LOCATION";
echo "</td>";

echo "<td>";
echo "MEMORY";
echo "</td>";

echo "<td>";
echo "DateOfQueue";
echo "</td>";

echo "<td>";
echo "STATUS";
echo "</td>";
echo "</tr>";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){


	echo "<tr>";

	echo "<td>";
	echo $row['ID'];
	echo "</td>";

	echo "<td>";
	echo "".$row['MAKE'];
	echo "</td>";

	echo "<td>";
	echo "".$row['MODEL'];
	echo "</td>";

	echo "<td>";
	echo "".$row['LENS_CONFIGURATION'];
	echo "</td>";

	echo "<td>";
	echo "".$row['LOCATION'];
	echo "</td>";


	echo "<td>";
	echo "".$row['MEMORY'];
	echo "</td>";

	echo "<td>";
	echo "".$row['DateOfQueue'];
	echo "</td>";

	echo "<td>";
	$currentTime = strtotime("now");
	$startTime = $row['DateOfQueue'];
	$startTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $startTime)->getTimestamp();
	$duration_min= round(($currentTime - $startTime) / 60,0);

	if($duration_min >480 && $duration_min< 720){
		//=> greater than 8 AM(480) and Less than 12 PM
		if($row['IS_RESERVED'] == 'N'){
			$camId = $row['ID'];
			$query2 = "select CQ.\"UnityId\" from CAMERA_QUEUE CQ
			where CQ.\"ID\"='$camId'
			AND TO_DATE(CAST(CQ.\"DateOfQueue\" AS DATE))=TO_DATE(SYSDATE)
			AND CQ.\"WaitlistNumber\"=
			(select MIN(\"WaitlistNumber\") from CAMERA_QUEUE where \"ID\"='$camId' AND
			TO_DATE(CAST(CQ.\"DateOfQueue\" AS DATE))=TO_DATE(SYSDATE))  ";

			var_dump($query2);
			$stid2 = oci_parse($conn, $query2);
			$result2 = oci_execute($stid2);
			if (!$result) {
				echo oci_error();
			}else{
				//working fine.
			}
			$row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
			if(isset($row2['UnityId']) && $row2['UnityId'] == $UnityId){
				echo "click <a href=\"CheckoutCameraUtil.php?".
				"ID=".$row['ID']."&UNITY_ID=".$UnityId."&DATE_OF_QUEUE=".$row['DateOfQueue']."\">here</a> for checkout";

			}
			else{
				echo "your waitlist number :".$row['WaitlistNumber'];
			}
		}else{
			echo "CAMERA NOT AVAILABLE";
		}
	}else{
		echo "Check out can only be done in between 8AM and 12 PM on the day of reservation";
	}


	echo "</td>";

	echo "</tr>";

}

echo "</table>";

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>