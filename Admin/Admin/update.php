<?php
if (isset($_POST['update'])) {
    include('../../Config/config.php');
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];
    $uploadDirectory = 'Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $stmt = $database->prepare("SELECT img FROM admin WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $existingImagePath = $result['img'];

    if ($uploadedFileName == null) {
        $update = $database->prepare("UPDATE admin SET name=:name ,email=:email , phone=:phone ,age=:age , gender=:gender , status=:status WHERE id=:id");
        $update->bindParam(":id", $id);
        $update->bindParam(":name", $name);
        $update->bindParam(":email", $email);
        $update->bindParam(":phone", $phone);
        $update->bindParam(":age", $age);
        $update->bindParam(":gender", $gender);
        $update->bindParam(":status", $status);

        if ($update->execute()) {

            if (!empty($existingImagePath) && file_exists($existingImagePath)) {
                unlink($existingImagePath);
                echo 'Previous image deleted. ';
            }

            header("location:index.php?success=1&type=success&message=Admin Updated Successfully", true);
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

                $update = $database->prepare("UPDATE admin SET name=:name ,email=:email , phone=:phone ,age=:age , gender=:gender , status=:status, img=:img WHERE id=:id");
                $update->bindParam(":id", $id);
                $update->bindParam(":name", $name);
                $update->bindParam(":email", $email);
                $update->bindParam(":phone", $phone);
                $update->bindParam(":age", $age);
                $update->bindParam(":gender", $gender);
                $update->bindParam(":status", $status);
                $update->bindParam(":img", $filePathInDatabase);

                if ($update->execute()) {
                    header("location:index.php?success=1&type=success&message=Admin Updated Successfully", true);
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
?>
