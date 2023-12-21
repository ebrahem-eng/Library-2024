<?php
if(isset($_POST['update'])){
    include('../../Config/config.php');
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
      $update=$database->prepare("UPDATE admin SET name=:name ,email=:email WHERE id=:id");
      $update->bindParam("id",$id);
      $update->bindParam("name",$name);
      $update->bindParam("email",$email);

  
  if($update->execute()){
      header("location:../tables.php",true);
  }
  else {
      echo "not updated <br>";
  }
  }
?>

