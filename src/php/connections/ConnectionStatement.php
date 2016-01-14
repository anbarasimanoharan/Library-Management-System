<?php
//THE FOLLOWING SOURCE IS TAKEN FROM: http://php.net/manual/en/function.oci-execute.php
function fetchTuples($query,$conn){
	$stid = oci_parse($conn, $query);
	oci_execute($stid);
	echo "<table border='1'>\n";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		echo "<tr>\n";
		foreach ($row as $item) {
			echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}


?>