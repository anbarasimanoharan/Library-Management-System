<?php
session_start();

if(!isset($_SESSION['NAME'])){
	header('Location: ../../../login/index.php');
	echo "Some thing wrong with session";
}

echo $_SESSION['NAME'] ;
echo "<br><br>";
echo $_SESSION['USER'];
echo "<br><br>";
$conn = null;
require_once('../../connections/Connection.php');
require_once('publications/checkoutPublicationsUtil.php');
$UnityId = $_SESSION['NAME'] ;
$userType = $_SESSION['USER'];
var_dump($conn);
echo "<br><br>";

$identifier=$_GET['id'];
$type=$_GET['type'];

$id_sql="SELECT min(p.\"ID\") as ID FROM PUBLICATIONS p WHERE p.\"IDENTIFIER\"='{$identifier}'
		AND p.\"TYPE\" = '${type}' AND p.\"IsAvailable\"='Y'";
$result=run_sql($conn,$id_sql);
var_dump($result);
$reserved_sql="SELECT pd.\"IsReserved\" as isReserved,pd.\"CopyType\" as CopyType FROM PUBLICATION_DETAILS pd WHERE pd.\"Type\" = '{$type}'
				AND pd.\"Identifier\"='{$identifier}'";
$is_reserved_result=run_sql($conn,$reserved_sql);
var_dump($is_reserved_result);
if(sizeof($is_reserved_result)>0) {
	$is_reserved=$is_reserved_result[0]['ISRESERVED'];
	$copy_type=$is_reserved_result[0]['COPYTYPE'];
}

$duration = get_checkout_duration($type,$userType,$copy_type,$is_reserved);
if(sizeof($result) == 1) {
	$id = $result[0]['ID'];
	$insert_sql="INSERT INTO PUBLICATION_CHECKOUT VALUES('{$UnityId}',$id,SYSTIMESTAMP,".$duration.",CAST('31/DEC/9999' AS TIMESTAMP))";
	$parsed = oci_parse($conn,$insert_sql);
	oci_execute($parsed);
	$update_sql="UPDATE PUBLICATIONS SET \"IsAvailable\"='N' where \"ID\"='{$id}'";
	$parsedUpdate = oci_parse($conn,$update_sql);
	oci_execute($parsedUpdate);
}

function get_checkout_duration($publication_type,$userType,$copy_type,$is_reserved){
	if($copy_type == 'Electronic copy') $duration = "CAST('31/DEC/9999' AS TIMESTAMP)";
	else {
		if($publication_type == 'Books') {
			if($is_reserved == 'Y')
				$duration = "SYSTIMESTAMP + INTERVAL '4' HOUR";
			else {
				if($userType == 'Faculty')
					$duration = "SYSTIMESTAMP + INTERVAL '720' HOUR";
				else if($userType == 'Student')
					$duration = "SYSTIMESTAMP + INTERVAL '360' HOUR";
			}
		}
		else if($publication_type=='Journals' ||  $publication_type=='Conferences') {
			$duration = "SYSTIMESTAMP + INTERVAL '12' HOUR";
		}
	}
	if(isset($duration))
		return $duration;
	else
		return "SYSTIMESTAMP";
}

echo "<a href=\"../../login/faculty/viewPages/CheckedOut.php\">Checked Out Resources!</a>";
?>
