<?php
if (isset($_POST['delete'])) {
  include('../../Config/config.php');

  $id = $_POST['id'];
  $delete = $database->prepare("DELETE FROM college WHERE id = :id");
  $delete->bindParam("id", $id);
  if ($delete->execute()) {
    header("location:index.php?success=1&type=success&message=College Deleted Successfully", true);
  } else {
    echo 'failed';
  }
}
