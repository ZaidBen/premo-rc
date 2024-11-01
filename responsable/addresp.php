<?php
include('../cnx.php');

// Start or resume the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the values from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $administration = $_POST['administration'];

    // Prepare the SQL statement
    $sql = "INSERT INTO responsable (username, password,administration) VALUES ('$username', '$password', '$administration')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = 'Responsable ajouté avec succés.';
        header('Location: responsable.php');
        exit;
    } else {
        die("<script>alert('Connection Failed.')</script>");
    }
}

// Close the database connection
$conn->close();
?>
