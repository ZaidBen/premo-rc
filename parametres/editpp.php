<?php
include '../cnx.php';
session_start();
error_reporting(0);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM postes_parameters WHERE id='$id'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$poste_id = $row['poste_id'];
		$parameter = $row['parameter'];
		$parameter_type = $row['parameter_type'];
		$valeur_min = $row['valeur_min'];
		$valeur_max = $row['valeur_max'];


	}
}

$username = $_SESSION['username'];

$sql3 = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql3);
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
							<h5 class="mb-0">Modifier Le parametre</h5>
						</div>
					</div>

					<div class="card">

						<!-- Grey background -->
						<?php
						if (isset($_POST['edit'])) {
							$id = $_GET['id'];
							$poste_id = $_POST['poste_id'];
							$parameter = $_POST['parameter'];
							$parameter_type = $_POST['parameter_type'];
							$valeur_min = $_POST['valeur_min'];
							$valeur_max = $_POST['valeur_max'];



							$query = "UPDATE postes_parameters set id = '$id', poste_id = '$poste_id', parameter = '$parameter', parameter_type = '$parameter_type' , valeur_min = '$valeur_min', valeur_max = '$valeur_max'  WHERE id='$id'";
							mysqli_query($conn, $query);

							if (mysqli_query($conn, $query)) {
								echo "<script>alert('Parametre Modifier Avec Succes.')</script>";
							} else {
								echo "Erreur: " . $sql . ":-" . mysqli_error($conn);

								mysqli_close($conn);
							}
							header("Location: ../codes/editpo.php?id=" . $_GET['id']);
						}
						?>


						<div class="card-body border-top">
							<form method="POST">
								<div class="row mb-3">
									<label class="col-lg-2 col-form-label">Poste ID :</label>
									<div class="col-lg-2">
										<input type="text" class="form-control" value="<?php echo $poste_id; ?>"
											name="poste_id" readonly>
									</div>
								</div>

								<div class="row mb-3">
									<label class="col-lg-2 col-form-label">Parametre</label>
									<div class="col-lg-4">
										<input type="text" class="form-control" value="<?php echo $parameter; ?>"
											name="parameter">
									</div>
								</div>

								<div class="row mb-3">
									<label class="col-lg-2 col-form-label">Type de parametre :</label>
									<div class="col-lg-2">
										<input type="text" class="form-control" value="<?php echo $parameter_type; ?>"
											name="parameter_type" readonly>
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-lg-2 col-form-label">Valeur Min :</label>
									<div class="col-lg-2">
										<input type="text" class="form-control" value="<?php echo $valeur_min; ?>"
											name="valeur_min">
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-lg-2 col-form-label">Valeur Max :</label>
									<div class="col-lg-2">
										<input type="text" class="form-control" value="<?php echo $valeur_max; ?>"
											name="valeur_max">
									</div>
								</div>

								<div class="text-end">
									<a href="../codes/editpo.php?id=<?php echo $poste_id; ?>">Retourner </a>
									<button class="btn btn-primary" name="edit">Enregistrer <i
											class="ph-paper-plane-tilt ms-2"></i></button>
								</div>

							</form>
						</div>
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
<script>
	function checkTemperature() {
		const temperatureInput = document.getElementById("temperature");
		const temperature = temperatureInput.value;

		if (temperature >= 390 && temperature <= 393) {
			alert("Tempertature dans la zone Jaune !!! Contactez le superviseur");
		} else if (temperature >= 394 && temperature <= 406) {
			// Display a warning message if temperature is too high
			alert("Tempertature dans la zone Jaune");
		} else {
			// Display an error message if temperature is too low
			alert("Tempertature dans la zone Jaune !!!Contactez le superviseur");
		}
	}
</script>

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