<?php
if (isset($_POST['send'])) {
    include('../../Config/config.php');

    $name = $_POST['name'];
    $adminID = $_POST['adminID'];
    $yearNumber = $_POST['yearNumber'];
    $uploadDirectory = 'Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (getimagesize($_FILES['img']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
            $filePathInDatabase = $targetFilePath;

            $sql = "INSERT INTO subject (name, img , year ,created_by) VALUES (:name, :img ,:yearNumber , :adminID)";

            $stmt = $database->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":adminID", $adminID);
            $stmt->bindParam(":yearNumber", $yearNumber);
            $stmt->bindParam(":img", $filePathInDatabase);

            if ($stmt->execute()) {
                header("location:index.php?success=1&type=success&message=Subject Created Successfully", true);
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo 'File is not an image. Please upload an image file.';
    }
}
