<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../index.php');
	echo "Some thing wrong with session";
}

echo $_SESSION['NAME'] ;
echo "<br><br>";
echo $_SESSION['USER'];
echo "<br><br>";
$conn = null;
require_once('../../connections/Connection.php');

require_once('update\UpdateFacultyInfoUtils.php');
$UnityId = $_SESSION['NAME'] ;
$query = "select F.\"UnityId\",F.\"FacultyNo\",F.\"Category\",
		L.\"Name\",L.\"Nationality\",L.\"Department\",L.\"Type\",L.\"Balance\" 
		FROM FACULTY F, LIBRARYPATRON L WHERE F.\"UnityId\" = L.\"UnityId\" 
		and F.\"UnityId\" = "."'".$UnityId."'";
$nextPage = "update/UpdateFacultyInfo.php";
fetchAndUpdateFacultyInfo($query,$conn,$nextPage);


// HINT: Use readonly attribute in input text.
//Country: <input type="text" name="country" value="Norway" readonly><br>
?>