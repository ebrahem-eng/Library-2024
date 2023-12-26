<?php
if (isset($_POST['chooseSubject'])) {
    include('../../Config/config.php');

    $teacherID = $_POST['teacherID'];
    $subjectID = $_POST['subjectID'];

    // Check if the subject is already assigned to the teacher
    $checkSql = "SELECT COUNT(*) AS count FROM subjectTeacher WHERE teacher_id = :teacherID AND subject_id = :subjectID";
    $checkStmt = $database->prepare($checkSql);
    $checkStmt->bindParam(":teacherID", $teacherID);
    $checkStmt->bindParam(":subjectID", $subjectID);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        header("location:index.php?success=0&type=error&message=Subject Already Assigned to Teacher");
        exit();
    }

    // If all checks pass, insert the record
    $sql = "INSERT INTO subjectTeacher (teacher_id, subject_id) VALUES (:teacherID, :subjectID)";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":teacherID", $teacherID);
    $stmt->bindParam(":subjectID", $subjectID);

    if ($stmt->execute()) {
        header("location:index.php?success=1&type=success&message=Subject Assigned to Teacher Successfully");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
