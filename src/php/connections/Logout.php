<?php

session_start();
// Unset the session variables.
$_SESSION = array();

session_destroy();
echo "<br>You have been logged out..!!<br>";

echo "<br> Click <a href=\"../login\"> Here </a>to get redirected to login page<br>";
?>