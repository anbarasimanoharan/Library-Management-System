<?php
function verifyCredentials($conn,$user,$password){
	//$user=mysql_real_escape_string($user);
	//$password = mysql_real_escape_string($password);
	
	$query = "select * from AUTHENTICATION where \"UnityId\"='".$user."' AND \"Password\"='".$password."'";
	var_dump($query);
	//echo "<br>";
	//sleep(4);
	//exit(0);
	$stid = oci_parse($conn, $query);
	oci_execute($stid);

	$noOfRows = oci_fetch_all($stid, $res);
	oci_free_statement($stid);
	
	if($noOfRows == 1){
		echo "in rows == 1";
		return true;

	}else{
		echo "in rows == 0";
		return false;
	}
}
?>