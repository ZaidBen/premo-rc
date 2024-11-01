<?php
include '../cnx.php';
session_start();
error_reporting(0);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM postes WHERE id='$id' ";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$nom = $row['nom'];
		$ligne_id = $row['ligne_id'];
	}

}
// id,poste_id,parameter,parameter_type,valeur_min,valeur_max FROM postes_parameters 


$sql1 = "SELECT * FROM postes_parameters where poste_id ='$id' ORDER BY id ASC";
$result1 = $conn->query($sql1);
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
							<h5 class="mb-0">Modifier Le poste</h5>
						</div>
					</div>
					<div class="card">
						<!-- Grey background -->
						<?php
						if (isset($_POST['edit'])) {
							$id = $_GET['id'];
							$nom = $_POST['nom'];
							$ligne_id = $_POST['ligne_id'];
							$query = "UPDATE postes set id = '$id', nom = '$nom', ligne_id = '$ligne_id' WHERE id='$id'";
							mysqli_query($conn, $query);
							if (mysqli_query($conn, $query)) {
								echo "<script>alert('Poste Modifier Avec Succes.')</script>";
							} else {
								echo "Erreur: " . $sql . ":-" . mysqli_error($conn);

								mysqli_close($conn);
							}
							header('Location: ligne.php');
						}
						?>
						<div class="card-body border-top">
							<form method="POST">
								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">Poste ID :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $id; ?>" name="id" readonly>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">Nom de Poste :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $nom; ?>" name="nom">
									</div>
								</div>
								<div class="row mb-3 d-none">
									<label class="col-lg-3 col-form-label">Ligne ID :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $ligne_id; ?>"
											name="ligne_id">
									</div>
								</div>
								<div class="text-end">
									<a href="editli.php?id=<?php echo $ligne_id; ?>">Retourner </a>
									<button class="btn btn-primary" name="edit">Enregistrer <i
											class="ph-paper-plane-tilt ms-2"></i></button>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3">
							<input class="form-control" type="search" name="search" id="zaid"
								placeholder="Rechercher Ici:"> <br>
						</div>
						<div class="col-lg-4">
							<a href="../parametres/addpp.php?id=<?php echo $id; ?>" class="btn btn-outline-danger">Nouveau
								Parametre</a>
						</div>
					</div>
					<div class="card">

						<table class="table datatable-basic table-hover">
							<thead>
								<tr>
									<th>Parametres</th>
									<th>Type de parametre</th>
									<th>Valeur Min</th>
									<th>Valeur Max </th>
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
												<?php echo $row["parameter"] ?>
											</td>
											<td>
												<?php echo $row["parameter_type"] ?>
											</td>
											<td>
												<?php echo $row["valeur_min"] ?>
											</td>
											<td>
												<?php echo $row["valeur_max"] ?>
											</td>


											<td>
												<a href='../parametres/editpp.php?id=<?php echo $row['id'] ?>'><i class="fas fa-edit"></i></a>
												<span class="button-space"></span>
												<a href='../parametres/deletepp.php?id=<?php echo $row['id'] ?>&poste_id=<?php echo $row['poste_id'] ?>'><i
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
				<!-- /grey background -->

			</div>
		</div>

	</div>
	</div>
	<!-- /main content -->
	</div>
	<!-- /page content -->

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