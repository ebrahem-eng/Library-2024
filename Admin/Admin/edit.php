<head>
<?php 
include("../nav.php");
include("../header.php");
?>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Soft UI Dashboard by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>
<div class="container mt-3">
  <h2>UPDATE ADMIN</h2>
  <form action="update.php" method="POST">
<?php
if(isset($_POST['edit'])){
    include('../../Config/config.php');
      $id = $_POST['id'];
      $getitem=$database->prepare("SELECT * FROM admin WHERE id=:id");
      $getitem->bindParam("id",$id);
      $getitem->execute();
      foreach($getitem AS $data){
        ?>
  <input type="hidden" value="<?php echo $data['id'] ?>" name="id" />
    <div class="mb-3 mt-3">
      <label for="name">Name:</label>
      <input type="text" class="form-control" value="<?php echo $data['name'] ?>" id="name" placeholder="" name="name">
    </div>
    <div class="mb-3">
      <label for="pwd">Email:</label>
      <input type="email" class="form-control" id="pwd" placeholder="" value="<?php echo $data['email'] ?>" name="email">
    </div>
          <?php } }?>
    <button type="submit" name="update" class="btn btn-primary" >
       Update
    </button>
  </form>
</div>

</body>
</html>
 

