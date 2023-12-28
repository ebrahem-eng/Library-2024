<?php
include("../../Config/config.php");

if (isset($_POST['teacherLogin'])) {
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {

        $checkEmailSql = "SELECT id, password FROM teacher WHERE email = :email";
        $checkEmailStmt = $database->prepare($checkEmailSql);
        $checkEmailStmt->bindParam(":email", $email);
        $checkEmailStmt->execute();

        $result = $checkEmailStmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['password'])) {
                $_SESSION['loggedTeacher_in'] = true;
                $_SESSION['teacher_id'] = $result['id'];
                header("Location: ../index.php");
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "Email not found";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
