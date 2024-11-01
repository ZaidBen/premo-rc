<?php
include('../cnx.php');
session_start();
error_reporting(0);

$username = $_SESSION['username'];

$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);
if (!isset($_SESSION['username'])) {
	header("Location: ../admin/admin-login.php");

}
// check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// retrieve the form data
	$id = $_POST["id"];
	$nom = $_POST["nom"];
	$postes = $_POST["postes"];


	// update the ligne with the new nom
	$update_sql = "UPDATE lignes SET nom = '$nom' WHERE id = $id";
	if ($conn->query($update_sql) === TRUE) {
		// update or insert the postes
		foreach ($postes as $poste_id => $poste_nom) {
			if ($poste_nom != '') {
				$poste_nom = $conn->real_escape_string($poste_nom);
				$poste_sql = "SELECT * FROM postes WHERE id = $poste_id AND ligne_id = $id";
				$poste_result = $conn->query($poste_sql);

				if ($poste_result->num_rows > 0) {
					$update_poste_sql = "UPDATE postes SET nom = '$poste_nom' WHERE id = $poste_id AND ligne_id = $id";
					$conn->query($update_poste_sql);
				} else {
					$insert_poste_sql = "INSERT INTO postes (nom, ligne_id) VALUES ('$poste_nom', $id)";
					$conn->query($insert_poste_sql);



				}
			}
		}

		// redirect back to the list of lignes

		header("Location: editli.php?id=" . $id);
		exit();
	}
} else {
	// check if the id parameter is set
	if (isset($_GET["id"])) {
		$ligne_id = $_GET["id"];

		// retrieve the ligne data
		$ligne_sql = "SELECT * FROM lignes WHERE id = $ligne_id";
		$ligne_result = $conn->query($ligne_sql);

		if ($ligne_result->num_rows > 0) {
			$ligne = $ligne_result->fetch_assoc();
		} else {
			echo "No data found.";
			exit();
		}

		// retrieve the postes data
		$postes_sql = "SELECT * FROM postes WHERE ligne_id = $ligne_id ORDER BY id ASC";
		$postes_result = $conn->query($postes_sql);

		if ($postes_result->num_rows > 0) {
			$postes = array();
			while ($poste = $postes_result->fetch_assoc()) {
				$postes[$poste["id"]] = $poste;
			}
		}
	} else {
		echo "Invalid request.";
		exit();
	}
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
							<h5 class="mb-0">Modifier Le code</h5>
						</div>
					</div>
					<div class="card">
						<!-- Grey background -->
						<div class="card-body border-top">
							<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">ID :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $ligne_id; ?>"
											name="id" readonly>
									</div>
								</div>

								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">Code :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $ligne["nom"]; ?>"
											name="nom" >
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">Projet :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $ligne["projet"]; ?>"
											name="projet" readonly>
									</div>
								</div>

								<?php
								// Display existing postes
								if (!empty($postes)) {
									foreach ($postes as $poste) {
										// skip the new poste input field
										if ($poste["id"] == "new") {
											continue;
										}

										echo "<div id='poste_" . $poste["id"] . "' class='row mb-2'>";
										echo "  <label class='col-lg-3 col-form-label' for='poste_" . $poste["id"] . "'>Poste " . $poste["id"] . ":</label>";
										echo "  <div class='col-lg-3'>";
										echo "       <input class='form-control' type='text' name='postes[" . $poste["id"] . "]' value='" . $poste["nom"] . "'><br>";
										echo "    </div>";
										echo "     <div class='col-lg-2'>";
										echo "         <a class='btn btn-danger' style='color:white;'  href='deletepo.php?id=" . $poste['id'] . "&ligne_id=" . $ligne['id'] . "'>Delete</a>";
										echo "          <a class='btn btn-primary' style='color:white;' href='editpo.php?id=" . $poste["id"] . "'>Modifier</a>";
										echo "     </div>";
										echo "  </div>";
									}
								} else {
									echo "No data found.";
								}
								?>
								<br>
								<div class="row mb-2">
									<label class="col-lg-3 col-form-label">Nouveau poste :</label>
									<div class="col-lg-3">
										<input class="form-control" type="text" name="postes[new]"
											placeholder="Entrez le nom du nouveau poste">
									</div>

								</div>
								<div class="text-end">
									<button class="btn btn-primary" type="submit">Enregistrer <i
											class="ph-paper-plane-tilt ms-2"></i></button>
									<a href="ligne.php">Retourner </a>
								</div>
							</form>


						</div>
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