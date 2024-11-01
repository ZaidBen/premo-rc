<?php
include('../cnx.php');
session_start();
error_reporting(0);
if (!isset($_SESSION['username'])) {
	header("Location: ../login/admin-login.php");

}
$username = $_SESSION['username'];

$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);
// Check if the form has been submitted
if (isset($_POST['submit'])) {

	// Get the form data
	$poste_id = $_POST['poste_id'];
	$parameters = $_POST['parameter'];
	$parameter_types = $_POST['parameter_type'];
	$valeur_mins = $_POST['valeur_min'];
	$valeur_maxs = $_POST['valeur_max'];

	// Prepare the SQL statement
	$stmt = $conn->prepare("INSERT INTO postes_parameters (poste_id, parameter, parameter_type, valeur_min, valeur_max) VALUES (?, ?, ?, ?, ?)");

	// Bind the parameters
	$stmt->bind_param("sssss", $poste_id, $parameter, $parameter_type, $valeur_min, $valeur_max);

	// Loop through the parameters and insert them into the database
	for ($i = 0; $i < count($parameters); $i++) {
		$parameter = $parameters[$i];
		$parameter_type = $parameter_types[$i];
		$valeur_min = isset($valeur_mins[$i]) ? $valeur_mins[$i] : null;
		$valeur_max = isset($valeur_maxs[$i]) ? $valeur_maxs[$i] : null;

		// Execute the SQL statement
		$stmt->execute();
	}

	// Close the statement and the database connection
	$stmt->close();
	$conn->close();

	// Redirect the user to a confirmation page
	header("Location: ../codes/editpo.php?id=" . $_GET['id']);
	exit();
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
							<h5 class="mb-0">Ajouter un nouveau parametre</h5>
						</div>
					</div>

					<div class="card">
						<div class="card-body border-top">
							<form method="post">
							<input type="hidden" name="poste_id" value="<?php echo $_GET['id']; ?>">

								<div id="parameters">
									<div class="row mb-3 parameter-row">
										<label for="parameter0" class="col-lg-2 col-form-label">Parametre :</label>
										<div class="col-lg-3">
											<input type="text" class="form-control " name="parameter[]" id="parameter0"
												required>
										</div>
										<label class="col-form-label col-lg-2">Type de Parametre :</label>
										<div class="col-lg-2">
											<select class="form-select" name="parameter_type[]" required>
												<option value="ok-nok" selected>OK-NOK</option>
												<option value="valeur">Valeur</option>
											</select>
										</div>
									</div>
									<div id="valeur-inputs" style="display: none;">
										<div class="row mb-3 parameter-row">
											<label for="valeur_min" class="col-lg-2 col-form-label">Valeur Min :</label>
											<div class="col-lg-2">
												<input type="number" step="0.1" class="form-control" name="valeur_min[]"
													id="valeur_min">
											</div>
										</div>
										<div class="row mb-3 parameter-row">
											<label for="valeur_max" class="col-lg-2 col-form-label">Valeur Max :</label>
											<div class="col-lg-2">
												<input type="number" step="0.1" class="form-control" name="valeur_max[]"
													id="valeur_max">
											</div>
										</div>
									</div>
									<div id="ok-nok-inputs" style="display: none;"></div>
								</div>
								<div class="text-end">
									<a href="../codes/editpo.php?id=<?php echo $_GET['id']; ?>">Retourner</a>
									<button class="btn btn-primary" name="submit">Ajouter <i
											class="ph-paper-plane-tilt ms-2"></i></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		const selectElement = document.querySelector('select[name="parameter_type[]"]');
		const valeurInputs = document.getElementById('valeur-inputs');
		const okNokInputs = document.getElementById('ok-nok-inputs');
		selectElement.addEventListener('change', (event) => {
			if (event.target.value === 'valeur') {
				valeurInputs.style.display = 'block';
				okNokInputs.style.display = 'none';
			} else if (event.target.value === 'ok-nok') {
				valeurInputs.style.display = 'none';
				okNokInputs.style.display = 'none';
			}
		});
	</script>

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