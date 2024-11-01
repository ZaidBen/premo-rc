<?php
include("../cnx.php");

if(isset($_GET['id']) && isset($_GET['ligne_id'])) {
  $id = $_GET['id'];
  $ligne_id = $_GET['ligne_id']; // get the value of the $ligne_id parameter from the URL

  // check if user confirmed the deletion
  if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'Yes') {
    $query = "DELETE FROM postes WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if(!$result) {
      die("Query Failed.");
    }

    $_SESSION['message'] = 'Poste supprimé avec succès';
    $_SESSION['message_type'] = 'danger';
    header("Location: editli.php?id=".$ligne_id); // redirect to editli.php with the same $ligne_id
    exit();
  } elseif (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'No') {
    // redirect to editli.php with the same $ligne_id
    header("Location: editli.php?id=".$ligne_id);
    exit();
  }

  // retrieve the poste record from the database
  $poste_sql = "SELECT * FROM postes WHERE id = $id";
  $result = $conn->query($poste_sql);
  if ($result->num_rows > 0) {
    $poste = $result->fetch_assoc();
  } else {
    echo "Poste not found.";
    exit();
  }
?>
    <head> <?php include('../head.php') ?></head>

<!-- HTML form to confirm deletion -->
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <form method="POST" style="text-align: center;">
      <h4>Voulez-vous supprimer le poste? "<?php echo $poste['nom']; ?>"?</h4>
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
