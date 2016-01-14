<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../index.php');
	echo "Some thing wrong with session";
}
$conn = null;
require_once('../../../connections/Connection.php');
$UnityId = $_SESSION['NAME'];

$query = "select \"Balance\" from LIBRARYPATRON where \"UnityId\"='".$UnityId."'";
var_dump($query);
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
if (!$result) {
	echo oci_error();
}else{
	//working fine.
}
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$balance =$row['Balance'];
echo "Your balance ".$balance;
if($balance < 0){
	echo "click here to clear your account Balance <a href=\"ResetBalance.php\">Clear Balance</a>";
}

require_once('../../../connections/LogoutUtil.php');
logout("../../../connections/");


?>