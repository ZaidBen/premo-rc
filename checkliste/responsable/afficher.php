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
    <?php include('../template/navbar.php') ?>
    <!-- /main navbar -->
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content">
            <div class="content-inner">
                <div class="table-container">
                    <div class="filter-bar" style="display: flex; align-items: center;">
                        <select id="shift-filter" class="form-select" style="margin-right: 10px;">
                            <option value="">Select Shift</option>
                            <option value="Matin">Matin</option>
                            <option value="Soir">Soir</option>
                            <option value="Nuit">Nuit</option>
                        </select>
                        <select id="date-filter" class="form-select" style="margin-right: 10px;">
                            <option value="">Select Date Range</option>
                            <option value="1day">1 Day</option>
                            <option value="3days">3 Days</option>
                            <option value="7days">7 Days</option>
                            <option value="month">1 Month</option>
                        </select>
                        <select id="date-filter" class="form-select" style="margin-right: 10px;">
                            <option value="">Select status</option>
                            <option value="ok">OK</option>
                            <option value="nok">NOK</option>
                            
                        </select>
                        <input class="form-control" type="text" id="search-input" placeholder="Search..."
                            style="margin-right: 10px;">
                    </div>
                    <table class="table datatable-responsive">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Shift</th>
                                <th>Projet</th>
                                <th>Ligne</th>
                                <th>Code</th>
                                <th style='display:none'>responsable</th>
                                <th style='display:none'>Id</th>
                                <th style='display:none'>Poste</th>
                                <th style='display:none'>Matricule</th>
                                <th style='display:none'>Status</th>
                                <th style='display:none'>Min</th>
                                <th style='display:none'>Max</th>
                                <th style='display:none'>Valeur</th>
                                <th style='display:none'>Parametre</th>
                                <!-- Add more column headers as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Prepare and execute the SQL query
                            $sql1 = "SELECT id, responsable, shift, datet, nom, matricule, nom_ligne, check_status, valeur_min, valeur_max, valeur, parameter, nom_lig, projetl FROM check_form1 WHERE responsable = '$username' order by id DESC";
                            $result1 = $conn->query($sql1);

                            // Fetch the rows and display them in the table
                            if ($result1->num_rows > 0) {
                                $previousRow = null;
                                $rowspan = 1;
                                while ($row = $result1->fetch_assoc()) {
                                    if (
                                        $previousRow !== null &&
                                        $previousRow['datet'] === $row['datet'] &&
                                        $previousRow['shift'] === $row['shift'] &&
                                        $previousRow['projetl'] === $row['projetl'] &&
                                        $previousRow['nom_lig'] === $row['nom_lig']
                                    ) {
                                       // $rowspan++; // Increment rowspan when the conditions are met
                                        $previousRow = $row;
                                        continue;
                                    }

                                    if ($previousRow !== null) {
                                        echo "<tr onclick=\"window.location='afficher_shift.php?projetl=" . $previousRow['projetl'] . "&datet=" . $previousRow['datet'] . "&shift=" . $previousRow['shift'] . "&nom_lig=" . $previousRow['nom_lig'] . "'\">";
                                        echo "<td rowspan='$rowspan'>" . $previousRow['datet'] . "</td>";
                                        echo "<td rowspan='$rowspan'>" . $previousRow['shift'] . "</td>";
                                        echo "<td>" . $previousRow['projetl'] . "</td>";
                                        echo "<td>" . $previousRow['nom_ligne'] . "</td>";
                                        echo "<td>" . $previousRow['nom_lig'] . "</td>";
                                        echo "</tr>";
                                    }

                                    $previousRow = $row;
                                    $rowspan = 1; // Reset rowspan for the new row
                                }

                                // Print the last row if needed
                                if ($previousRow !== null) {
                                    echo "<tr onclick=\"window.location='afficher_shift.php?projetl=" . $previousRow['projetl'] . "&datet=" . $previousRow['datet'] . "&shift=" . $previousRow['shift'] . "&nom_lig=" . $previousRow['nom_lig'] . "'\">";
                                    echo "<td rowspan='$rowspan'>" . $previousRow['datet'] . "</td>";
                                    echo "<td rowspan='$rowspan'>" . $previousRow['shift'] . "</td>";
                                    echo "<td>" . $previousRow['projetl'] . "</td>";
                                    echo "<td>" . $previousRow['nom_ligne'] . "</td>";
                                    echo "<td>" . $previousRow['nom_lig'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>

                </div>
                </tbody>
                </table>
            </div>
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</body>

</html>

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
</style>
<script>
    // JavaScript code for filtering and searching
    document.addEventListener('DOMContentLoaded', function () {
        var shiftFilter = document.getElementById('shift-filter');
        var dateFilter = document.getElementById('date-filter');
        var searchInput = document.getElementById('search-input');
        var tableRows = document.querySelectorAll('table tbody tr');

        // Event listeners for filter bars
        shiftFilter.addEventListener('change', applyFilters);
        dateFilter.addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);

        // Function to apply filters
        function applyFilters() {
            var selectedShift = shiftFilter.value;
            var selectedDate = dateFilter.value.toLowerCase();
            var searchText = searchInput.value.toLowerCase();

            tableRows.forEach(function (row) {
                var shiftCell = row.querySelector('td:nth-child(2)');
                var dateCell = row.querySelector('td:nth-child(1)');

                var showRow = true;

                // Apply shift filter
                if (selectedShift && shiftCell.textContent !== selectedShift) {
                    showRow = false;
                }

                // Apply date filter
                if (selectedDate && !isDateInRange(dateCell.textContent, selectedDate)) {
                    showRow = false;
                }

                // Apply search filter
                if (searchText && !rowContainsText(row, searchText)) {
                    showRow = false;
                }

                // Show/hide row based on filters
                row.style.display = showRow ? '' : 'none';
            });
        }

        // Function to check if a date is within the specified range
        function isDateInRange(date, range) {
            var currentDate = new Date();
            var checkDate = new Date(date);
            var diffDays = Math.floor((currentDate - checkDate) / (1000 * 60 * 60 * 24));

            switch (range) {
                case '1day':
                    return diffDays === 0;
                case '3days':
                    return diffDays <= 2;
                case '7days':
                    return diffDays <= 6;
                case 'month':
                    return checkDate.getMonth() === currentDate.getMonth() && checkDate.getFullYear() === currentDate.getFullYear();
                default:
                    return true;
            }
        }

        // Function to check if a row contains the specified search text
        function rowContainsText(row, searchText) {
            var cells = row.querySelectorAll('td');

            for (var i = 0; i < cells.length; i++) {
                if (cells[i].textContent.toLowerCase().indexOf(searchText) !== -1) {
                    return true;
                }
            }

            return false;
        }
    });

</script>
<!-- Add CSS styling for the popup form -->