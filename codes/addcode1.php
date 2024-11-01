<?php
include('../cnx.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $nom_ligne = mysqli_real_escape_string($conn, $_POST["nom_ligne"]);
    $projet = "";

    if (isset($_POST["projet"]) && $_POST["projet"] === "projet_existant") {
        $projet = mysqli_real_escape_string($conn, $_POST["projet1"]);
    } else if (isset($_POST["projet"]) && $_POST["projet"] === "nouveau_projet") {
        $projet2 = mysqli_real_escape_string($conn, $_POST["projet2"]);
        $projet = $projet2;
    }
    $sql = "INSERT INTO lignes (nom, projet) VALUES ('$nom_ligne', '$projet')";

    // Insert projet data

    $nom_projet = mysqli_real_escape_string($conn, $_POST["projet2"]);

    if (!empty($nom_projet)) {
        $sql = "INSERT INTO list_projet (nom_projet) VALUES ('$nom_projet')";

        if (mysqli_query($conn, $sql)) {
            // Success
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    // Insert ligne data
    $sql = "INSERT INTO lignes (nom, projet) VALUES ('$nom_ligne', '$projet')";

    if (mysqli_query($conn, $sql)) {
        $ligne_id = mysqli_insert_id($conn);
        // Insert poste data
        if (isset($_POST["nom_poste"])) {
            $nom_postes = $_POST["nom_poste"];

            foreach ($nom_postes as $nom_poste) {
                $nom_poste = mysqli_real_escape_string($conn, $nom_poste);
                $sql1 = "INSERT INTO postes (ligne_id,nom) VALUES ('$ligne_id','$nom_poste')";
                if (!mysqli_query($conn, $sql1)) {
                    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                }
            }
        }
        
        header("Location: ligne.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    header("Location: ligne.php");
}
?>