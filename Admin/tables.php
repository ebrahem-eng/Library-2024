
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1 , shrink-to-fit=no">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php 
include("link.php");
include("nav.php");
include("header.php")
?>



<div class="container mt-3">
  <h2>Admins</h2>
  <br> 
</body>
</html> 
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
</div>   

    <?php

include('../Config/config.php');

$getitem=$database->prepare("SELECT * FROM admin");
$getitem->execute();

foreach($getitem AS $data){
    ?>
 <tr>
        <td><?php echo $data['name'] ?></td>
        <td><?php echo $data['email'] ?></td>
        <td>
              <form method="post" action='Admin/edit.php'>
              <input type="hidden" value="<?php echo $data['id'] ?>" name="id" />
              <button type='submit' class="btn btn-primary" name='edit'>Edit</button></form>  
        </td>
        <td>
            <form method="post" action='Admin/delete.php'>
              <input type="hidden" value="<?php echo $data['id'] ?>" name="id" />
              <button type='submit' class="btn btn-danger" name='delete'>Delete</button></form>             
</td>

</tr>
<?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
  <!-- plugins:js -->
  <script src="../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>





