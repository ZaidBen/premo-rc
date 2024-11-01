<?php
include '../cnx.php';
session_start(); // Start the first session
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM responsable WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        // Set the user information in the first session
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];

        // Start a second session for welcome message
        header("Location: responsable/edit.php");
        exit();
    } else {
		echo "<script>alert('Woops! Utilisateur ou mot de passe incorrect .')</script>";
    }
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
                    <h4 class="sidebar-resize-hide flex-grow-1 my-auto">Check-List</h4>
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
                <div class="col-xl-12">
                    <div class="card card-body justify-content-center text-center fs-lg">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button style="height:100px; width:100%; margin-bottom: 10px;" id="show-form-btn"
                                        class="btn btn-success btn-lg" type="submit">
                                        <div>
                                            <i class="fas fa-plus-circle fa-3x"></i>
                                        </div>
                                        <div style="margin-top: 10px;margin-left: 50px;">
                                            <h4>Ajouter</h4>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button style="height:100px; width:100%; margin-bottom: 10px;" id="edit-form-btn"
                                        class="btn btn-primary btn-lg" type="button" onclick="showLoginForm()">
                                        <div>
                                            <i class="fas fa-edit fa-3x"></i>
                                        </div>
                                        <div style="margin-top: 10px;margin-left: 50px;">
                                            <h4>Modifier</h4>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="responsable/afficher.php" style="height:100px; width:100%; margin-bottom: 10px;"
                                        class="btn btn-secondary btn-lg" >
                                        <div>
                                            <i class="fas fa-eye fa-3x"></i>
                                        </div>
                                        <div style="margin-top: 10px;margin-left: 50px;">
                                            <h4>Afficher</h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="responsable/delete_by_shift.php" style="height:100px; width:100%; margin-bottom: 10px;"
                                        class="btn btn-danger btn-lg" >
                                        <div>
                                            <i class="fas fa-trash-alt fa-3x"></i>
                                        </div>
                                        <div style="margin-top: 10px;margin-left: 50px;">
                                            <h4>Supprimer</h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--LOGIN FORM -->
                    <div id="login-form-popup"
                        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
                        <div
                            style="position: relative; top: 50%; transform: translateY(-50%); background-color: white; margin: 0 auto; padding: 20px; width: 300px; border-radius: 5px;">
                            <h2>Authentification</h2>
                            <form method="post">
                                <!-- Login form fields -->
                                <label for="username">Utilisateur:</label>
                                <input class="form-control" type="text" name="username" id="username" required>

                                <label for="password">Clé d'accés:</label>
                                <input class="form-control" type="password" name="password" id="password" required>
                                <br>
                                <div style="text-align: right;">
                                    <button class="btn btn-danger" type="button" onclick="hidePopup()">Annuler</button>
                                    <button name="login" class="btn btn-success" type="submit">Se connecter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/LOGIN FORM -->
                    <div>
                        <div class="card card-body" id="formId" style="display:none;">
                            <form method="POST" action="nouveaux.php">
                                <?php
                                include('../cnx.php');
                                ?>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <span>Ligne :</span>
                                        <select name="nom_ligne" class="form-select" required>
                                            <?php
                                            // Get data from database table
                                            $sql = "SELECT DISTINCT id,nom_ligne FROM liste_ligne";
                                            $result = $conn->query($sql);
                                            // Loop through data and create option tags for select dropdown
                                            if ($result->num_rows > 0) {
                                                echo '<option value="">Sélectionner ...</option>';
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["nom_ligne"] . '">' . $row["nom_ligne"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <span>Code :</span>
                                        <select name="nom" class="form-select" required>
                                            <?php
                                            // Get data from database table
                                            $sql = "SELECT DISTINCT id,nom FROM lignes";
                                            $result = $conn->query($sql);

                                            // Loop through data and create option tags for select dropdown
                                            if ($result->num_rows > 0) {
                                                echo '<option value="">Sélectionner ...</option>';
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["nom"] . '">' . $row["nom"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <span>Date :</span>
                                        <input type="date" class="form-control" aria-label="date" name="date"
                                            value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>

                                    <div class="col-lg-2">
                                        <span>Shift :</span>
                                        <select id="inputState" class="form-select" name="shift" required>
                                            <option value="" selected>Sélectionner ...</option>
                                            <option value="Matin">Matin</option>
                                            <option value="Soir">Soir</option>
                                            <option value="Nuit">Nuit</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <span>Responsable</span>
                                        <input type="text" class="form-control" placeholder="Saisir ..."
                                            name="responsable" required>
                                    </div>
                                    <div class="col-lg-2">
                                        <span>OF :</span>
                                        <input type="number" class="form-control" min="0" placeholder="Saisir ..."
                                            name="of" aria-label="Of"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="7" max="9999999" required>
                                    </div>
                                    <div class="col text-end">
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="submitForm">Entrer</button>
                                    </div>

                                </div>
                                <br>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /main content -->
    </div>
    <!-- /page content -->
</body>

</html>

<script>
    function showLoginForm() {
        document.getElementById("formId").style.display = "none";
        document.getElementById("login-form-popup").style.display = "block";
    }
    function hidePopup() {
        document.getElementById('login-form-popup').style.display = 'none';
    }
    $(document).ready(function () {
        $('#show-form-btn').click(function () {
            $('#formId').toggle();
        });
    });
</script>