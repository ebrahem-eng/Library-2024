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

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
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
                            <?php
                            // Check for success message
                            if (isset($_GET['success']) && $_GET['success'] == 1) {
                                $message = ($_GET['type'] == 'success') ? $_GET['message'] : '';
                                echo '<div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
              <span>' . $message . '</span>
              <button type="button" class="btn-close" onclick="redirectToIndex()" aria-label="Close"></button>
          </div>';
                            }
                            ?>


                            <script>
                                function redirectToIndex() {
                                    // Redirect to index.php when the close button is clicked
                                    window.location.href = 'index.php';
                                }
                            </script>


                            <div class="row">
                                <div class="col-6">
                                    <h6>Specializations College Table</h6>
                                </div>
                                <div class="col-6">
                                    <form method="post" action='addSpecialization.php'>
                                        <input type="hidden" value="<?php echo $_POST['id'] ?>" name="collegeID" />
                                        <button type='submit' class="badge badge-sm bg-gradient-dark" name='addSpecialization'>Add New Specialization</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Specialization Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">College Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created by</th>
                                            <th class="text-secondary opacity-7"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        include('../../Config/config.php');

                                        $collegeID = $_POST['id'];

                                        $specializations = $database->prepare("SELECT 
                                        specialization.id AS specializationID,
                                        specialization.name AS specializationName,
                                        specialization.img AS specializationImage,
                                        specialization.created_by AS specializationCreatedBy,
                                        specialization.college_id AS specializationCollege,
                                        college.id AS collegeID,
                                        college.name AS collegeName,
                                        college.img AS collegeImg,
                                        admin.id AS adminID,
                                        admin.name AS adminName
                                    FROM specialization  
                                    INNER JOIN admin
                                    ON admin.id = specialization.created_by
                                    INNER JOIN college
                                    ON college.id = specialization.college_id 
                                    WHERE specialization.college_id = $collegeID 
                                    ");

                                        $specializations->execute();

                                        foreach ($specializations as $specialization) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>

                                                            <?php if (!empty($specialization['specializationImage'])) : ?>
                                                                <img src="<?php echo $specialization['specializationImage']; ?>" class="avatar avatar-sm me-3" alt="user1">
                                                            <?php else : ?>

                                                                <img src="../assets/img/default-avatar.jpg" class="avatar avatar-sm me-3" alt="user1">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?php echo $specialization['specializationName'] ?></h6>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $specialization['collegeName'] ?></p>
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $specialization['adminName'] ?></p>
                                                </td>

                                                <td>
                                                    <form method="post" action='revokeSpecialization.php' onsubmit="return confirm('Are you sure you want to revoke if You Revoke this Specialization It will be Deleted from the Specialization Table ?');">
                                                        <input type="hidden" value="<?php echo $specialization['specializationID'] ?>" name="id" />
                                                        <button type='submit' class="badge badge-sm bg-gradient-danger" style="margin-right: -30px;" name='delete'>Revoke And Delete</button>
                                                    </form>
                                                </td>


                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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