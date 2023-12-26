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

                                <form action="create2.php" method="POST" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-md-6 mb-3 ">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pwd">Email:</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 mb-3 ">
                                            <label for="name">Password:</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="collegeID">College:</label>
                                            <select class="form-control" id="collegeSelect" name="collegeID">
                                                <?php
                                                include('../../Config/config.php');
                                                $colleges = $database->prepare("SELECT * FROM college");
                                                $colleges->execute();
                                                foreach ($colleges as $college) {
                                                ?>
                                                    <option value="<?php echo $college['id'] ?>"><?php echo $college['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                    </div>

                                    <button type="submit" name="creat1Send" class="btn btn-primary">
                                        Next
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