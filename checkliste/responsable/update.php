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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $id = $_POST['id'];
    $check_status = $_POST['check_status'];
    $valeur_min = $_POST['valeur_min'];
    $valeur_max = $_POST['valeur_max'];
    $valeur = $_POST['valeur'];

    // Perform the necessary update operations using the provided ID
    $query = "UPDATE check_form1 SET check_status='$check_status', valeur_min='$valeur_min', valeur_max='$valeur_max', valeur='$valeur' WHERE id='$id'";
    mysqli_query($conn, $query);

    // Get the URL parameters
    $projetl = isset($_GET['projetl']) ? $_GET['projetl'] : '';
    $datet = isset($_GET['datet']) ? $_GET['datet'] : '';
    $shift = isset($_GET['shift']) ? $_GET['shift'] : '';
    $nom_lig = isset($_GET['nom_lig']) ? $_GET['nom_lig'] : '';

    // Build the redirect URL
    $redirectUrl = "listtable.php?projetl=" . urlencode($projetl) . "&datet=" . urlencode($datet) . "&shift=" . urlencode($shift) . "&nom_lig=" . urlencode($nom_lig);

    // Perform the necessary checks
    if (!empty($projetl) && !empty($datet) && !empty($shift) && !empty($nom_lig)) {
        // Redirect the user to the desired URL
        header("Location: $redirectUrl");
        exit();
    }
}
?>
