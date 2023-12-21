<?php
if(isset($_POST['send'])){
    include('../../Config/config.php');
    
      $name=$_POST['name'];
      $email=$_POST['email'];
      $password=$_POST['password'];
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
      $sql = "INSERT INTO admin (name, email ,password) VALUES (:name, :email , :password)";
      $stmt = $database->prepare($sql);
      $stmt->bindParam("name", $name);
      $stmt->bindParam("email", $email);
      $stmt->bindParam("password", $hashedPassword);
      if ($stmt->execute()) {
          echo "Sign up successful. Welcome, $name!";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }
?>
