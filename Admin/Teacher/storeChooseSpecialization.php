<?php
if (isset($_POST['chooseSpecialization'])) {
    include('../../Config/config.php');

    $teacherID = $_POST['teacherID'];
    $specializationID = $_POST['specializationID'];

    // Check if the specializationID is already assigned to the teacher
    $checkSql = "SELECT COUNT(*) AS count FROM teacherSpecialization WHERE teacher_id = :teacherID AND specialization_id = :specializationID";
    $checkStmt = $database->prepare($checkSql);
    $checkStmt->bindParam(":teacherID", $teacherID);
    $checkStmt->bindParam(":specializationID", $specializationID);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        header("location:index.php?success=0&type=error&message=Specialization Already Assigned to Teacher");
        exit();
    }

    // If all checks pass, insert the record
    $sql = "INSERT INTO teacherSpecialization (teacher_id, specialization_id) VALUES (:teacherID, :specializationID)";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":teacherID", $teacherID);
    $stmt->bindParam(":specializationID", $specializationID);

    if ($stmt->execute()) {
        header("location:index.php?success=1&type=success&message=Specialization Assigned to Teacher Successfully");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
