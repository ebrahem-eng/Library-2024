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
    <!-- CSS Files -->
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
                  
                                    window.location.href = 'index.php';
                                }
                            </script>
                            <h6>Student Table</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Age</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gender</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">College</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Specialization</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created by</th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        include('../../Config/config.php');

                                        $students = $database->prepare("SELECT student.id as studentID,
                                        student.name as studentName,
                                        student.email as studentEmail,
                                        student.age as studentAge,
                                        student.gender as studentGender,
                                        student.status as studentStatus,
                                        student.phone as studentPhone,
                                        student.college_id as studentCollegeID,
                                        student.specialization_id as studentSpecializationID,
                                        student.img as studentImg,
                                        student.created_by as studentCreatedBy,
                                        college.id as collegeID,
                                        college.name as collegeName,
                                        specialization.id as specializationID,
                                        specialization.name as specializationName,
                                        admin.id as adminID,
                                        admin.name as adminName
                                         FROM student
                                         INNER JOIN admin
                                         ON admin.id=student.created_by
                                         INNER JOIN college
                                         ON college.id=student.college_id
                                         INNER JOIN specialization
                                         ON specialization.id=student.specialization_id
                                         ");
                                        $students->execute();

                                        foreach ($students as $student) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                 
                                                            <?php if (!empty($student['studentImg'])) : ?>
                                                                <img src="<?php echo $student['studentImg']; ?>" class="avatar avatar-sm me-3" alt="user1">
                                                            <?php else : ?>
                                                       
                                                                <img src="../Admin/assets/img/default-avatar.jpg" class="avatar avatar-sm me-3" alt="user1">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?php echo $student['studentName']; ?></h6>
                                                            <p class="text-xs text-secondary mb-0"><?php echo $student['studentEmail']; ?></p>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $student['studentPhone'] ?></p>

                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $student['studentAge'] ?></p>
                                                </td>
                                              


                                                <td>
                                                    <?php

                                                    if ($student['studentGender'] == 0) {
                                                    ?>
                                                        <p class="text-xs font-weight-bold mb-0">Male</p>

                                                    <?php } else {
                                                    ?>

                                                        <p class="text-xs font-weight-bold mb-0">Female</p>

                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $student['collegeName'] ?></p>
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $student['specializationName'] ?></p>
                                                </td>
                                              

                                                <td class="align-middle text-center text-sm">
                                                    <?php

                                                    if ($student['studentStatus'] == 0) {
                                                    ?>
                                                        <span class="badge badge-sm bg-gradient-danger">Not Active</span>

                                                    <?php } else {
                                                    ?>

                                                        <span class="badge badge-sm bg-gradient-success">Active</span>

                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $student['adminName'] ?></p>
                                                </td>

                                                <td>
                                                    <form method="post" action="edit.php">
                                                        <input type="hidden" value="<?php echo $student['studentID'] ?>" name="id" />
                                                        <button type='submit' class="badge badge-sm bg-gradient-primary" style="margin-right: -30px;" name='edit'>Edit</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" action='delete.php'>
                                                        <input type="hidden" value="<?php echo $student['studentID'] ?>" name="id" />
                                                        <button type='submit' class="badge badge-sm bg-gradient-danger" name='delete'>Delete</button>
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
    include('../linkJS.php')
    ?>
</body>

</html>