<?php
if (isset($_POST['delete'])) {
  include('../../Config/config.php');

  $id = $_POST['id'];


    // Check if the subject is already assigned to the specialization
    $checkSql = "SELECT COUNT(*) AS count FROM subjectSpecialization WHERE specialization_id = :specializationID";
    $checkStmt = $database->prepare($checkSql);
    $checkStmt->bindParam(":specializationID", $id);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        header("location:index.php?success=0&type=error&message=Specialization Already Content Subject Please Revoke All Subject To Able Dalete  ");
        exit();
    }

    $stmt = $database->prepare("SELECT img FROM specialization WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $imagePathToDelete = $result['img'];
  
  
    $delete = $database->prepare("DELETE FROM specialization WHERE id = :id");
    $delete->bindParam(":id", $id);
  
    if ($delete->execute()) {
  
      if (!empty($imagePathToDelete) && file_exists($imagePathToDelete)) {
        unlink($imagePathToDelete);
        echo 'Associated image deleted. ';
      }
  
      header("location:index.php?success=1&type=success&message=Specialization Deleted Successfully", true);
    } else {
      echo 'failed';
    }
}
