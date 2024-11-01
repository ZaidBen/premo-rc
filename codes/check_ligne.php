<?php
$conn = mysqli_connect("localhost", "root", "", "new_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["nom_ligne"])) {
    $nom_ligne = mysqli_real_escape_string($conn, $_POST["nom_ligne"]);
    $sql = "SELECT * FROM lignes WHERE nom = '$nom_ligne'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        echo "available";
    }
}

mysqli_close($conn);
?>
