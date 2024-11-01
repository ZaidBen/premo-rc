<?php
// Make database connection
$conn = mysqli_connect("localhost", "root", "", "new_database");

$matricule = mysqli_real_escape_string($conn, $_POST["matricule"]);
$query = "SELECT * FROM operateur WHERE matricule = '$matricule'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Value already exists
    echo 'exists';
} else {
    // Value doesn't exist
    echo 'not-exists';
}
?>
