<?php
include("../cnx.php");

if(isset($_GET['id']) && isset($_GET['poste_id'])) {
  $id = $_GET['id'];
  $poste_id = $_GET['poste_id'];

  // check if user confirmed the deletion
  if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'Yes') {
    $query = "DELETE FROM postes_parameters WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if(!$result) {
      die("Query Failed.");
    }

    $_SESSION['message'] = 'Parametre supprimé avec succès';
    $_SESSION['message_type'] = 'danger';
    header("Location: ../codes/editpo.php?id=" . $_GET['poste_id']);
    exit();
  } elseif (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'No') {
    // redirect to editli.php with the same $ligne_id
    header("Location: ../codes/editpo.php?id=" . $_GET['poste_id']);
    exit();
  }

  // retrieve the poste record from the database
  $poste_sql = "SELECT * FROM postes_parameters WHERE id = $id";
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
      <h4>Voulez-vous supprimer le parametre? "<?php echo $poste['parameter']; ?>"?</h4>
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
