<?php
include('../cnx.php');
// Get form data
$nom_ligne = $_POST['nom_ligne'];
$nom_lig = $_POST['nom'];
$date = $_POST['date'];
$shift = $_POST['shift'];
$responsable = $_POST['responsable'];
$of = $_POST['of'];
// Get id of ligne with matching nom
$sql = "SELECT id FROM lignes WHERE nom='$nom_lig'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $ligne_id = $row["id"];
} else {
    echo "Error: Ligne not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <?php
    include('../head1.php');
    ?>
</head>

<body>
    <!-- Main navbar -->
    <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
        <div class="container-fluid">
            <div class="navbar-brand flex-1 flex-lg-0">
                <a href="index.php" class="d-inline-flex align-items-center">
                    <h3 class="sidebar-resize-hide flex-grow-1 my-auto">CHECK-LIST</h3>
                </a>
            </div>
        </div>
    </div>
    <!-- /main navbar -->
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content">
            <div class="content-inner">
                <form method="POST" action="process-form.php">
                    <?php
                    $posteID = $row["id"];
                    echo "<div style='display:none'>";
                    echo "<input name='matricule[]' placeholder='matricule'><br><input style='border:none' value='" . $row["nom"] . "' name='poste[]'>";
                    echo "<input style='border:none' type='text' name='parameter[]' value='" . $row2["parameter"] . "'>";
                    echo "<input style='border:none' step='0.1' type='number' name='valeur_min[{$posteID}][{$row2["id"]}]' value='" . $row2["valeur_min"] . "'>";
                    echo "<input style='border:none' step='0.1' type='number' name='valeur_max[{$posteID}][{$row2["id"]}]' value='" . $row2["valeur_max"] . "'>";
                    echo "<input type='number' step='0.1' name='valeur[{$posteID}][{$row2["id"]}]'>";
                    echo "<input type='checkbox' name='check_status_ok[{$posteID}][{$row2["id"]}]' value='ok'>OK";
                    echo "<input class='form-check-input' type='checkbox' name='check_status_nok[{$posteID}][{$row2["id"]}]' value='nok'>NOK";
                    echo "</div>";
                    ?>

                    <div class="col-xl-12">
                        <div class="card card-body">
                            <div class="row">
                                <div class="text-center">
                                    <h1>
                                        <b>
                                            <?php echo $_POST["nom_ligne"]; ?>
                                        </b>
                                    </h1>
                                    <input type="hidden" name="nom_ligne" value="<?php echo $_POST["nom_ligne"]; ?>">
                                </div>
                                <div class="col">
                                    <label for="nom" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="nom"
                                        value="<?php echo $_POST["nom"]; ?>" disabled>
                                    <input type="hidden" name="nom_lig" value="<?php echo $_POST["nom"]; ?>">
                                </div>
                                <div class="col">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date"
                                        value="<?php echo $_POST["date"]; ?>" disabled>
                                    <input type="hidden" name="date" value="<?php echo $_POST["date"]; ?>">
                                </div>
                                <div class="col">
                                    <label for="shift" class="form-label">Shift</label>
                                    <input type="text" class="form-control" id="shift"
                                        value="<?php echo $_POST["shift"]; ?>" disabled>
                                    <input type="hidden" name="shift" value="<?php echo $_POST["shift"]; ?>">
                                </div>
                                <div class="col">
                                    <label for="responsable" class="form-label">Responsable</label>
                                    <input type="text" class="form-control" id="responsable"
                                        value="<?php echo $_POST["responsable"]; ?>" disabled>
                                    <input type="hidden" name="responsable"
                                        value="<?php echo $_POST["responsable"]; ?>">
                                </div>
                                <div class="col">
                                    <label for="of" class="form-label">OF</label>
                                    <input type="text" class="form-control" id="of" value="<?php echo $_POST["of"]; ?>"
                                        disabled>
                                    <input type="hidden" name="of" value="<?php echo $_POST["of"]; ?>">
                                </div>
                            </div>
                            <br>
                        </div>
                        <?php
                        // Get postes with matching ligne_id
                        $sql = "SELECT * FROM postes WHERE ligne_id=$ligne_id";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // Output table of postes
                            echo "<table>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Get postes parameters for this poste
                                $poste_id = $row["id"];
                                $sql2 = "SELECT * FROM postes_parameters WHERE poste_id=$poste_id";
                                $result2 = mysqli_query($conn, $sql2);
                                $disabled = "";
                                if (!isset($_POST['matricule']) || empty($_POST['matricule'])) {
                                    $disabled = "disabled";
                                }

                                echo "<tr><td style='display:none'><h4>Poste " . $row["id"] . "</h4></td><td style='border:none'><input class='form-control' style='border:none;font-size:20px;font-weight:bold' value='" . $row['nom'] . "'  name='poste[]' readonly></td></tr>";
                                echo "<tr><td style='border:none'><input style='width 150px;height:50px;border-radius:8px'  type='number' name='matricule[{$poste_id}]' placeholder='&nbsp&nbsp&nbsp&nbsp&nbsp;Matricule ...'></input></td></tr>";
                                if (mysqli_num_rows($result2) > 0) {
                                    // Output table of postes parameters
                                    echo "<tr><td colspan='3'>";
                                    echo "<div class='card card-body'>";
                                    echo "<table><tr><th>Parameter</th><th>Min</th><th>Max</th><th>Valeur</th><th>OK - NOK</th></tr>";
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        echo "<tbody>";
                                        $posteID = $row["id"];
                                        echo "<tr><td><input class='form-control' style='border:none;font-weight:bold' type='text' name='parameter[{$posteID}][]' value='" . $row2["parameter"] . "' readonly></td><td><input style='border:none;width:80px;color:red;font-weight:bold' class='form-control' id='valeur_min' name='valeur_min[{$posteID}][{$row2["id"]}]' value='" . $row2["valeur_min"] . "' readonly></td><td><input id='valeur_max' style='border:none;width:80px;color:green;font-weight:bold' class='form-control'  name='valeur_max[{$posteID}][{$row2["id"]}]' value='" . $row2["valeur_max"] . "' readonly></td><td><input class='form-control' style='width:80px' id='valeur' type='number' step='0.1' name='valeur[{$posteID}][{$row2["id"]}]'></td><td>";
                                        echo "<input id='ok' type='checkbox' name='check_status_ok[{$posteID}][{$row2["id"]}]' onclick='uncheckOther(this);' value='ok'>&nbsp&nbsp&nbsp&nbsp";
                                        echo "<input id='nok' type='checkbox' name='check_status_nok[{$posteID}][{$row2["id"]}]' onclick='uncheckOther(this); toggleHiddenRow(this);' value='nok'>";
                                        echo "</td></tr>";
                                        // Hidden row that will be shown when "nok" checkbox is checked
                                        echo "<tr id='hiddenRow_{$posteID}_{$row2["id"]}' style='background-color: #f8f9fa;display:none;'>";
                                        echo "<td><label class='badge bg-danger' for='additional_input1'>Apres Ajustement:</label></td>";
                                        echo "<td><input placeholder='Commentaire...' type='text' class='form-control' name='apres_ajustement[{$posteID}][{$row2["id"]}]'></td>";
                                        echo "<td><label for='additional_input2'></label></td>";
                                        echo "<td><input id='valeur_max1' style='display:none' class='form-control' name='valeur_max[{$posteID}][{$row2["id"]}]' value='" . $row2["valeur_max"] . "' readonly><input style='display:none' class='form-control' id='valeur_min1' name='valeur_min[{$posteID}][{$row2["id"]}]' value='" . $row2["valeur_min"] . "' readonly><input type='number' id='valeur1' step='0.1' name='AA_valeur[{$posteID}][{$row2["id"]}]' style='width:80px' class='form-control'></td>";
                                        echo "<td>";
                                        echo "<input onclick='uncheckOther1(this);' type='checkbox' id='ok1' name='AA_status_1[{$posteID}][{$row2["id"]}][]' value='OK'>&nbsp&nbsp&nbsp&nbsp";
                                        echo "<input onclick='uncheckOther1(this);' type='checkbox' id='nok1' name='AA_status_2[{$posteID}][{$row2["id"]}][]' value='NOK'>";
                                        echo "</td>";
                                        echo "</tr>";
                                        echo "</tbody>";
                                    }
                                    echo "</table>";
                                    echo "</div>";
                                    echo "</td></tr>";
                                }
                            }
                            echo "</table>";
                            echo "</br><textarea rows='3' cols='3' class='form-control' name='remarque' placeholder='Entrez vos remarques ici ...'></textarea> </br>";
                            echo " <div class='col text-center'><button style='width:150px' type='submit' class='btn btn-success' name='submit_button'> Enregistrer </button></div>";

                            echo "</div>";
                        } else {
                            echo "No postes found for this ligne.";
                        }
                        ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- /main content -->
    </div>
    <!-- /page content -->
</body>

</html>
<?php
include('script.php');
?>
