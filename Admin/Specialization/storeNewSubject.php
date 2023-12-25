<?php
if (isset($_POST['storeNewSubject'])) {
    include('../../Config/config.php');

    $name = $_POST['name'];
    $adminID = $_POST['adminID'];
    $yearNumber = $_POST['yearNumber'];
    $uploadDirectory = '../Subject/Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if a subject with the same name already exists
    $checkSql = "SELECT COUNT(*) AS count FROM subject WHERE name = :name";
    $checkStmt = $database->prepare($checkSql);
    $checkStmt->bindParam(":name", $name);
    $checkStmt->execute();
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // Subject with the same name already exists, return with an error message
        header("location:index.php?success=0&type=error&message=Subject with the same name already exists");
        exit();
    }

    if (getimagesize($_FILES['img']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
            $filePathInDatabase = $targetFilePath;

            $sql = "INSERT INTO subject (name, img, year, created_by) VALUES (:name, :img, :yearNumber, :adminID)";

            $stmt = $database->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":adminID", $adminID);
            $stmt->bindParam(":yearNumber", $yearNumber);
            $stmt->bindParam(":img", $filePathInDatabase);

            if ($stmt->execute()) {
                // Get the ID of the last inserted subject
                $subjectID = $database->lastInsertId();
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

                // If all checks pass, insert the record into subjectSpecialization
                $sqll = "INSERT INTO subjectSpecialization (subject_id, specialization_id) VALUES (:subjectID, :specializationID)";
                $stmtt = $database->prepare($sqll);
                $stmtt->bindParam(":subjectID", $subjectID);
                $stmtt->bindParam(":specializationID", $specializationID);

                if ($stmtt->execute()) {
                    header("location:index.php?success=1&type=success&message=Subject Assigned to Specialization Successfully");
                    exit();
                } else {
                    echo "Error: " . $stmtt->errorInfo()[2];
                }
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo 'File is not an image. Please upload an image file.';
    }
}
