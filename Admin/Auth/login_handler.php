<?php

if(isset($_POST['login'])){
    include("../../Config/config.php");
    $login=$database->prepare("SELECT * FROM admin WHERE email=:email AND password=:password");
    $login->bindParam("email",$_POST['email']);
    $login->bindParam("password",$_POST['password']);
    $login->execute();
    if($login->rowCount()>1){
        header("Location:../index.php");
    }
    else
    echo '<a class="btn btn-secondary mt3" href="register.php">يرجي التفعيل من البداية</a>';
    }
    ?>