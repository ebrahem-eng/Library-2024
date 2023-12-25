<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../Admin/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../Admin/assets/img/favicon.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <link href="../../Admin/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../Admin/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../Admin/assets/css/nucleo-svg.css" rel="stylesheet" />

    <link id="pagestyle" href="../../Admin/assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php
    include('../../Admin/sidebar.php')
    ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->

        <?php
        include('../../Admin/header.php');
        ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Update Teacher</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">


                            <div class="container mt-3">

                                <form action="update.php" method="POST">
                                    <?php
                                    if (isset($_POST['edit'])) {
                                        include('../../Config/config.php');
                                        $id = $_POST['id'];
                                        $teachers = $database->prepare("SELECT * FROM teacher WHERE id=:id");
                                        $teachers->bindParam("id", $id);
                                        $teachers->execute();
                                        foreach ($teachers as $teacher) {
                                    ?>

                                            <div class="row">
                                                <div class="col-md-6 mb-3 ">
                                                    <label for="name">Name:</label>
                                                    <input type="text" class="form-control" value="<?php echo $teacher['name'] ?>" name="name">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="pwd">Email:</label>
                                                    <input type="email" class="form-control" value="<?php echo $teacher['email'] ?>" name="email">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3 ">
                                                    <label for="name">Phone:</label>
                                                    <input type="tel" class="form-control" value="<?php echo $teacher['phone'] ?>" name="phone">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="pwd">Age:</label>
                                                    <input type="number" class="form-control" value="<?php echo $teacher['age'] ?>" name="age">
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <label for="gender">Gender:</label>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="0" <?php echo ($teacher['gender'] === 0) ? 'selected' : ''; ?>>Male</option>
                                                        <option value="1" <?php echo ($teacher['gender'] === 1) ? 'selected' : ''; ?>>Female</option>

                                                    </select>
                                                </div>


                                                <div class="col-md-2 mb-3">
                                                    <label for="status">Status:</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" <?php echo ($teacher['status'] === 1) ? 'selected' : ''; ?>>Active</option>
                                                        <option value="0" <?php echo ($teacher['status'] === 0) ? 'selected' : ''; ?>>Not Active</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">
                                                
                                                 <div class="col-md-2 mb-3">  
                                                <label for="created_by">Created by:</label>
                                                <input type="text" class="form-control" value="<?php echo $teacher['name'] ?>" name="name">
                                                 </div> 
                                                 <div class="col-md-6 mb-3">
                                                    <label for="fileInput">Image:</label>
                                                    <input type="file" class="form-control" id="fileInput" name="img">
                                                </div>
                                            </div>


                                    <?php }
                                    } ?>
                                    <input type="hidden" value="<?php echo $teacher['id'] ?>" name="id" />
                                    <button type="submit" name="update" class="btn btn-primary">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <?php
    include('../../Admin/linkJS.php')
    ?>
</body>

</html>