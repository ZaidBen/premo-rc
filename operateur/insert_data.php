<?php
// Establish database connection
include('../cnx.php');

// Insert data into database
if (isset($_POST['matricule'])) {
    $matricules = isset($_POST['matricule']) ? $_POST['matricule'] : array();
    $usernames = isset($_POST['username']) ? $_POST['username'] : array();
    $responsables = isset($_POST['responsable']) ? $_POST['responsable'] : array();
    $lignes = isset($_POST['ligne']) ? $_POST['ligne'] : array();
    $postes = isset($_POST['poste']) ? $_POST['poste'] : array();

    $success = true; // Set success to true by default

    for ($i = 0; $i < count($matricules); $i++) {
        $matricule = mysqli_real_escape_string($conn, isset($matricules[$i]) ? $matricules[$i] : '');
        $username = mysqli_real_escape_string($conn, isset($usernames[$i]) ? $usernames[$i] : '');
        $responsable = mysqli_real_escape_string($conn, isset($responsables[$i]) ? $responsables[$i] : '');
        $ligne = mysqli_real_escape_string($conn, isset($lignes[$i]) ? $lignes[$i] : '');
        $poste = mysqli_real_escape_string($conn, isset($postes[$i]) ? $postes[$i] : '');

        $sql = "INSERT INTO operateur (matricule, username, ligne, poste, responsable) VALUES ('$matricule', '$username', '$ligne', '$poste', '$responsable')";
        if (!$conn->query($sql)) {
            $success = false; // Set success to false if an error occurred
        }
    }

    if ($success) {
        echo "<script>alert('Operateur ajouter avec succes.')</script>"; // Display success message
    }

    header('Location: '.$_SERVER['HTTP_REFERER']);
    exit;
}

$conn->close();
?>
