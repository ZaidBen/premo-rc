<?php
include '../cnx.php';
session_start();
error_reporting(0);

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
			<div class="content-inner">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header d-flex align-items-center">
							<h5 class="mb-0">Ajouter un nouveau operateur</h5>
						</div>
					</div>
					<div class="card">
						<div class="card-header d-flex align-items-center">
							<form method="post" action="insert_data.php">
								<table>
									<thead>
										<tr>
											<th>Matricule</th>
											<th>Username</th>
											<th>Responsable</th>
											<th>Code</th>
											<th>Poste</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<tr>
											<td><input class="form-control" type="text" name="matricule[]"
													id="nouveau_projet_input" required>
												<span id="projet2-error" style="color: red; display: none;">Ce projet
													existe
													déjà</span>
											</td>
											<td><input class="form-control" type="text" name="username[]" required></td>
											<td><input class="form-control" type="text" name="responsable[]" required>
											</td>
											<td><select id="select-ligne" name="ligne[]" class="form-select"
													onchange="loadPostes()">
													<?php
													// Get data from database table
													$sql = "SELECT DISTINCT nom FROM lignes";
													$result = $conn->query($sql);

													// Loop through data and create option tags for select dropdown
													if ($result->num_rows > 0) {
														echo '<option value=""></option>';

														while ($row = $result->fetch_assoc()) {
															echo '<option value="' . $row["nom"] . '">' . $row["nom"] . '</option>';
														}
													}
													?>
												</select></td>
											<td> <select id="select-poste" name="poste[]" class="form-select"></select>
											</td>
											<td><button style="display:none" type="button"
													class="btn btn-danger">Supprimer</button></td>
										</tr>
									</tbody>
								</table><br>
								<a style="color:red" href="operateur.php">
									<<< Retourner &nbsp;&nbsp;&nbsp; </a>
										<button type="button" class="btn btn-success" id="add-row">Ajouter un
											poste</button>&nbsp;
										<input type="submit" class="btn btn-primary" value="Enregistrer">

							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
		<script>
			$(document).ready(function () {
				$("#nouveau_projet_input").on("keyup", function () {
					var inputVal = $(this).val();
					$.ajax({
						url: "check_op_matircule.php",
						type: "POST",
						data: { matricule: inputVal },
						success: function (data) {
							if (data === "exists") {
								$("#projet2-error").text("Ce projet existe déjà.");
								$("#projet2-error").show(); // Show the element
								$("#nouveau_projet_input").addClass("is-invalid");
								$("button[type='submit']").attr("disabled", true);
							} else {
								$("#projet2-error").text("");
								$("#projet2-error").hide(); // Hide the element
								$("#nouveau_projet_input").removeClass("is-invalid");
								$("button[type='submit']").attr("disabled", false);
							}
						}
					});
				});
			});


		</script>

		<script>
			// Function to add a new row to the table
			function addRow() {
				var table = document.getElementById("tbody");
				var row = table.insertRow(-1);
				var matricule = row.insertCell(0);
				var username = row.insertCell(1);
				var responsable = row.insertCell(2);
				var ligne = row.insertCell(3);
				var poste = row.insertCell(4);
				var action = row.insertCell(5);
				var rowCount = table.rows.length;
				matricule.innerHTML = '<input style="display:none" type="text" name="matricule[]" value="' + document.getElementsByName("matricule[]")[0].value + '" required>';
				username.innerHTML = '<input style="display:none" type="text" name="username[]" value="' + document.getElementsByName("username[]")[0].value + '" required>';
				responsable.innerHTML = '<input style="display:none"  type="text" name="responsable[]" value="' + document.getElementsByName("responsable[]")[0].value + '" required>';
				ligne.innerHTML = '<td><select id="select-ligne' + rowCount + '" name="ligne[]" class="form-select" onchange="loadPostes1(' + rowCount + ')" required><?php $sql = "SELECT DISTINCT nom FROM lignes";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					echo '<option value=""></option>';
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row["nom"] . '">' . $row["nom"] . '</option>';
					}
				} ?></select ></td > ';
				poste.innerHTML = '<td><select id="select-poste' + rowCount + '" name="poste[]" class="form-select"></select></td>';
				action.innerHTML = '<button type="button" class="btn btn-danger">Supprimer</button>';
				// Add event listener to the remove button
				var removeBtn = action.getElementsByTagName("button")[0];
				removeBtn.addEventListener("click", removeRow);
			}
			function loadPostes1(index) {
				var ligne = document.getElementById("select-ligne" + index).value;
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function () {
					if (xhr.readyState === XMLHttpRequest.DONE) {
						if (xhr.status === 200) {
							var postes = JSON.parse(xhr.responseText);
							var select = document.getElementById("select-poste" + index);
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
			// Function to remove a row from the table
			function removeRow() {
				var row = this.parentNode.parentNode;
				row.parentNode.removeChild(row);
			}

			document.getElementById("add-row").addEventListener("click", addRow);

			// Add event listeners to existing remove buttons
			var removeBtns = document.getElementsByClassName("remove-row");
			for (var i = 0; i < removeBtns.length; i++) {
				removeBtns[i].addEventListener("click", removeRow);
			}
		</script>

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



		<!-- /grey background -->
	
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