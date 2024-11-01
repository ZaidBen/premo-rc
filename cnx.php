<?php 

$server = "localhost";
$user = "root";
$pass = "E7DnO9eoP7Clc9Zw";
$database = "new_database";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>