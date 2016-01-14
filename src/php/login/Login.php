<?php
//Check out Swingbench
$typeOfPatrol = $_REQUEST["USER"];

//echo "$typeOfPatrol";
echo "<form action=\"CheckCredentials.php\" method=\"post\" \">
		UNITY ID:<br>
		<input type=\"text\" name=\"NAME\" value=\"\">
		<br>PASSWORD:<br>
		<input type=\"password\" name=\"PASSWORD\" value=\"\">
		<br><br>
		<input type=\"password\" name=\"USER\" style=\"display:none\"   value=".$typeOfPatrol.">
				<br><br>
				<input type=\"submit\" value=\"Submit\">
				</form>";


?>