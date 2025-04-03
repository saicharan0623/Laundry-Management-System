<?php
require_once 'db_config.php';

$email = $_POST['emails'];
$password = $_POST['passwords'];

if (strlen($email) > 0 && strlen($password) > 0) {
    $select = "SELECT * FROM users WHERE email='$email'";
    $getUser = mysqli_query($conn, $select);

    if (mysqli_num_rows($getUser) == 1) {
        while ($row = mysqli_fetch_array($getUser)) {
            $encrypted = $row['password'];
            $decrypted = password_verify($password, $encrypted);

            if ($decrypted) {
                session_start();
                $_SESSION['email'] = $email;
                header("location: student_dashboard.php");
            } else {
                header("location: singin.php?error=Wrong email/password");
                exit;
            }
        }
    } else {
        header("location: singin.php?error=Wrong email/password");
        exit;
    }
} else {
    header("location: singin.php?error=Please fill all the mandatory fields and correctly");
    exit;
}
?>
