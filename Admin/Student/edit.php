<?php
session_start();

if (!isset($_SESSION['loggedAdmin_in']) || $_SESSION['loggedAdmin_in'] !== true) {
    header("Location: Auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php
    include('../sidebar.php')
    ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->

        <?php
        include('../header.php');
        ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Update Student</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">


                            <div class="container mt-3">

                                <form action="update.php" method="POST" enctype="multipart/form-data">
                                    <?php
                                    if (isset($_POST['edit'])) {
                                        include('../../Config/config.php');
                                        $id = $_POST['id'];
                                        $students = $database->prepare("SELECT * FROM student WHERE id=:id");
                                        $students->bindParam("id", $id);
                                        $students->execute();
                                        foreach ($students as $student) {
                                    ?>

                                            <div class="row">
                                                <div class="col-md-6 mb-3 ">
                                                    <label for="name">Name:</label>
                                                    <input type="text" class="form-control" value="<?php echo $student['name'] ?>" name="name">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="pwd">Email:</label>
                                                    <input type="email" class="form-control" value="<?php echo $student['email'] ?>" name="email">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3 ">
                                                    <label for="name">Phone:</label>
                                                    <input type="tel" class="form-control" value="<?php echo $student['phone'] ?>" name="phone">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label for="pwd">Age:</label>
                                                    <input type="number" class="form-control" value="<?php echo $student['age'] ?>" name="age">
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <label for="gender">Gender:</label>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="0" <?php echo ($student['gender'] === 0) ? 'selected' : ''; ?>>Male</option>
                                                        <option value="1" <?php echo ($student['gender'] === 1) ? 'selected' : ''; ?>>Female</option>

                                                    </select>
                                                </div>


                                                <div class="col-md-2 mb-3">
                                                    <label for="status">Status:</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" <?php echo ($student['status'] === 1) ? 'selected' : ''; ?>>Active</option>
                                                        <option value="0" <?php echo ($student['status'] === 0) ? 'selected' : ''; ?>>Not Active</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">

                                            <div class="col-md-3 mb-3">
                                                <label for="collegeID">Specialization:</label>
                                                <select class="form-control" id="exampleSelectGender" name="specializationID">
                                                    <?php

                                                    include('../../Config/config.php');

                                                    $specializations = $database->prepare("SELECT * FROM specialization WHERE college_id = :StudentcollegeID");
                                                    $specializations->bindParam(":StudentcollegeID", $student['college_id']);
                                                    $specializations->execute();

                                                    foreach ($specializations as $specialization) {
                                                    ?>
                                                        <option value="<?php echo $specialization['id'] ?>"><?php echo $specialization['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="fileInput">Image:</label>
                                                    <input type="file" class="form-control" id="fileInput" name="img">
                                                </div>
                                            </div>


                                    <?php }
                                    } ?>
                                    <input type="hidden" value="<?php echo $student['id'] ?>" name="id" />
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
    include('../linkJS.php')
    ?>
</body>

</html>