<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../Admin/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../Admin/assets/img/favicon.png">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../Admin/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../Admin/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../Admin/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
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
                            <?php
                            // Check for success message
                            if (isset($_GET['success']) && $_GET['success'] == 1) {
                                echo '<div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
              <span>Update successful!</span>
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


                            <h6>Teacher Table</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Teacher</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Age</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gender</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created by</th>

                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        include('../../Config/config.php');

                                        $teachers = $database->prepare("SELECT * FROM teacher");
                                        $teachers->execute();

                                        foreach ($teachers as $teacher) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="../../Admin/assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?php echo $teacher['name'] ?></h6>
                                                            <p class="text-xs text-secondary mb-0"><?php echo $teacher['email'] ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $teacher['phone'] ?></p>

                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?php echo $teacher['age'] ?></p>
                                                </td>

                                                <td>
                                                    <?php

                                                    if ($teacher['gender'] == 0) {
                                                    ?>
                                                        <p class="text-xs font-weight-bold mb-0">Male</p>

                                                    <?php } else {
                                                    ?>

                                                        <p class="text-xs font-weight-bold mb-0">Female</p>

                                                    <?php
                                                    }
                                                    ?>

                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <?php

                                                    if ($teacher['status'] == 0) {
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
                                                    <?php
                                                    $teachers = $database->prepare("SELECT admin.name AS AdminName FROM admin JOIN teacher 
                                                    ON admin.id = teacher.created_by;");
                                                    $teachers->execute();
                                                    $teachers->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($teachers as $name){  ?>
                                                      <p class="text-xs font-weight-bold mb-0"><?php echo $name['AdminName'];
                                                    }
                                                    ?>
                                                     </td>

                                                <td>
                                                    <form method="post" action="edit.php">
                                                        <input type="hidden" value="<?php echo $teacher['id'] ?>" name="id" />
                                                        <button type='submit' class="badge badge-sm bg-gradient-primary" style="margin-right: -30px;" name='edit'>Edit</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" action='delete.php'>
                                                        <input type="hidden" value="<?php echo $teacher['id'] ?>" name="id" />
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
    include('../../Admin/linkJS.php')
    ?>
</body>

</html>