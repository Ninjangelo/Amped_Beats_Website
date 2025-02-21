<?php
// Connect to MySQL database
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$db_name = "23134228";

$mysqli = new mysqli($hostname, $username, $password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>