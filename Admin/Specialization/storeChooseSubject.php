<?php
if (isset($_POST['chooseSubject'])) {
    include('../../Config/config.php');

    $subjectID = $_POST['subjectID'];
    $specializationID = $_POST['specializationID'];

    // Check subject year
    $checkYearSubject = "SELECT year FROM subject WHERE id = :subjectID";
    $checkStmtSubject = $database->prepare($checkYearSubject);
    $checkStmtSubject->bindParam(":subjectID", $subjectID);
    $checkStmtSubject->execute();
    $resultSubjectYear = $checkStmtSubject->fetch(PDO::FETCH_ASSOC);

    // Check college year
    $checkYearCollege = "SELECT 
                            specialization.id AS specializationID,
                            specialization.college_id AS specializationCollege,
                            college.id AS collegeID,
                            college.name AS collegeName,
                            college.numberYear AS collegeNumberYear
                        FROM specialization  
                        INNER JOIN college
                        ON college.id = specialization.college_id
                        WHERE specialization.id = :specializationID";

    $checkStmtCollege = $database->prepare($checkYearCollege);
    $checkStmtCollege->bindParam(":specializationID", $specializationID);
    $checkStmtCollege->execute();
    $resultCollegeYear = $checkStmtCollege->fetch(PDO::FETCH_ASSOC);

    // Check if subject year is greater than college year
    if ($resultSubjectYear['year'] > $resultCollegeYear['collegeNumberYear']) {
        header("location:index.php?success=0&type=error&message=Subject Year More Than College Year");
        exit();
    }

    // Check if the subject is already assigned to the specialization
    $checkSql = "SELECT COUNT(*) AS count FROM subjectSpecialization WHERE subject_id = :subjectID AND specialization_id = :specializationID";
    $checkStmt = $database->prepare($checkSql);
    $checkStmt->bindParam(":subjectID", $subjectID);
    $checkStmt->bindParam(":specializationID", $specializationID);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        header("location:index.php?success=0&type=error&message=Subject Already Assigned to Specialization");
        exit();
    }

    // If all checks pass, insert the record
    $sql = "INSERT INTO subjectSpecialization (subject_id, specialization_id) VALUES (:subjectID, :specializationID)";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(":subjectID", $subjectID);
    $stmt->bindParam(":specializationID", $specializationID);

    if ($stmt->execute()) {
        header("location:index.php?success=1&type=success&message=Subject Assigned to Specialization Successfully");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
