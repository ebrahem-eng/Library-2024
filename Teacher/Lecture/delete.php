<?php
if (isset($_POST['deleteLecture'])) {
  include('../../Config/config.php');

  $lectureID = $_POST['lectureID'];
  $delete = $database->prepare("DELETE FROM lecture WHERE id = :lectureID");
  $delete->bindParam("lectureID", $lectureID);
  if ($delete->execute()) {
    header("location:Lecture.php?success=1&type=success&message=Lecture Deleted Successfully", true);
  } else {
    echo 'failed';
  }
}
