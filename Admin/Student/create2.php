<?php
session_start();

if (!isset($_SESSION['loggedAdmin_in']) || $_SESSION['loggedAdmin_in'] !== true) {
    header("Location: Auth/login.php");
    exit();
}

if (isset($_POST['creat1Send'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $collegeID = $_POST['collegeID'];
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

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                                <h6>Add Student</h6>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">


                                <div class="container mt-3">

                                    <form action="store.php" method="POST" enctype="multipart/form-data">

                                        <div class="row">

                                            <div class="col-md-3 mb-3">
                                                <label for="collegeID">Specialization:</label>
                                                <select class="form-control" id="exampleSelectGender" name="specializationID">
                                                    <?php

                                                    include('../../Config/config.php');

                                                    $specializations = $database->prepare("SELECT * FROM specialization WHERE college_id = :collegeID");
                                                    $specializations->bindParam(":collegeID", $collegeID);
                                                    $specializations->execute();

                                                    foreach ($specializations as $specialization) {
                                                    ?>
                                                        <option value="<?php echo $specialization['id'] ?>"><?php echo $specialization['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3 ">
                                                <label for="name">Phone:</label>
                                                <input type="tel" class="form-control" name="phone" required>
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <label for="pwd">Age:</label>
                                                <input type="number" class="form-control" name="age" required>
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <label for="gender">Gender:</label>
                                                <select class="form-control" id="gender" name="gender" required>
                                                    <option value="0">Male</option>
                                                    <option value="1">Female</option>

                                                </select>
                                            </div>

                                        </div>

                                        <div class="row">


                                            <div class="col-md-2 mb-3">
                                                <label for="status">Status:</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Not Active</option>
                                                </select>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label for="fileInput">Image:</label>
                                                <input type="file" class="form-control" id="fileInput" name="img">
                                            </div>
                                        </div>

                                        <input type="hidden" name="name" value="<?php echo $name ?>">
                                        <input type="hidden" name="email" value="<?php echo $email ?>">
                                        <input type="hidden" name="password" value="<?php echo $password ?>">
                                        <input type="hidden" name="collegeID" value="<?php echo $collegeID ?>">
                                        <input type="hidden" name="adminID" value="<?php echo $_SESSION['admin_id'] ?>">
                                        <button type="submit" name="send" class="btn btn-primary">
                                            Save
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
<?php } ?>