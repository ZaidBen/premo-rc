<?php
include '../cnx.php';
session_start();
error_reporting(0);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT * FROM operateur WHERE id='$id'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$username1 = $row['username'];
		$matricule = $row['matricule'];
		$ligne = $row['ligne'];
		$poste = $row['poste'];
		$responsable = $row['responsable'];
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
	<!-- /theme JS files -->
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
						<h5 class="mb-0">Modifier L'operateur</h5>
					</div>
				</div>

				<div class="card">

					<!-- Grey background -->
					<?php
					if (isset($_POST['edit'])) {
						$id = $_GET['id'];
						$username1 = $_POST['username'];
						$responsable = $_POST['responsable'];
						$ligne = $_POST['ligne'];
						$poste = $_POST['poste'];
						$matricule = $_POST['matricule'];


						$query = "UPDATE operateur set id = '$id', username = '$username1', responsable = '$responsable', ligne = '$ligne', poste = '$poste', matricule = '$matricule' WHERE id='$id'";
						mysqli_query($conn, $query);

						if (mysqli_query($conn, $query)) {
							echo "<script>alert('Operateur Modifier Avec Succes.')</script>";
						} else {
							echo "Erreur: " . $sql . ":-" . mysqli_error($conn);

							mysqli_close($conn);
						}
						header('Location: operateur.php');
					}
					?>
					<div class="card-body border-top">
						<form method="POST">
							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Nom :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $username1; ?>"
										name="username">
								</div>
							</div>

							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Matricule :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $matricule; ?>"
										name="matricule">
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Responsable :</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" value="<?php echo $responsable; ?>"
										name="responsable">
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Code :</label>
								<div class="col-lg-9">
									<select id="select-ligne" name="ligne" class="form-select" onchange="loadPostes()">
										<?php
										// Get data from database table
										$sql = "SELECT DISTINCT nom FROM lignes";
										$result = $conn->query($sql);

										// Loop through data and create option tags for select dropdown
										if ($result->num_rows > 0) {
											echo '<option value="' . $row["ligne"] . '"> '.$ligne.'</option>';

											while ($row = $result->fetch_assoc()) {
												echo '<option value="' . $row["nom"] . '">' . $row["nom"] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="row mb-3">
								<label class="col-lg-3 col-form-label">Poste :</label>
								<div class="col-lg-9">
									<select id="select-poste" name="poste" class="form-select"></select>
								</div>
							</div>
							<script>
								function loadPostes() {
									var ligne = document.getElementById("select-ligne").value;
									var xhr = new XMLHttpRequest();
									xhr.onreadystatechange = function () {
										if (xhr.readyState === XMLHttpRequest.DONE) {
											if (xhr.status === 200) {
												var postes = JSON.parse(xhr.responseText);
												var select = document.getElementById("select-poste");
												select.innerHTML = "";
												for (var i = 0; i < postes.length; i++) {
													var poste = postes[i];
													var option = document.createElement("option");
													option.value = poste.nom;
													option.innerHTML = poste.nom;
													select.appendChild(option);
												}
											} else {
												console.error(xhr.statusText);
											}
										}
									};
									xhr.open("GET", "getpostes.php?ligne=" + encodeURIComponent(ligne), true);
									xhr.send();
								}
							</script>

							<!--
								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">Poste :</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $poste; ?>"  name="poste" >
									</div>
								</div>
								<div class="row mb-3">
									<label class="col-lg-3 col-form-label">Ligne:</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" value="<?php echo $ligne; ?>"  name="ligne" >
									</div>
								</div>

			-->

							<div class="text-end">
								<a href="operateur.php">Retourner </a>

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
	<!-- /demo config -->
	</form>
</body>
</html>
