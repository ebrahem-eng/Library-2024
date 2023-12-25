<?php
if (isset($_POST['update'])) {
    include('../../Config/config.php');
    $id = $_POST['id'];
    $name = $_POST['name'];
    $yearNumber = $_POST['yearNumber'];
    $uploadDirectory = 'Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $stmt = $database->prepare("SELECT img FROM subject WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $existingImagePath = $result['img'];

    if ($uploadedFileName == null) {
    
        $update = $database->prepare("UPDATE subject SET name=:name, year=:yearNumber WHERE id=:id");
        $update->bindParam(":id", $id);
        $update->bindParam(":name", $name);
        $update->bindParam(":yearNumber", $yearNumber);

        if ($update->execute()) {
            header("location:index.php?success=1&type=success&message=Subject Updated Successfully", true);
            exit();
        } else {
            echo "not updated <br>";
        }
    } else {

        if (getimagesize($_FILES['img']['tmp_name']) !== false) {
           
            if (!empty($existingImagePath) && file_exists($existingImagePath)) {
                unlink($existingImagePath);
                echo 'Previous image deleted. ';
            }

            if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
                $filePathInDatabase = $targetFilePath;

                $update = $database->prepare("UPDATE subject SET name=:name, year=:yearNumber, img=:img WHERE id=:id");
                $update->bindParam(":id", $id);
                $update->bindParam(":name", $name);
                $update->bindParam(":yearNumber", $yearNumber);
                $update->bindParam(":img", $filePathInDatabase);

                if ($update->execute()) {
                    header("location:index.php?success=1&type=success&message=Subject Updated Successfully", true);
                    exit();
                } else {
                    echo "not updated <br>";
                }
            } else {
                echo "Error moving uploaded file to the target directory. <br>";
            }
        } else {
            echo 'File is not an image. Please upload an image file.';
        }
    }
}
