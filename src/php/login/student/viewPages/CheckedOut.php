<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}


$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$query = "select PD.\"Identifier\", PD.\"Title\",PC.\"ID\" , PC.\"CheckoutDate\",PC.\"DueDate\",PC.\"ReturnDate\" ,PD.\"Type\",PD.\"CopyType\"
		from PUBLICATION_CHECKOUT PC,PUBLICATIONS P, PUBLICATION_DETAILS PD
		where P.\"ID\"=PC.\"ID\" AND P.\"IDENTIFIER\"=PD.\"Identifier\" AND
		P.\"TYPE\"=PD.\"Type\" AND PC.\"ReturnDate\"> SYSTIMESTAMP  AND PC.\"UnityId\"='".$UnityId."'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}

$query2 = "select CC.\"ID\",CC.\"ReturnDate\", CC.\"ReservationDate\", CC.\"CheckoutDate\", C.\"MAKE\", C.\"MODEL\"
		from CAMERA_CHECKOUT CC, CAMERA C where CC.\"ID\"=C.\"ID\" AND CC.\"IsCheckedOut\"='Y'
		AND CC.\"UnityId\"='".$UnityId."'";

var_dump($query2);
$stid2 = oci_parse($conn, $query2);
$result2 = oci_execute($stid2);
if (!$result2) {
	echo oci_error();
}else{
	//working fine.
}


echo "<table border =\"2\">";
echo "<tr>";
echo "<td>";
echo "ISBN : ";
echo "</td>";

echo "<td>";
echo "TITLE : ";
echo "</td>";

echo "<td>";
echo "CheckoutDate : ";
echo "</td>";

echo "<td>";
echo "DueDate : ";
echo "</td>";

echo "<td>";
echo "ReturnDate : ";
echo "</td>";

echo "<td>";
echo "Return  ";
echo "</td>";

echo "</tr>";


while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	echo "<tr>";

	echo "<td>";
	echo $row['Identifier'];
	//TODO: add link to the book
	echo "</td>";
	echo "<td>";
	echo $row['Title'];
	//TODO: add link to the book
	echo "</td>";

	echo "<td>";
	echo $row['CheckoutDate'];
	echo "</td>";

	echo "<td>";
	echo $row['DueDate'];
	echo "</td>";

	echo "<td>";
	echo $row['ReturnDate'];
	echo "</td>";


	echo "<td>";
	echo "<a href= \"ReturnResource.php?ID=".$row['ID']."&CHECKOUT_DATE=".
			$row['CheckoutDate']."&IS_BOOK=Y&IDENTIFIER=".$row['Identifier']."&TYPE=".$row['Type']."		\"> Return </a>";
	echo "<br><br>";
	$copyType = $row['CopyType'];
	if($copyType == "Electronic copy"){
		echo "<br>It is an electronic copy, can't be renewed.<br>";
	}else{
		echo "<a href= \"RenewResource.php?ID=".$row['ID']."&CHECKOUT_DATE=".
				$row['CheckoutDate']."&IS_BOOK=Y&IDENTIFIER=".$row['Identifier']."&DUEDATE=".$row['DueDate']."&TYPE=".$row['Type']."		\"> Renew </a>";
	}
	echo "<br><br>";
	echo "</td>";

	echo "</tr>";

}


echo "</table>";


echo "<br>CAMERA CHECKOUT<br>";

echo "<table border =\"2\">";
echo "<tr>";
echo "<td>";
echo "ID : ";
echo "</td>";

echo "<td>";
echo "MAKE : ";
echo "</td>";

echo "<td>";
echo "MODEL : ";
echo "</td>";

echo "<td>";
echo "ReturnDate : ";
echo "</td>";

echo "<td>";
echo "ReservationDate : ";
echo "</td>";


echo "<td>";
echo "CheckoutDate : ";
echo "</td>";

echo "<td>";
echo "Return : ";
echo "</td>";

echo "</tr>";

//select CC.\"ID\" CC.\"ReturnDate\", CC.\"ReservationDate\", CC.\"CheckoutDate\", C.\"MAKE\", C.\"MODEL
while ($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) {
	echo "<tr>";

	echo "<td>";
	echo $row['ID'];
	//TODO: add link to the book
	echo "</td>";
	echo "<td>";
	echo $row['MAKE'];
	//TODO: add link to the book
	echo "</td>";

	echo "<td>";
	echo $row['MODEL'];
	echo "</td>";

	echo "<td>";
	echo $row['ReturnDate'];
	echo "</td>";

	echo "<td>";
	echo $row['ReservationDate'];
	echo "</td>";

	echo "<td>";
	echo $row['CheckoutDate'];
	echo "</td>";

	echo "<td>";
	echo "<a href=\"ReturnCamera.php?ID=".$row['ID']."&CHECKOUT_DATE=".$row['CheckoutDate']."\"> Return </a>";
	echo "</td>";

	echo "</tr>";

}
echo "</table>";



//Publication Checkout
//Camera Checkout
require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");
?>