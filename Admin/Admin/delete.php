<?php
   if(isset($_POST['delete'])){
    include('../../Config/config.php');

       $id = $_POST['id'];
       $delete =$database->prepare("DELETE FROM admin WHERE id = :id");
       $delete->bindParam("id",$id);
       if($delete->execute()){
         header("location:index.php?success=1", true);
       }
       else{
        echo 'failed';
       }
}
?>