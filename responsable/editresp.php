<?php
include('../cnx.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the values from the form
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to update the record
    $sql = "UPDATE responsable SET username = '$username', password = '$password' WHERE id = '$id'";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data updated successfully.');</script>";
        header('Location: responsable.php');
        exit;
    } else {
        die("Error updating record: " . $conn->error);
    }
}

// Close the database connection
$conn->close();
?>
