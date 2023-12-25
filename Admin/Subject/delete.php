<?php
if (isset($_POST['delete'])) {
  include('../../Config/config.php');

  $id = $_POST['id'];

  $stmt = $database->prepare("SELECT img FROM subject WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $imagePathToDelete = $result['img'];


  $delete = $database->prepare("DELETE FROM subject WHERE id = :id");
  $delete->bindParam(":id", $id);

  if ($delete->execute()) {

    if (!empty($imagePathToDelete) && file_exists($imagePathToDelete)) {
      unlink($imagePathToDelete);
      echo 'Associated image deleted. ';
    }

    header("location:index.php?success=1&type=success&message=Subject Deleted Successfully", true);
  } else {
    echo 'failed';
  }
}
