<?php
include('../../cnx.php');
session_start();
error_reporting(0);
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Redirect to index.php if the user is not logged in
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <?php
    include('../template/head.php');
    ?>
</head>

<body>
    <!-- Main navbar -->
    <div class="nav11">
        <?php include('../template/navbar.php') ?>
    </div>
    <!-- /main navbar -->
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content">
            <div class="content-inner">
                <button class="fixed-button" onclick="printTable()">
                    <i class="fas fa-print"></i> <!-- Font Awesome print icon -->
                </button>
                <?php
                // Retrieve the values from the URL query parameters
                $projetl = $_GET['projetl'];
                $datet = $_GET['datet'];
                $shift = $_GET['shift'];
                $nom_lig = $_GET['nom_lig'];

                // Prepare and execute the SQL query
                $sql = "SELECT *, matricule, check_status, projetl, datet, shift, nom, remarque, apres_ajustement, AA_valeur, AA_status FROM check_form1 WHERE projetl='$projetl' AND datet='$datet' AND shift='$shift' ORDER BY id ASC ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc(); // Fetch the row from the query result
                    $remarque = $row['remarque']; // Assign 'remarque' value to a variable

                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    echo "<input class='form-control'  value='$datet' disabled>";
                    echo "</div>";
                    echo "<div class='col'>";
                    echo "<input class='form-control'  value='$shift' disabled>";
                    echo "</div>";
                    echo "<div class='col'>";
                    echo "<input class='form-control'  value='$projetl' disabled>";
                    echo "</div>";
                    echo "<div class='col'>";
                    echo "<input class='form-control'  value='$nom_lig' disabled>";
                    echo "</div>";
                    echo "</div>";
                    echo "</br>";
                    echo "<H4 style='color:red'>&nbsp&nbsp&nbsp&nbspRemarque !!!</H4>";
                    echo "<textarea ' class='form-control' style='width: 500px; height: 70px;' disabled>" . $row['remarque'] . "</textarea>";
                    echo "</br>";
                } else {
                    echo "No results found.";
                }

                // Display the matching rows in a table
                if ($result->num_rows > 0) {
                    echo "<table id='print-table'>";
                    echo "<tr>";
                    echo "<th style='display:none'>ID</th>";
                    //  echo "<th>Responsable</th>";
                    // echo "<th>Date</th>";
                    //  echo "<th>Shift</th>";
                    echo "<th>Poste</th>";
                    echo "<th>Matricule</th>";
                    echo "<th>Parametre</th>";
                    //  echo "<th>Nom Ligne</th>";
                    //  echo "<th>Nom Lig</th>";
                    echo "<th> Status</th>";
                    echo "<th> Min</th>";
                    echo "<th> Max</th>";
                    echo "<th>Valeur</th>";
                    echo "</tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='display:none'>" . $row['id'] . "</td>";
                        //  echo "<td>" . $row['responsable'] . "</td>";
                        //echo "<td>" . $row['datet'] . "</td>";
                        // echo "<td>" . $row['shift'] . "</td>";
                        echo "<td style='font-size:20px'>" . $row['nom'] . "</td>";
                        echo "<td><span class='badge bg-primary'>" . $row['matricule'] . "</span></td>";
                        echo "<td>" . $row['parameter'] . "</td>";
                        // echo "<td>" . $row['nom_ligne'] . "</td>";
                        // echo "<td>" . $row['nom_lig'] . "</td>";
                
                        if ($row['check_status'] == 'OK') {
                            echo "<td><span class='badge bg-success'>" . $row['check_status'] . "</span></td>";
                        } elseif ($row['check_status'] == 'NOK') {
                            echo "<td><span class='badge bg-danger'>" . $row['check_status'] . "</span></td>";
                        } else {
                            // Handle other cases or display a default badge
                            echo "<td><span class='badge'>" . $row['check_status'] . "</span></td>";
                        }
                        echo "<td>" . $row['valeur_min'] . "</td>";
                        echo "<td>" . $row['valeur_max'] . "</td>";
                        echo "<td><span>" . $row['valeur'] . "</span></td>";
                        echo "</tr>";
                        echo "<tr style='background-color: #e3d3d5;'>";
                        echo "<td><span class='badge bg-danger'>Apres Ajustement</span></td>";
                        echo "<td ><span style='font-size:18px:background-color:#c9abaf'></span></td>";
                        echo "<td><span>" . $row['apres_ajustement'] . "</span></td>";
                        echo "<td><span>" . $row['AA_status'] . "</span></td>";
                        echo "<td ><span style='font-size:18px:background-color:#c9abaf'></span></td>";
                        echo "<td ><span style='font-size:18px:background-color:#c9abaf'></span></td>";
                        echo "<td><span>" . $row['AA_valeur'] . "</span></td>";
                        echo "</tr>";


                    }
                    echo "</table>";

                } else {
                    echo "No matching rows found.";
                }
                ?>
            </div>
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</body>

</html>

<script>
    function printTable() {
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><style>@media print {table { border-collapse: collapse; width: 100%; }th, td {border: 2px solid black;padding: 8px;}th {background-color: #f2f2f2;}}');
        printWindow.document.write('input[type="text"] { height: 40px; }');
        printWindow.document.write('</style><title>Print Table</title></head><body>');
        printWindow.document.write('<h1 style="text-align: center;">CHECK LIST</h1>');
        printWindow.document.write('<div style="display: flex; justify-content: center;">');
        printWindow.document.write('<input style="width: 100px; margin-right: 10px; border: none; text-align: center; font-weight: bold;" disabled>');
        printWindow.document.write('<input style="width: 200px; margin-right: 10px; height: 30px; text-align: center; font-weight: bold;" value="Date : ' + <?php echo json_encode($datet); ?> + '" disabled>');
        printWindow.document.write('<input style="width: 200px; margin-right: 10px; height: 30px; text-align: center; font-weight: bold;" value="Shift : ' + <?php echo json_encode($shift); ?> + '" disabled>');
        printWindow.document.write('<input style="width: 200px; margin-right: 10px; height: 30px; text-align: center; font-weight: bold;" value="Project : ' + <?php echo json_encode($projetl); ?> + '" disabled>');
        printWindow.document.write('<input style="width: 200px; height: 30px; text-align: center; font-weight: bold;" value="Code : ' + <?php echo json_encode($nom_lig); ?> + '" disabled>');
        printWindow.document.write('<input style="width: 100px; margin-right: 10px; border: none; text-align: center; font-weight: bold;" disabled>');
        printWindow.document.write('</div><br>');
        printWindow.document.write('<div style="display: flex; justify-content: center;">');
        printWindow.document.write('<textarea class="form-control" disabled style="width: 500px; height: 70px;">REMARQUE :' + <?php echo json_encode($remarque); ?> + '</textarea>');
        printWindow.document.write('</div><br>');
        printWindow.document.write(document.getElementById('print-table').outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>

<style>
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #f5f5f5;
        font-weight: bold;
        font-size: 18px;
    }

    tr:not(:last-child) {
        border-bottom: 5px solid black;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    .fixed-button {
        display: none;
        position: fixed;
        right: 20px;
        bottom: 50%;
        background-color: red;
        color: white;
        padding: 15px 30px;
        border-radius: 5px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    @media (min-width: 768px) {

        /* Show the print button on screens smaller than 768px */
        .fixed-button {
            display: block;
        }
    }
</style>