<?php
include '../cnx.php';
session_start();
error_reporting(0);


if (!isset($_SESSION['username'])) {
	header("Location: ../login/admin-login.php");

}
$username = $_SESSION['username'];

$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT id,nom,ligne_id FROM postes";
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
		<?php include('../sidebar.php') ?>
		<!-- /main sidebar -->
		<!-- Main content -->
		<div class="content">
			<div class="content-inner">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header d-flex align-items-center">
							<h5 class="mb-0">Listes Des Postes</h5>
						</div>

					</div>
					<div class="row">
						<div class="col">
							<input class="form-control" type="search" name="search" id="zaid"
								placeholder="Rechercher Ici:">
						</div>
						<div class="col">
						</div>
						<div class="col">
						</div>	
						<!--
						<div class="col-lg-4">
							<a type="button" href="addpo.php" class="btn btn-outline-primary">Ajouter Un Nouveau</a>
						</div>
					-->
					</div>

				</div> <br>
				<div class="card">

					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nom</th>
								<th>Ligne ID</th>
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
										<span class="badge bg-warning"><?php echo $row["nom"] ?></span>
										</td>
										<td>
											<?php echo $row["ligne_id"] ?>
										</td>

										<td>
											<a href='editpo1.php?id=<?php echo $row['id'] ?>'>Afficher</a>
											<!--	<a href='deletepo.php?id=<?php echo $row['id'] ?>'>Supprimer</a>-->
										</td>
									</tr>
									<?php
								}
							}
							?>

						</tbody>
					</table>
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

	const submitButton = document.getElementsByName("submit")[0];
	submitButton.addEventListener("click", checkTemperature);
</script>