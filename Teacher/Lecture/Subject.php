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


                <div class="col-12 mt-4">
                    <div class="card mb-4">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-1">Subject</h6>
                            <p class="text-sm">Subject Specialization Teacher </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <?php

                                include('../../Config/config.php');
                                $teacherID = $_SESSION['teacher_id'];
                                $specializationID = $_POST['specializationID'];
                                $year = $_POST['year'];

                                $subjects = $database->prepare("SELECT 
    subject.id AS subjectID,
    subject.name AS subjectName,
    subject.img AS subjectImage,
    subject.year AS subjectYear,
    subjectTeacher.subject_id AS subjectTeacherID
FROM subject  
INNER JOIN subjectTeacher
    ON subjectTeacher.subject_id = subject.id
INNER JOIN subjectSpecialization
    ON subjectSpecialization.subject_id = subject.id
WHERE subjectTeacher.teacher_id = :teacherID
    AND subjectSpecialization.specialization_id = :specializationID
    AND subject.year = :year
");

                                $subjects->bindParam(":teacherID", $teacherID);
                                $subjects->bindParam(":specializationID", $specializationID);
                                $subjects->bindParam(":year", $year);
                                $subjects->execute();


                                foreach ($subjects as $subject) {
                                ?>



                                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                        <div class="card card-blog card-plain">
                                            <div class="position-relative">
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    <img src="<?php echo '../../Admin/Subject/' . $subject['subjectImage']; ?>" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl" style="width: 300px; height: 270px;">
                                                </a>
                                            </div>

                                            <div class="card-body px-1 pb-0">

                                                <a href="javascript:;">
                                                    <h5>
                                                        <?php echo $subject['subjectName'] ?>
                                                    </h5>
                                                </a>
                                              <br>
                                                <form action="lecture.php" method="post">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <input type="hidden" name="specializationID" value="<?php echo $specializationID ?>">
                                                        <input type="hidden" name="subjectID" value="<?php echo $subject['subjectID']; ?>">
                                                        <button type="submit" class="btn btn-outline-primary btn-sm mb-0">View Lecture</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                <?php  } ?>

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