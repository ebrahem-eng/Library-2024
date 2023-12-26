<?php
if (isset($_POST['revokeSubject'])) {
    include('../../Config/config.php');

    $teacherID = $_POST['teacherID'];
    $subjectID = $_POST['subjectID'];

    $delete = $database->prepare("DELETE FROM subjectTeacher WHERE teacher_id = :teacherID AND subject_id = :subjectID");
    $delete->bindParam(":teacherID", $teacherID);
    $delete->bindParam(":subjectID", $subjectID);

    if ($delete->execute()) {
        header("location:index.php?success=1&type=success&message=Subject Revoke From This Teacher Successfully", true);
    } else {
        echo 'failed';
    }
}
?>
