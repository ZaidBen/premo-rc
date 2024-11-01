<?php
include '../cnx.php';
session_start();

$username = $_SESSION['username'];
$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../admin-login.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $nom_ligne = $_POST['nom_ligne'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO liste_ligne (nom_ligne) VALUES (?)");

    // Bind the parameters to the statement
    $stmt->bind_param('s', $nom_ligne);

    // Execute the statement
    if (!$stmt->execute()) {
        echo 'Error: ' . $stmt->error;
    } else {
        echo '<script>alert("Ligne ajoutée avec succès!");</script>';
        echo '<script>window.location.href = "list_ligne.php";</script>';
        exit;
    }

    // Close the statement
    $stmt->close();
}
?>
