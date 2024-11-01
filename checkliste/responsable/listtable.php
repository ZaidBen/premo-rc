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

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <?php
    include('../template/head.php');
    ?>
</head>

<body>
    <!-- Main navbar -->
    <?php include('../template/navbar.php') ?>
    <!-- /main navbar -->
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content">
            <div class="content-inner">
                <?php
                // Retrieve the values from the URL query parameters
                $projetl = $_GET['projetl'];
                $datet = $_GET['datet'];
                $shift = $_GET['shift'];
                $nom_lig = $_GET['nom_lig'];
                // Prepare and execute the SQL query
                $sql = "SELECT *, id, matricule, check_status, projetl, datet, shift, nom, remarque  FROM check_form1 WHERE projetl='$projetl' AND datet='$datet' AND shift='$shift' order by id desc ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc(); // Fetch the row from the query result
                    $remarque = $row['remarque']; // Assign 'remarque' value to a variable
                echo "</br>";

                echo "<div class='row'>";
                echo "<div class='col'>";
                echo "<input class='form-control'  value=' $datet' disabled>";
                echo "</div>";
                echo "<div class='col'>";
                echo "<input class='form-control'  value=' $shift' disabled>";
                echo "</div>";
                echo "<div class='col'>";
                echo "<input class='form-control'  value=' $projetl' disabled>";
                echo "</div>";
                echo "<div class='col'>";
                echo "<input class='form-control'  value=' $nom_lig' disabled>";
                echo "</div>";
                echo "</div>";

                echo "</br>";
                echo "</br>";

                echo "<H4 style='color:red'>&nbsp&nbsp&nbsp&nbspRemarque !!!</H4>";
                echo "<textarea ' class='form-control' style='width: 500px; height: 70px;' disabled>" . $row['remarque'] . "</textarea>";
                echo "</br>";
            } else {
                echo "No results found.";
            }

                // Display the matching rows in a table
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th style='display:none'>ID</th>";
                    echo "<th>Poste</th>";
                    echo "<th>Matricule</th>";
                    echo "<th>Parametre</th>";
                    echo "<th>Status</th>";
                    echo "<th>Min</th>";
                    echo "<th>Max</th>";
                    echo "<th>Valeur</th>";
                    echo "</tr>";
                
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr onclick=\"showPopup('" . $row['id'] . "','" . $row['check_status'] . "', '" . $row['valeur_min'] . "', '" . $row['valeur_max'] . "', '" . $row['valeur'] . "')\">";
                        echo "<td style='display:none'>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td><span class='badge bg-primary'>" . $row['matricule'] . "</span></td>";
                        echo "<td>" . $row['parameter'] . "</td>";
                
                        if ($row['check_status'] == 'OK') {
                            echo "<td><span class='badge bg-success'>" . $row['check_status'] . "</span></td>";
                        } elseif ($row['check_status'] == 'NOK') {
                            echo "<td><span class='badge bg-danger'>" . $row['check_status'] . "</span></td>";
                        } else {
                            echo "<td><span class='badge'>" . $row['check_status'] . "</span></td>";
                        }
                
                        echo "<td>" . $row['valeur_min'] . "</td>";
                        echo "<td>" . $row['valeur_max'] . "</td>";
                        echo "<td><span>" . $row['valeur'] . "</span></td>";
                        echo "</tr>";
                    }
                
                    echo "</table>";
                }
                else {
                    echo "No matching rows found.";
                }

                ?>
            </div>
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
    <div id="popup" class="popup" style="display: none;">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <form
                action="update.php?projetl=<?php echo urlencode($projetl); ?>&datet=<?php echo urlencode($datet); ?>&shift=<?php echo urlencode($shift); ?>&nom_lig=<?php echo urlencode($nom_lig); ?>"
                method="POST">
                <input type="hidden" name="projetl" value="<?php echo $projetl; ?>">
                <input type="hidden" name="responsable" value="<?php echo $responsable; ?>">
                <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                <input type="hidden" name="matricule" value="<?php echo $matricule; ?>">
                <input type="hidden" name="datet" value="<?php echo $datet; ?>">
                <input type="hidden" name="shift" value="<?php echo $shift; ?>">
                <input type="hidden" name="nom_lig" value="<?php echo $nom_lig; ?>">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                <label for="check_status">Check Status:</label>
                <input type="text" id="check_status" name="check_status" placeholder="Check Status">
                <br>
                <label for="valeur_min">Valeur Min:</label>
                <input type="text" id="valeur_min" name="valeur_min" placeholder="Valeur Min" readonly>
                <br>
                <label for="valeur_max">Valeur Max:</label>
                <input type="text" id="valeur_max" name="valeur_max" placeholder="Valeur Max" readonly>
                <br>
                <label for="valeur">Valeur:</label>
                <input type="text" id="valeur" name="valeur" placeholder="Valeur">
                <br>
                <input type="submit" value="Enregistrer">
            </form>
        </div>
    </div>
</body>

</html>
<style>
    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        max-width: 500px;
    }

    .popup-content {
        text-align: center;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }



    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    tr:not(:last-child) {
        border-bottom: 5px solid black;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f2f2f2;
    }
</style>
<script>
    var popup = document.getElementById("popup");

    // Function to show the popup and populate values
    function showPopup(id, checkStatus, valeurMin, valeurMax, valeur) {
        // Populate the form inputs in the popup with the row values
        document.getElementById("id").value = id;
        document.getElementById("check_status").value = checkStatus;
        document.getElementById("valeur_min").value = valeurMin;
        document.getElementById("valeur_max").value = valeurMax;
        document.getElementById("valeur").value = valeur;

        // Display the popup
        popup.style.display = "block";
    }

    // Function to close the popup
    function closePopup() {
        popup.style.display = "none";
    }
</script>