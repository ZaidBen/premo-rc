<?php
include('../cnx.php');

// Check if the project ID is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the project ID from the URL
    $id = $_GET['id'];

    // Prepare the SQL statement to delete the project
    $sql = "DELETE FROM responsable WHERE id = '$id'";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the responsible.php page or any other appropriate page
        header('Location: responsable.php');
        exit();
    } else {
        die("Error deleting record: " . $conn->error);
    }
}

// Close the database connection
$conn->close();
?>
