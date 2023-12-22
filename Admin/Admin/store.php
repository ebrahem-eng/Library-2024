<?php
if(isset($_POST['send'])){
    include('../../Config/config.php');
    
    $name=$_POST['name'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    $age=$_POST['age'];
    $status=$_POST['status'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $uploadDirectory = 'Image/';
    $uploadedFileName = $_FILES['img']['name'];
    $targetFilePath = $uploadDirectory . basename($uploadedFileName);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (getimagesize($_FILES['img']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
            $filePathInDatabase = $targetFilePath;
            
            $sql = "INSERT INTO admin (name, email, password, age, status, gender, phone, img) VALUES (:name, :email, :password, :age, :status, :gender, :phone, :img)";
            
            $stmt = $database->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":age", $age);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":gender", $gender);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":img", $filePathInDatabase); // Fixed parameter name
            
            if ($stmt->execute()) {
                header("location:index.php?success=1&type=success&message=Admin Created Successfully", true);
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo 'File is not an image. Please upload an image file.';
    }
}
?>
