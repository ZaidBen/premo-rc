<?php
include('../cnx.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $nom_ligne = $_POST['nom_ligne'];
    $nom_lig = $_POST['nom_lig'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];
    $responsable = $_POST['responsable'];
    $of = $_POST['of'];
    $remarque = $_POST['remarque'];

    // Get id of ligne with matching nom
    $stmt = $conn->prepare("SELECT id FROM lignes WHERE nom = ?");
    $stmt->bind_param("s", $nom_lig);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ligne_id = $row["id"];
    } else {
        echo "Error: Ligne not found.";
        exit();
    }

    // Prepare the INSERT statement for check_form1 table
    $insertStatement = $conn->prepare("INSERT INTO check_form1 (nom_lig, matricule, parameter, valeur_min, valeur_max, valeur, apres_ajustement, check_status, nom_ligne, nom, datet, shift, responsable, of, remarque, AA_valeur, AA_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$insertStatement) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    // Get all postes with matching ligne_id
    $stmt = $conn->prepare("SELECT * FROM postes WHERE ligne_id = ?");
    $stmt->bind_param("i", $ligne_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posteNom = $row["nom"];
            $matricule = isset($_POST['matricule'][$row["id"]]) ? $_POST['matricule'][$row["id"]] : '';

            // Get parameters for the poste
            $stmt2 = $conn->prepare("SELECT * FROM postes_parameters WHERE poste_id = ?");
            $stmt2->bind_param("i", $row["id"]);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $parameter = $row2["parameter"];
                    $valeur_min = isset($_POST['valeur_min'][$row["id"]][$row2["id"]]) ? (float)$_POST['valeur_min'][$row["id"]][$row2["id"]] : (float)$row2["valeur_min"];
                    $valeur_max = isset($_POST['valeur_max'][$row["id"]][$row2["id"]]) ? (float)$_POST['valeur_max'][$row["id"]][$row2["id"]] : (float)$row2["valeur_max"];
                    $valeur = isset($_POST['valeur'][$row["id"]][$row2["id"]]) ? (float)$_POST['valeur'][$row["id"]][$row2["id"]] : null;
                    $check_status = "";
                    if (isset($_POST['check_status_ok'][$row["id"]][$row2["id"]])) {
                        $check_status = "OK";
                    } elseif (isset($_POST['check_status_nok'][$row["id"]][$row2["id"]])) {
                        $check_status = "NOK";
                    }
                    $apres_ajustement = isset($_POST['apres_ajustement'][$row["id"]][$row2["id"]]) ? $_POST['apres_ajustement'][$row["id"]][$row2["id"]] : null;
                    $AA_valeur = isset($_POST['AA_valeur'][$row["id"]][$row2["id"]]) ? $_POST['AA_valeur'][$row["id"]][$row2["id"]] : null;
                    $AA_status = "";
                    if (isset($_POST['AA_status_1'][$row["id"]][$row2["id"]])) {
                        $AA_status = "OK";
                    } elseif (isset($_POST['AA_status_2'][$row["id"]][$row2["id"]])) {
                        $AA_status = "NOK";
                    }

                    // Create a separate variable for matricule
                    $matriculeValue = $matricule;

                    // Bind the values to the prepared statement
                    $insertStatement->bind_param("sssssssssssssssss", $nom_lig, $matriculeValue, $parameter, $valeur_min, $valeur_max, $valeur, $apres_ajustement, $check_status, $nom_ligne, $posteNom, $date, $shift, $responsable, $of, $remarque, $AA_valeur, $AA_status);

                    // Execute the prepared statement
                    if (!$insertStatement->execute()) {
                        echo "Error: " . $insertStatement->error;
                        exit();
                    }
                }
            } else {
                echo "Error: No parameters found for the poste.";
                exit();
            }
        }
    } else {
        echo "Error: No postes found for the ligne.";
        exit();
    }

    // Close the prepared statement
    $insertStatement->close();

    // Show success message
    echo "Records added successfully!";

    // Redirect to index.php
    header("Location: index.php");
    exit();
}

// Close the database connection
$conn->close();
?>
