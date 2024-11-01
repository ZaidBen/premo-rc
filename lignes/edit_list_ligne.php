<?php
include '../cnx.php';
session_start();
error_reporting(0);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM liste_ligne WHERE id='$id'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$nom_ligne = $row['nom_ligne'];
	}
}
$username = $_SESSION['username'];
$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);
if (!isset($_SESSION['username'])) {
	header("Location: ../admin-login.php");
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
			<div class="col-xl-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<h5 class="mb-0">Modifier La Ligne</h5>
					</div>
				</div>
				<div class="card">
					<!-- Grey background -->
					<?php
					if (isset($_POST['edit'])) {
						$id = $_GET['id'];
						$nom_ligne = $_POST['nom_ligne'];


						$query = "UPDATE liste_ligne set id = '$id', nom_ligne = '$nom_ligne' WHERE id='$id'";
						mysqli_query($conn, $query);

						if (mysqli_query($conn, $query)) {
							echo "<script>alert('Ligne Modifier Avec Succes.')</script>";
							echo '<script>window.location.href = "list_ligne.php";</script>';

						} else {
							echo "Erreur: " . $sql . ":-" . mysqli_error($conn);

							mysqli_close($conn);
						}
						header('Location: list_ligne.php');
					}
					?>


					<div class="card-body border-top">
						<form method="POST">
							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Ligne ID :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $id; ?>" name="id"
										readonly>
								</div>
							</div>

							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Nom de ligne :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $nom_ligne; ?>"
										name="nom_ligne">
								</div>
							</div>
							<div class="text-end">
								<a href="list_ligne.php">Retourner </a>

								<button class="btn btn-primary" name="edit">Enregistrer <i
										class="ph-paper-plane-tilt ms-2"></i></button>

							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /grey background -->
		</div>
	</div>
	</div>

	<!-- /main content -->
	</div>
	<!-- /page content -->
	</form>
</body>

</html>