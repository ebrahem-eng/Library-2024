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

    $update = $database->prepare("UPDATE teacher SET name=:name ,email=:email , phone=:phone ,age=:age , gender=:gender , status=:status  WHERE id=:id");
    $update->bindParam("id", $id);
    $update->bindParam("name", $name);
    $update->bindParam("email", $email);
    $update->bindParam("phone", $phone);
    $update->bindParam("age", $age);
    $update->bindParam("gender", $gender);
    $update->bindParam("status", $status);



    if ($update->execute()) {
        header("location:index.php?success=1", true);
    } else {
        echo "not updated <br>";
    }
}
