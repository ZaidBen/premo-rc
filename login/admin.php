<?php
include '../cnx.php';
session_start();
error_reporting(0);


if (!isset($_SESSION['username'])) {
	header("Location: admin-login.php");

}
$username = $_SESSION['username'];

$sql = "SELECT * FROM administration WHERE username ='$username'";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM liste_ligne";
if ($result1 = mysqli_query($conn, $sql1)) {
	$rowcount1 = mysqli_num_rows($result1);

}
$sql2 = "SELECT * FROM list_projet";
if ($result2 = mysqli_query($conn, $sql2)) {
	$rowcount2 = mysqli_num_rows($result2);

}
$sql3 = "SELECT * FROM lignes";
if ($result3 = mysqli_query($conn, $sql3)) {
	$rowcount3 = mysqli_num_rows($result3);

}
$sql4 = "SELECT * FROM postes";
if ($result4 = mysqli_query($conn, $sql4)) {
	$rowcount4 = mysqli_num_rows($result4);

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
	<div class="page-content ">
		<?php include('../sidebar.php') ?>

		<!-- Main content -->
		<div class="content">
			<div class="content-inner">
				<!--<div class="col-xl-12">
					<div class="card">
						<div class="card-body pb-0">
							<div class="row">
								<div class="col-sm-3">
									<div class="d-flex align-items-center justify-content-center mb-2">
										<a href="#"
											class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
											<i class="ph-users-three"></i>
										</a>
										<div>
											<div class="fw-semibold">Total des lignes</div>
											<span class="text-muted">
												<?php echo $rowcount1 ?> Lignes
											</span>
										</div>
									</div>
									<div class="w-75 mx-auto mb-3" id="total-online"></div>
								</div>
								<div class="col-sm-3">
									<div class="d-flex align-items-center justify-content-center mb-2">
										<a href="#"
											class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
											<i class="ph-users-three"></i>
										</a>
										<div>
											<div class="fw-semibold">Total des projets</div>
											<span class="text-muted">
												<?php echo $rowcount2 ?> projets
											</span>
										</div>
									</div>
									<div class="w-75 mx-auto mb-3" id="total-online"></div>
								</div>
								<div class="col-sm-3">
									<div class="d-flex align-items-center justify-content-center mb-2">
										<a href="#"
											class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
											<i class="ph-lifebuoy"></i>
										</a>
										<div>
											<div class="fw-semibold">Total des codes</div>
											<span class="text-muted">
												<?php echo $rowcount3 ?> codes
											</span>
										</div>
									</div>
									<div class="w-75 mx-auto mb-3" id="total-online"></div>
								</div>
								<div class="col-sm-3">
									<div class="d-flex align-items-center justify-content-center mb-2">
										<a href="#"
											class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
											<i class="ph-lifebuoy"></i>
										</a>
										<div>
											<div class="fw-semibold">Total des postes</div>
											<span class="text-muted">
												<?php echo $rowcount4 ?> postes
											</span>
										</div>
									</div>
									<div class="w-75 mx-auto mb-3" id="total-online"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				-->
				<!--
==================================================================================================================================================================================
				-->

				<div class="row">
					<div class="col-sm-6 col-xl-3">

						<!-- Area chart in colored card -->
						<div class="card bg-indigo text-white">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h4 class="mb-0">XXXXXXXXXXXXXXX</h4>
									<div class="d-inline-flex ms-auto">
										<a class="text-white" data-card-action="reload">
											<i class="ph-arrow-clockwise"></i>
										</a>
									</div>
								</div>

								<div>
									***********
									<div class="fs-sm opacity-75">xxxxxxxxxxxxxx</div>
								</div>
							</div>

							<div class="rounded-bottom overflow-hidden" id="chart_area_color"></div>
						</div>
						<!-- /area chart in colored card -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Bar chart in colored card -->
						<div class="card bg-danger text-white">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h4 class="mb-0">XXXXXXXXX</h4>
									<span
										class="badge bg-white bg-opacity-75 text-black rounded-pill ms-auto">+53,6%</span>
								</div>

								<div>
									***********
									<div class="fs-sm opacity-75">xxxxxxxxxxxxxx</div>
								</div>
							</div>

							<div class="container-fluid">
								<div id="chart_bar_color"></div>
							</div>
						</div>
						<!-- /bar chart in colored card -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Line chart in colored card -->
						<div class="card bg-primary text-white">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h4 class="mb-0">XXXXXXXXXXXXX</h4>
									<div class="d-inline-flex ms-auto">
										<a class="text-white" data-card-action="reload">
											<i class="ph-arrow-clockwise"></i>
										</a>
									</div>
								</div>

								<div>
									**************
									<div class="fs-sm opacity-75">xxxxxxxxxxxxxxx</div>
								</div>
							</div>

							<div id="line_chart_color"></div>
						</div>
						<!-- /line chart in colored card -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Sparklines in colored card -->
						<div class="card bg-success text-white">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<h4 class="mb-0">49.4%</h4>
									<div class="d-inline-flex dropdown ms-auto">
										<a href="#" class="text-white d-inline-flex align-items-center dropdown-toggle"
											data-bs-toggle="dropdown">
											<i class="ph-gear"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-end">
											<a href="#" class="dropdown-item">
												<i class="ph-arrows-clockwise me-2"></i>
												++++++++
											</a>
											<a href="#" class="dropdown-item">
												<i class="ph-list-dashes me-2"></i>
												++++++++
											</a>
											<a href="#" class="dropdown-item">
												<i class="ph-chart-pie-slice me-2"></i>
												++++++++
											</a>
											<a href="#" class="dropdown-item">
												<i class="ph-x me-2"></i>
												++++++++
											</a>
										</div>
									</div>
								</div>

								<div>
									XXXXXXXXXXXXXXXXX
									<div class="fs-sm opacity-75">34.6% avg</div>
								</div>
							</div>

							<div class="rounded-bottom overflow-hidden" id="sparklines_color"></div>
						</div>
						<!-- /sparklines in colored card -->

					</div>
				</div>

				<div class="row">
						<div class="col-sm-6 col-xl-3">
							<div class="card card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="flex-fill">
										<h6 class="mb-0">Server maintenance</h6>
										<span class="text-muted">Until 1st of June</span>
									</div>

									<i class="ph-gear ph-2x text-indigo opacity-75 ms-3"></i>
								</div>

								<div class="progress mb-2" style="height: 0.125rem;">
									<div class="progress-bar bg-indigo" style="width: 67%"></div>
								</div>

								<div>
					                <span class="float-end">67%</span>
					                Re-indexing
				                </div>
							</div>
						</div>

						<div class="col-sm-6 col-xl-3">
							<div class="card card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="flex-fill">
										<h6 class="mb-0">Services status</h6>
										<span class="text-muted">April, 19th</span>
									</div>

									<i class="ph-activity ph-2x text-danger opacity-75 ms-3"></i>
								</div>

								<div class="progress mb-2" style="height: 0.125rem;">
									<div class="progress-bar bg-danger" style="width: 80%"></div>
								</div>
				                
				                <div>
				                	<span class="float-end">80%</span>
				                	Partly operational
				                </div>
							</div>
						</div>

						<div class="col-sm-6 col-xl-3">
							<div class="card card-body">
								<div class="d-flex align-items-center mb-3">
									<i class="ph-gear ph-2x text-primary opacity-75 me-3"></i>

									<div class="flex-fill">
										<h6 class="mb-0">Server maintenance</h6>
										<span class="text-muted">Until 1st of June</span>
									</div>
								</div>

								<div class="progress mb-2" style="height: 0.125rem;">
									<div class="progress-bar bg-primary" style="width: 67%"></div>
								</div>
				                
				                <div>
				                	<span class="float-end">67%</span>
				                	Re-indexing
				                </div>
							</div>
						</div>

						<div class="col-sm-6 col-xl-3">
							<div class="card card-body">
								<div class="d-flex align-items-center mb-3">
									<i class="ph-activity ph-2x text-success opacity-75 me-3"></i>

									<div class="flex-fill">
										<h6 class="mb-0">Services status</h6>
										<span class="text-muted">April, 19th</span>
									</div>
								</div>

								<div class="progress mb-2" style="height: 0.125rem;">
									<div class="progress-bar bg-success" style="width: 80%"></div>
								</div>
				                
				                <div>
				                	<span class="float-end">80%</span>
				                	Partly operational
				                </div>
							</div>
						</div>
					</div>


				<div class="row">
					<div class="col">
						<div class="card">
							<div class="card-body">
								<div class="chart-container">
									<div class="chart has-fixed-height" id="line_values"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<div class="chart-container">
									<div class="chart has-fixed-height" id="gauge_basic"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<div class="chart-container">
									<div class="chart has-fixed-height" id="pie_timeline"></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="bars_stacked_clustered" style="height: 450px;">
							</div>
						</div>
					</div>
				</div>


			</div>
			<!-- /main content -->
		</div>
	</div>

	<!-- /page content -->
	</form>
</body>

</html>