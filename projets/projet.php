<?php
include '../cnx.php';
session_start();
error_reporting(0);

$username = $_SESSION['username'];
$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);
if (!isset($_SESSION['username'])) {
	header("Location: ../login/admin-login.php");
}

$sql1 = "SELECT id,nom_projet FROM list_projet";
$result1 = $conn->query($sql1);
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
        <div class="content ">
            <div class="content-inner">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="mb-0">Ajouter un nouveau projet</h5>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <form method="POST" action="add_projet.php">
                                <label for="nom_projet">Nom de Projet:</label>
                                <input type="text" id="nom_projet" name="nom_projet" required>
                                <input class="btn btn-danger" type="submit" value="Ajouter ">
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
                                        <th>Nom de Projet</th>
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
                                                <span class="badge bg-yellow text-black">  <?php echo $row["nom_projet"] ?></span>
                                                </td>
                                                <td>
                                                    <a href='edit_projet.php?id=<?php echo $row['id'] ?>'><i
                                                            class="fas fa-edit"></i></a>
                                                    <span class="button-space"></span>

                                                    <a href='delete_projet.php?id=<?php echo $row['id'] ?>'><i
                                                            class="fas fa-trash-alt delete-icon"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /grey background -->
    </div>
    </form>
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