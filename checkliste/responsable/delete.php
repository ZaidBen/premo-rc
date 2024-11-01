<?php
include('../../cnx.php');
session_start();
error_reporting(0);
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Redirect to index.php if the user is not logged in
    header("Location: ../index.php");
    exit();
}

// Check if the required parameters are present
if (
    isset($_GET['datet']) &&
    isset($_GET['shift']) &&
    isset($_GET['projetl'])
) {
    // Retrieve the values from the URL parameters
    $datet = $_GET['datet'];
    $shift = $_GET['shift'];
    $projetl = $_GET['projetl'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Create the SQL query to delete the records
        $sql = "DELETE FROM check_form1 WHERE datet = '$datet' AND shift = '$shift' AND projetl = '$projetl'";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Records deleted successfully
            echo "<script>alert('Records deleted successfully.'); window.location.href = 'delete_by_shift.php?projetl=$projetl&datet=$datet&shift=$shift';</script>";
        } else {
            // Error occurred while deleting records
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        // Display the confirmation message
        echo "<script>
            var confirmed = confirm('Are you sure you want to delete the list?');
            if (confirmed) {
                window.location.href = 'delete.php?datet=$datet&shift=$shift&projetl=$projetl&confirm=yes';
            } else {
                window.location.href = 'delete_by_shift.php?projetl=$projetl&datet=$datet&shift=$shift';
            }
        </script>";
    }
} else {
    // Required parameters are missing
    echo "<script>alert('Missing parameters for deletion.');</script>";
}
?>
