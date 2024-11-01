<?php
// include database connection code
include "../cnx.php";

// check if the id parameter is set
if (isset($_GET['id'])) {
    $projet_id = $_GET['id'];

    // check if user confirmed the deletion
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'Yes') {
        // delete the projet row from list_projet table
        $delete_projet_sql = "DELETE FROM list_projet WHERE id = '$projet_id'";
        if ($conn->query($delete_projet_sql) === TRUE) {
            // set session message for successful deletion
            $_SESSION['message'] = 'Projet supprimé avec succès';
            $_SESSION['message_type'] = 'success';
            // redirect back to the list of projets
            header('Location: projet.php');
            exit();
        } else {
            die("Query Failed.");
        }
    } elseif (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'No') {
        // redirect back to the list of projets
        header('Location: projet.php');
        exit();
    }

    // retrieve the projet record from the database
    $projet_sql = "SELECT * FROM list_projet WHERE id = '$projet_id'";
    $result = $conn->query($projet_sql);
    if ($result->num_rows > 0) {
        $projet = $result->fetch_assoc();
    } else {
        echo "Projet not found.";
        exit();
    }
?>
<head>
    <?php include('../head.php') ?>
</head>

<!-- HTML form to confirm deletion -->
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <form method="POST" style="text-align: center;">
        <h3>Voulez-vous supprimer le projet avec l'ID "<?php echo $projet['nom_projet']; ?>" ?</h3>
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
