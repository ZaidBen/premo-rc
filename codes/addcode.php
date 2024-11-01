<!-- insert.php -->
<?php
include('../cnx.php');
session_start();
error_reporting(0);
$username = $_SESSION['username'];

$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);
if (!isset($_SESSION['username'])) {
    header("Location: ../login/admin-login.php");

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<?php include('../head.php') ?>
</head>

<body>
    <!-- Main navbar -->
	<?php include('../navbar.php') ?>
    <!-- /main navbar -->
    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
	<?php include('../sidebar.php') ?>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content">
            <div class="content-inner">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="mb-0">Ajouter un nouveau code</h5>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body border-top" id="parameter-group">
                            <form action="addcode1.php" method="POST">
                                <label for="code" class="col-lg-3 col-form-label">Code :</label>
                                <input style="width:500px" type="text" id="code" name="nom_ligne" class="form-control"
                                    onkeyup="checkLigne(this.value);this.value = this.value.toUpperCase()" required>
                                    <span id="code-error" style="color: red; display: none;">Ce projet existe
                                        déjà</span></br>
                                  
                                <label for="projet" class="col-lg-3 col-form-label">Projet :</label>
                                <select style="width:500px" id="projet" class="form-select" name="projet" required>
                                    <option value="" disabled selected>Choisissez une option</option>
                                    <option value="projet_existant">Projet Existant</option>
                                    <option value="nouveau_projet">Nouveau Projet</option>
                                </select><br>

                                <div id="projet_existant_fields" style="display:none;">
                                    <label for="projet_select" class="col-lg-3 col-form-label">Projet Existant :</label>
                                    <select style="width:500px" id="projet_select" name="projet1" class="form-select">
                                        <?php
                                        // Get data from database table
                                        $sql = "SELECT  id,nom_projet FROM list_projet";
                                        $result = $conn->query($sql);

                                        // Loop through data and create option tags for select dropdown
                                        if ($result->num_rows > 0) {
                                            echo '<option value="">Selectioner ...</option>';
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row["nom_projet"] . '">' . $row["nom_projet"] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div id="nouveau_projet_fields" style="display:none;">
                                    <label for="nouveau_projet_input" class="col-lg-3 col-form-label">Nouveau Projet
                                        :</label>
                                    <input style="width:500px" type="text" id="nouveau_projet_input" name="projet2"
                                        class="form-control" onkeyup="this.value = this.value.toUpperCase();">
                                        
                                    <span id="projet2-error" style="color: red; display: none;">Ce projet existe
                                        déjà</span>
                                </div>



                                <div id="postes">
                                    <label for="nom_poste" class="col-lg-3 col-form-label">Nom de Poste :</label>
                                    <input style="width:500px" type="text" id="nom_poste" name="nom_poste[]"
                                        class="form-control" required><br>
                                </div>

                                <button  class="btn btn-success" type="button" onclick="addPoste()">Poste de
                                    plus</button>
                                <button id="ajouter-btn" class="btn btn-primary" type="submit" value="ajouter">ajouter</button>


                            </form>

                            <script>

                                const projetSelect = document.getElementById('projet');
                                const projetExistantFields = document.getElementById('projet_existant_fields');
                                const nouveauProjetFields = document.getElementById('nouveau_projet_fields');

                                projetSelect.addEventListener('change', function () {
                                    if (this.value === 'projet_existant') {
                                        projetExistantFields.style.display = 'block';
                                        nouveauProjetFields.style.display = 'none';
                                    } else if (this.value === 'nouveau_projet') {
                                        projetExistantFields.style.display = 'none';
                                        nouveauProjetFields.style.display = 'block';
                                    } else {
                                        projetExistantFields.style.display = 'none';
                                        nouveauProjetFields.style.display = 'none';
                                    }
                                });

                                function addPoste() {
                                    var div = document.createElement('div');
                                    div.innerHTML = '<div style="display: flex;"><input placeholder="Saisir le nouveau poste" style="width: 500px; margin-right: 10px;" class="form-control" type="text" id="nom_poste" name="nom_poste[]" required><button class="btn btn-danger" onclick="deletePoste(this)"><i class="fas fa-trash-alt delete-icon"></i></button></div><br>';
                                    document.getElementById('postes').appendChild(div);
                                }


                                function deletePoste(button) {
                                    var row = button.parentNode;
                                    row.parentNode.removeChild(row);
                                }

                                $(document).ready(function () {
                                    $("#nouveau_projet_input").on("keyup", function () {
                                        var inputVal = $(this).val();
                                        $.ajax({
                                            url: "check_projet.php",
                                            type: "POST",
                                            data: { projet2: inputVal },
                                            success: function (data) {
                                                if (data === "exists") {
                                                    $("#projet2-error").text("Ce projet existe déjà.");
                                                    $("#projet2-error").show(); // Show the element
                                                    $("#nouveau_projet_input").addClass("is-invalid");
                                                    $("button[type='submit']").attr("disabled", true);
                                                } else {
                                                    $("#projet2-error").text("");
                                                    $("#projet2-error").hide(); // Hide the element
                                                    $("#nouveau_projet_input").removeClass("is-invalid");
                                                    $("button[type='submit']").attr("disabled", false);
                                                }
                                            }
                                        });
                                    });
                                });


                                function checkLigne(value) {
                                    $.ajax({
                                        url: 'check_ligne.php',
                                        method: 'POST',
                                        data: {
                                            nom_ligne: value
                                        },
                                        success: function (result) {
                                            if (result === 'exists') {
                                                $("#code-error").text("Ce code existe déjà.");
                                                $("#code-error").show(); // Show the element
                                                $('#code').addClass('is-invalid');
                                                $('#code-feedback').html('This value already exists.');
                                                $('#ajouter-btn').attr('disabled', true);
                                            } else {
                                                $("#code-error").text("");
                                                $("#code-error").hide(); // Hide the element
                                                $('#code').removeClass('is-invalid');
                                                $('#code-feedback').html('');
                                                $('#ajouter-btn').removeAttr('disabled');
                                            }
                                        }
                                    });
                                }



                            </script>

                        </div>
                    </div>

                </div>




                <!-- /grey background -->
            </div>
        </div>
    </div>
    <!-- /main content -->
    </div>
    </div>
    <!-- /page content -->
    </form>
</body>

</html>