<?php
if (isset($_POST['delete'])) {
  include('../../Config/config.php');

  $id = $_POST['id'];
  $delete = $database->prepare("DELETE FROM specialization WHERE id = :id");
  $delete->bindParam("id", $id);
  if ($delete->execute()) {
    header("location:index.php?success=1&type=success&message=Specialization Deleted Successfully", true);
  } else {
    echo 'failed';
  }
}
