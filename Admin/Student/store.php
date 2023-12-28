<?php
if (isset($_POST['send'])) {
    include('../../Config/config.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $status = $_POST['status'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $collegeID = $_POST['collegeID'];
    $specializationID = $_POST['specializationID'];
    $adminID = $_POST['adminID'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $uploadDirectory = 'Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (getimagesize($_FILES['img']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
            $filePathInDatabase = $targetFilePath;

            $sql = "INSERT INTO student (name, email, password, age, status, gender, phone, img , college_id , specialization_id , created_by) VALUES (:name, :email, :password, :age, :status, :gender, :phone, :img,:collegeID ,:specializationID , :adminID)";

            $stmt = $database->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":age", $age);
            $stmt->bindParam(":collegeID", $collegeID);
            $stmt->bindParam(":specializationID", $specializationID);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":gender", $gender);
            $stmt->bindParam(":adminID", $adminID);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":img", $filePathInDatabase);

            if ($stmt->execute()) {
                header("location:index.php?success=1&type=success&message=Student Created Successfully", true);
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo 'File is not an image. Please upload an image file.';
    }
}
