<?php
function fetchAndUpdateFacultyInfo($query,$conn,$nextPage){
	$stid = oci_parse($conn, $query);
	var_dump($query);
	oci_execute($stid);

	echo "<form action=\"$nextPage?user=FACULTY\">";
	echo "<table border='1'>\n";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

		$i =1;
		foreach ($row as $item) {
			echo "<tr>\n";
			$column_name  = oci_field_name($stid, $i);
			echo "<td> $column_name </td>\n";
			if($column_name == "UnityId" || $column_name == "FacultyNo"|| $column_name == "Balance"
					|| $column_name == "Type" 
							|| $column_name == "Category" || $column_name == "isHeld" || $column_name == "Department"){
				echo "    <td>" . "<input type=\"text\" name=\"$column_name\" value=\"$item\" readonly>". "</td>\n";
				
			}else{
				echo "    <td>" . "<input type=\"text\" name=\"$column_name\" value=\"$item\" >". "</td>\n";
			}
			$i++;

			echo "</tr>\n";
		}
	}
	echo "</table>\n";
	echo "<input type=\"submit\" value=\"Update\">";
	echo "</form>";

}
?>