<?php
if (isset($_POST['revokeSubject'])) {
    include('../../Config/config.php');

    $subjectID = $_POST['id'];
    $specializationID = $_POST['specializationID'];

    $delete = $database->prepare("DELETE FROM subjectSpecialization WHERE subject_id = :subjectID AND specialization_id = :specializationID");
    $delete->bindParam(":subjectID", $subjectID);
    $delete->bindParam(":specializationID", $specializationID);

    if ($delete->execute()) {
        header("location:index.php?success=1&type=success&message=Subject Revoke From This Specialization Successfully", true);
    } else {
        echo 'failed';
    }
}
?>
