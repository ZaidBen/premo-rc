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


$sql1 = "SELECT id,username,matricule,ligne,poste,responsable FROM operateur";
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
		<div class="content">
			<div class="content-inner">
				<div class="btn-column">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header d-flex align-items-center">
								<h5 class="mb-0">Listes Des Operateurs</h5>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<select class="form-select" id="filter">
									<option value="">-- Filtrer avec --</option>
									<option value="nom">Nom</option>
									<option value="matricule">Matricule</option>
									<option value="responsable">Responsable</option>
									<option value="ligne">Code</option>
									<option value="poste">Poste</option>
								</select>
							</div>
							<div class="col">
								<input class="form-control" type="search" name="search" id="search"
									placeholder="Rechercher Ici:">
							</div>
							<div class="col">
								<a type="button" href="addop.php" class="btn btn-outline-danger">Ajouter Un Nouveau</a>
								<button onclick="window.print()" class="btn btn-danger" id="print-button"><i
										class="fa fa-print fa-2x"></i></button>

							</div>
						</div>
					</div>
				</div><br>
				<div class="card">
					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Matricule</th>
								<th>Responsable</th>
								<th>Code</th>
								<th>Poste</th>
								<th class="btn-column">Action</th>
							</tr>
						</thead>
						<tbody id="table-body">
							<?php
							if ($result1->num_rows > 0) {
								while ($row = $result1->fetch_assoc()) {
									?>
									<tr>
										<td>
											<span class="badge bg-success">
												<?php echo $row["username"] ?>
											</span>
										</td>
										<td>
											<?php echo $row["matricule"] ?>
										</td>
										<td>
											<?php echo $row["responsable"] ?>
										</td>
										<td>
											<?php echo $row["ligne"] ?>
										</td>
										<td>
											<?php echo $row["poste"] ?>
										</td>
										<td class="btn-column">
											<a href='editop.php?id=<?php echo $row['id'] ?>'><i class="fas fa-edit"></i></a>
											<span class="button-space"></span>
											<a href='deleteop.php?id=<?php echo $row['id'] ?>'><i
													class="fas fa-trash-alt delete-icon"></i></a>
										</td>
									</tr>
									<?php
								}
							}
							?>
						</tbody>
					</table>
					<?php include('script.php') ?>
				</div>

			</div>


			<!-- /main content -->
		</div>
	</div>
	<!-- /page content -->
	</form>
</body>

</html>
<style>
	.delete-icon {
		color: red;
	}

	.button-space {
		margin-right: 10px;
		/* Adjust the value to increase or decrease the space */
	}
</style>