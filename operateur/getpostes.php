<?php
include ('../cnx.php');
header('Content-Type: application/json');
$ligne = $_GET['ligne'];
$sql = "SELECT * FROM postes WHERE ligne_id IN (SELECT id FROM lignes WHERE nom = '$ligne')";
$result = $conn->query($sql);
$postes = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $postes[] = $row;
    }
}
echo json_encode($postes);
?>
