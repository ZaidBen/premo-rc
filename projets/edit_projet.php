<?php
include '../cnx.php';
session_start();
error_reporting(0);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM list_projet WHERE id='$id'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$nom_projet = $row['nom_projet'];
	}
}
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
			<div class="col-xl-12">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<h5 class="mb-0">Modifier Le Projet</h5>
					</div>
				</div>

				<div class="card">

					<!-- Grey background -->
					<?php
					if (isset($_POST['edit'])) {
						$id = $_GET['id'];
						$nom_projet = $_POST['nom_projet'];


						$query = "UPDATE list_projet set id = '$id', nom_projet = '$nom_projet' WHERE id='$id'";
						mysqli_query($conn, $query);

						if (mysqli_query($conn, $query)) {
							echo "<script>alert('Projet Modifier Avec Succes.')</script>";
                            echo '<script>window.location.href = "projet.php";</script>';

						} else {
							echo "Erreur: " . $sql . ":-" . mysqli_error($conn);

							mysqli_close($conn);
						}
						header('Location: projet.php');
					}
					?>


					<div class="card-body border-top">
						<form method="POST">
							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Projet ID :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $id; ?>"
										name="id" readonly>
								</div>
							</div>

							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Nom de projet :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $nom_projet; ?>"
										name="nom_projet">
								</div>
							</div>
							
							
						

							<div class="text-end">
								<a href="projet.php">Retourner </a>

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





	<!-- Demo config -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
		<div class="position-absolute top-50 end-100 visible">
			<button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0"
				data-bs-toggle="offcanvas" data-bs-target="#demo_config">
				<i class="ph-gear"></i>
			</button>
		</div>

		<div class="offcanvas-header border-bottom py-0">
			<h5 class="offcanvas-title py-3">Demo configuration</h5>
			<button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
				data-bs-dismiss="offcanvas">
				<i class="ph-x"></i>
			</button>
		</div>

		<div class="offcanvas-body">
			<div class="fw-semibold mb-2">Color mode</div>
			<div class="list-group mb-3">
				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-sun ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Light theme</span>
								<div class="fs-sm text-muted">Set light theme or reset to default</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
							value="light" checked>
					</div>
				</label>

				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-moon ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Dark theme</span>
								<div class="fs-sm text-muted">Switch to dark theme</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
							value="dark">
					</div>
				</label>

				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-translate ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Auto theme</span>
								<div class="fs-sm text-muted">Set theme based on system mode</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
							value="auto">
					</div>
				</label>
			</div>




		</div>


	</div>
	<!-- /demo config -->
	</form>
</body>

</html>