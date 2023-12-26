<?php
if (isset($_POST['revokeSpecialization'])) {
    include('../../Config/config.php');

    $teacherID = $_POST['teacherID'];
    $specializationID = $_POST['specializationID'];

    $delete = $database->prepare("DELETE FROM teacherSpecialization WHERE teacher_id = :teacherID AND specialization_id = :specializationID");
    $delete->bindParam(":teacherID", $teacherID);
    $delete->bindParam(":specializationID", $specializationID);

    if ($delete->execute()) {
        header("location:index.php?success=1&type=success&message=Specialization Revoke From This Teacher Successfully", true);
    } else {
        echo 'failed';
    }
}
?>
