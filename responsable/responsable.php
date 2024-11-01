<?php
include '../cnx.php';
session_start();
error_reporting(0);

$superviseur = $_SESSION['username'];
$sql = "SELECT * FROM administration WHERE username = '$superviseur'";
$result = mysqli_query($conn, $sql);
if (!isset($_SESSION['username'])) {
    header("Location: ../login/admin-login.php");
    exit(); // Add exit() to stop executing further code
}

$sql1 = "SELECT id,username, password, administration FROM responsable WHERE administration = '$superviseur'"; // Add missing single quote at the end
$result1 = $conn->query($sql1);

// Check if a success message is set in the session
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('{$_SESSION['success_message']}');</script>";
    unset($_SESSION['success_message']); // Clear the session variable
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
                            <h5 class="mb-0">Ajouter un nouveau responsable</h5>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <form method="POST" action="addresp.php" style="display: flex; flex-direction: row;">
                                <input class="form-control" type="text" id="username" name="username" required
                                    style="margin-right: 10px;" placeholder="Utilisateur...">
                                <input class="form-control" type="text" id="password" name="password" required
                                    style="margin-right: 10px;" placeholder="Clé d'accés...">
                                    <input class="form-control" type="text" id="admin" name="administration" value="<?php echo $superviseur ?>" required
                                    style="margin-right: 10px;display:none" placeholder="admin">
                                <input class="btn btn-danger" type="submit" value="Ajouter">
                            </form>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <input class="form-control" type="search" name="search" id="zaid"
                                placeholder="Rechercher Ici:">
                        </div>
                    </div></br>
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <table class="table datatable-basic table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom d'tilisateur</th>
                                        <th>Clé d'accés</th>
                                        <th style="display:none">Admin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bennn">
                                    <?php
                                    if ($result1->num_rows > 0) {
                                        while ($row = $result1->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $row["id"] ?>
                                                </td>
                                                <td>
                                                <span class="badge bg-success"><?php echo $row["username"] ?></span>
                                                </td>
                                                <td>
                                                    <?php echo $row["password"] ?>
                                                </td>
                                                <td style="display:none">
                                                    <?php echo $row["administration"] ?>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        onclick="toggleFormVisibility('form_<?php echo $row['id']; ?>')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <span class="button-space"></span>

                                                    <a href="deleteresp.php?id=<?php echo $row['id']; ?>"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer cet responsable?')">
                                                        <i class="fas fa-trash-alt delete-icon"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Edit Form -->
                                            <tr id="form_<?php echo $row['id']; ?>" style="display: none;">
                                                <td colspan="4">
                                                    <form action="editresp.php" method="post"
                                                        style="display: flex; flex-direction: row;">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                        <label style="display: flex; align-items: center; margin-right: 10px"
                                                            for="username_<?php echo $row['id']; ?>">Utilisateur :</label>
                                                        <input style="margin-right: 10px; border-radius: 5px;" type="text"
                                                            name="username" id="username_<?php echo $row['id']; ?>"
                                                            value="<?php echo $row['username']; ?>">

                                                        <label style="display: flex; align-items: center; margin-right: 10px"
                                                            for="password_<?php echo $row['id']; ?>">Clé d'accés :</label>
                                                        <input style="margin-right: 15px; border-radius: 5px;" type="text"
                                                            name="password" id="password_<?php echo $row['id']; ?>"
                                                            value="<?php echo $row['password']; ?>">

                                                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                                                    </form>



                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>

                                <script>
                                    function toggleFormVisibility(formId) {
                                        var form = document.getElementById(formId);
                                        if (form.style.display === "none") {
                                            form.style.display = "table-row";
                                        } else {
                                            form.style.display = "none";
                                        }
                                    }
                                </script>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /grey background -->
    </div>
</body>

</html>
<script>
    $(document).ready(function () {
        $("#zaid").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#bennn tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<style>
    .delete-icon {
        color: red;
    }

    .button-space {
        margin-right: 10px;
        /* Adjust the value to increase or decrease the space */
    }
</style>