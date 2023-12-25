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
                            <h6>Add Specialization</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">


                            <div class="container mt-3">

                                <form action="storeSpecialization.php" method="POST" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-md-6 mb-3 ">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="fileInput">Image:</label>
                                            <input type="file" class="form-control" id="fileInput" accept="image/*" name="img" required>
                                        </div>
                                    </div>

                            <input type="hidden" value="<?php echo $_POST['collegeID'] ?>" name="collegeID" />
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