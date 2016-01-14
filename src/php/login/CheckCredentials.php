<?php

$conn = null;

require_once('../connections/Connection.php');

echo "<br> <br>";
echo "UserName :".$_REQUEST["NAME"];
echo "<br> <br>";
echo "Password:".$_REQUEST["PASSWORD"];

echo "<br> <br>";
echo "TYPE OF USER:".$_REQUEST["USER"];

echo "<br> <br>";


require_once ('../connections/VerifyCredentials.php');


if(verifyCredentials($conn,$_REQUEST["NAME"],$_REQUEST["PASSWORD"])){
	// if credentials are okay then.
	session_start();
	$_SESSION['NAME'] = $_REQUEST["NAME"];
	$_SESSION['USER'] = $_REQUEST["USER"];	
	if($_SESSION['USER'] == "Student"){
		header('Location: student/index.php');
	}else{
		header('Location: faculty/index.php');
	}
}else{
	// if credentials fails =>
	
	header('Location: index.php');
}

?>