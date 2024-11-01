<?php
include '../cnx.php';
session_start();
error_reporting(0);
if (isset($_SESSION['username'])) {
	header("Location: admin.php");
}

if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$mdp = $_POST['mdp'];

	$sql = "SELECT * FROM administration WHERE username='$username' AND mdp='$mdp'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
		$_SESSION['matricule'] = $row['matricule'];

		header("Location: admin.php");
	} else {
		echo "<script>alert('Woops! Utilisateur ou mot de passe incorrect .')</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('../head.php') ?>
</head>

<body>
	<div class="page-content">
		<div class="content-wrapper">
			<div class="content-inner">
				<div class="content d-flex justify-content-center align-items-center">
					<form class="login-form" method="POST">
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="../template/assets/images/premologo.png" class="h-48px" alt="">
									</div>
									<h6 class="mb-0">Se Connecter</h6>
								</div>

								<div class="mb-3">
									<label class="form-label">Utilisateur</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input type="text" name="username" class="form-control"
											placeholder="Utilisateur">
										<div class="form-control-feedback-icon">
											<i class="ph-user-circle text-muted"></i>
										</div>
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label">Mot De Passe</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input type="password" name="mdp" class="form-control"
											placeholder="•••••••••••">
										<div class="form-control-feedback-icon">
											<i class="ph-lock text-muted"></i>
										</div>
									</div>
								</div>

								<div class="mb-3">
									<button name="login" class="btn btn-danger w-100">Se connecter</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<style>
	body {
		background-image: url("../template/assets/images/bg5.jpg");
		background-repeat: no-repeat;
		background-size: cover;


	}

	.login-form {
		background-color: rgba(255, 255, 255, 0.8);
		padding: 20px;
		border-radius: 10px;
	}
</style>