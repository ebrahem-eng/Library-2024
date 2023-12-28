<?php
session_start();

if (!isset($_SESSION['loggedTeacher_in']) || $_SESSION['loggedTeacher_in'] !== true) {
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
                            <?php

                            if (isset($_GET['success']) && $_GET['success'] == 1) {
                                $message = ($_GET['type'] == 'success') ? $_GET['message'] : '';
                                echo '<div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
          <span>' . $message . '</span>
          <button type="button" class="btn-close" onclick="redirectToIndex()" aria-label="Close"></button>
      </div>';
                            }

                            if (isset($_GET['success']) && $_GET['success'] == 0) {
                                $message = ($_GET['type'] == 'error') ? $_GET['message'] : '';
                                echo '<div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
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
                                    <h6>Lecture Table</h6>
                                </div>

                                <div class="col-3">
                                    <form method="post" action='uploadLecture.php'>
                                        <input type="hidden" value="<?php echo $_POST['specializationID'] ?>" name="specializationID" />
                                        <input type="hidden" value="<?php echo $_POST['subjectID'] ?>" name="subjectID" />
                                        <button type='submit' class="badge badge-sm bg-gradient-dark" name='chooseSubject'>Upload New Lecture</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Specialization Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subject Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created by</th>

                                            <th class="text-secondary opacity-7"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        include('../../Config/config.php');

                                        $specializationID = $_POST['specializationID'];
                                        $subjectID = $_POST['subjectID'];
                                        $teacherID = $_SESSION['teacher_id'];

                                        $lectures = $database->prepare("SELECT 
                                            lecture.id AS lectureID,
                                            lecture.name AS lectureName,
                                            lecture.specialization_id AS lectureSpecializationID,
                                            lecture.subject_id AS lectureSubjectID,
                                            lecture.created_by AS lectureCreatedBy,
                                            specialization.id AS specializationID,
                                            specialization.name AS specializationName,
                                            specialization.img AS specializationImage,
                                            subject.id AS subjectID,
                                            subject.name AS subjectName,
                                            subject.img AS subjectImage,
                                            subject.year AS subjectYear,
                                            teacher.id AS teacherID,
                                            teacher.name AS teacherName
                                        FROM lecture  
                                        INNER JOIN specialization
                                            ON specialization.id = lecture.specialization_id
                                        INNER JOIN subject
                                            ON subject.id = lecture.subject_id
                                        INNER JOIN teacher
                                            ON teacher.id = lecture.created_by
                                        WHERE lecture.created_by = :teacherID
                                            AND lecture.specialization_id = :specializationID
                                            AND lecture.subject_id = :subjectID
                                        ");

                                        $lectures->bindParam(":teacherID", $teacherID);
                                        $lectures->bindParam(":specializationID", $specializationID);
                                        $lectures->bindParam(":subjectID", $subjectID);
                                        $lectures->execute();

                                        foreach ($lectures as $lecture) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">

                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?php echo $lecture['lectureName'] ?></h6>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $lecture['specializationName'] ?></p>

                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $lecture['subjectName'] ?></p>
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $lecture['teacherName'] ?></p>
                                                </td>


                                                <td>
                                                    <form method="post" action='delete.php'>
                                                        <input type="hidden" value="<?php echo $lecture['lectureID'] ?>" name="lectureID" />
                                                        <button type='submit' class="badge badge-sm bg-gradient-danger" name='deleteLecture'>Delete</button>
                                                    </form>
                                                </td>

                                                <td>
                                                    <form method="get" action='downloadLecture.php'>
                                                        <input type="hidden" value="<?php echo $lecture['lectureID'] ?>" name="lectureID" />
                                                        <button type='submit' class="badge badge-sm bg-gradient-success" name='downloadLec'>Download</button>
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