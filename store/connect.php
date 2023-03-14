<?php
$host="localhost"; // Host name
$username="sevns"; // Mysql username
$password="6u2KuF5tKW"; // Mysql password
$db_name="sevns_smeg"; // Database name
$tbl_name="servers"; // DO NOT TOUCH

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("Sorry, Our Site Is Currently Offline.");

$conn = mysqli_connect($host, $username, $password, $db_name);

?>
