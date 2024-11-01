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


$sql1 = "SELECT id,nom,postes FROM lignes";
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
							<h5 class="mb-0">Listes Des Codes</h5>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<input class="form-control" type="search" name="search" id="zaid"
								placeholder="Rechercher Ici:">
						</div>
						<div class="col">
							<a type="button" href="addcode.php" class="btn btn-outline-danger">Ajouter Un Nouveau
								Code</a>
						</div>
					</div>
				</div> <br>


				<div class="card">

					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Code</th>
								<th>Projet</th>
								<th>Postes</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="bennn">
							<?php

							// retrieve data from lignes table
							$lignes_sql = "SELECT id, nom, projet FROM lignes ORDER BY id ASC";
							$lignes_result = $conn->query($lignes_sql);

							// loop through each ligne and retrieve corresponding postes
							if ($lignes_result->num_rows > 0) {
								while ($ligne = $lignes_result->fetch_assoc()) {
									$postes_sql = "SELECT nom FROM postes WHERE ligne_id = " . $ligne["id"];
									$postes_result = $conn->query($postes_sql);

									// generate HTML table row for each ligne and its corresponding postes
									echo "<tr>";
									echo "<td>" . $ligne["id"] . "</td>";
									echo "<td><span class='badge bg-yellow text-black'>" . $ligne["nom"] . "</span></td>";
									echo "<td>" . $ligne["projet"] . "</td>";
									echo "<td>";
									if ($postes_result->num_rows > 0) {
										while ($poste = $postes_result->fetch_assoc()) {
											echo $poste["nom"] . ",";
										}
									}
									echo "</td>";
									echo " <td>
               <a href='editli.php?id=" . $ligne["id"] . "' ><i class='fas fa-edit'></i></a>
			   <span class='button-space'></span>

			   <a href='deleteli.php?id=" . $ligne["id"] . "' ><i
			   class='fas fa-trash-alt delete-icon'></i></a>


                </td>";

									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='3'>No data found.</td></tr>";
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
			<!-- /main content -->
		</div>
	</div>
	<!-- /page content -->
	<!-- /demo config -->
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
</script><style>
	.delete-icon {
		color: red;
	}

	.button-space {
		margin-right: 10px;
		/* Adjust the value to increase or decrease the space */
	}
</style>