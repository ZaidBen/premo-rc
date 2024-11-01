<?php
// include database connection code
include "../cnx.php";

// start session
session_start();

// check if the id parameter is set
if(isset($_GET['id'])) {
  $operateur_id = $_GET['id'];

  // check if user confirmed the deletion
  if(isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'Yes') {
    // delete the operateur row from operateur table
    $delete_operateur_sql = "DELETE FROM operateur WHERE id = $operateur_id";
    if($conn->query($delete_operateur_sql) === TRUE) {
      // set session message for successful deletion
      $_SESSION['message'] = 'Opérateur supprimé avec succès';
      $_SESSION['message_type'] = 'danger';
      // redirect back to the list of opérateurs
      header('Location: operateur.php');
      exit();
    } else {
      die("Query Failed.");
    }
  } elseif(isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'No') {
    // redirect back to the list of opérateurs
    header('Location: operateur.php');
    exit();
  }

  // retrieve the operateur record from the database
  $operateur_sql = "SELECT * FROM operateur WHERE id = $operateur_id";
  $result = $conn->query($operateur_sql);
  if($result->num_rows > 0) {
    $operateur = $result->fetch_assoc();
  } else {
    echo "Opérateur not found.";
    exit();
  }
?>
<head>
  <?php include('../head.php') ?>
</head>

<!-- HTML form to confirm deletion -->
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <form method="POST" style="text-align: center;">
    <h3>Voulez-vous supprimer l'opérateur : "<?php echo $operateur['username']; ?>" ?</h3>
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
