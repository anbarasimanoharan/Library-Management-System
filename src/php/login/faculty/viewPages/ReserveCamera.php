<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

echo "<form action=\"ReserveCameraUtil.php\">";
echo "Expected Checkout Date";
echo "<br><br>";
echo "<input type=\"date\" name=\"checkoutDate\" > ";
echo "<br><br>";
echo "<input type=\"submit\">";
echo "<br><br>";
echo"</form>";


require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");


?>