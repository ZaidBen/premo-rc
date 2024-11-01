<?php
// Make database connection
$conn = mysqli_connect("localhost", "root", "", "new_database");

$projet2 = mysqli_real_escape_string($conn, $_POST["projet2"]);
$query = "SELECT * FROM list_projet WHERE nom_projet = '$projet2'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Value already exists
    echo 'exists';
} else {
    // Value doesn't exist
    echo 'not-exists';
}
?>
