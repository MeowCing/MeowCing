<?php
$host = "localhost";
$database = "e commers";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}
?>