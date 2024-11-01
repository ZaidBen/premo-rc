<?php
// include database connection code
include "../cnx.php";

// check if the id parameter is set
if (isset($_GET["id"])) {
    $ligne_id = $_GET["id"];

    // check if user confirmed the deletion
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'Yes') {
        // delete the ligne row from lignes table
        $delete_ligne_sql = "DELETE FROM lignes WHERE id = $ligne_id";
        if ($conn->query($delete_ligne_sql) === TRUE) {
            // delete the corresponding postes rows from postes table
            $delete_postes_sql = "DELETE FROM postes WHERE ligne_id = $ligne_id";
            $conn->query($delete_postes_sql);

            // redirect back to the list of lignes
            header("Location: ligne.php");
            exit();
        }
    } elseif (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'No') {
        // redirect back to the list of lignes
        header("Location: ligne.php");
        exit();
    }

    // retrieve the ligne record from the database
    $ligne_sql = "SELECT * FROM lignes WHERE id = $ligne_id";
    $result = $conn->query($ligne_sql);
    if ($result->num_rows > 0) {
        $ligne = $result->fetch_assoc();
    } else {
        echo "Ligne not found.";
        exit();
    }
?>
  <head> <?php include('../head.php') ?></head>

<!-- HTML form to confirm deletion -->
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">

<form method="POST" style="text-align: center;">
    <h3>Voulez-vous supprimer le code ? "<?php echo $ligne['nom']; ?>"?</h3>
    <input class="btn btn-primary" type="submit" name="confirm_delete" value="Yes">
    <input class="btn btn-danger" type="submit" name="confirm_delete" value="No">
</form>
</div>
<?php
} else {
    echo "Invalid request.";
    exit();
}
?>
