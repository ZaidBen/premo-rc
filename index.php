<?php
include 'cnx.php';
session_start();
error_reporting(0);
if (!isset($_SESSION['username'])) {
	header("Location: login/admin-login.php");

}
$username = $_SESSION['username'];
$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);

?>