<?php
if (isset($_POST['send'])) {
    include('../../Config/config.php');

    $name = $_POST['name'];
    $adminID = $_POST['adminID'];
    $numberYear = $_POST['numberYear'];
    $uploadDirectory = 'Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (getimagesize($_FILES['img']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
            $filePathInDatabase = $targetFilePath;

            $sql = "INSERT INTO college (name, img , numberYear ,created_by) VALUES (:name, :img ,:numberYear , :adminID)";

            $stmt = $database->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":adminID", $adminID);
            $stmt->bindParam(":numberYear", $numberYear);
            $stmt->bindParam(":img", $filePathInDatabase);

            if ($stmt->execute()) {
                header("location:index.php?success=1&type=success&message=College Created Successfully", true);
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo 'File is not an image. Please upload an image file.';
    }
}
