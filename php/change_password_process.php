<?php
    if(isset($_GET['code'])) {
        $code = $_GET['code'];

        $conn = new mySqli('localhost', 'root', '', 'laundry');
        if($conn->connect_error) {
            die('Could not connect to the database');
        }

        $verifyQuery = $conn->query("SELECT * FROM users WHERE code = '$code'");

        if($verifyQuery->num_rows == 0) {
            header("Location: index.html"); //Need to add error page
            exit();
        }

        if(isset($_POST['change'])) {
            $email = $_POST['email'];
            $new_password = $_POST['new_password'];
            $encrypted = password_hash($new_password,PASSWORD_BCRYPT);
            $changeQuery = $conn->query("UPDATE users SET password = '$encrypted' WHERE email = '$email' and code = '$code'");

            if($changeQuery) {
                header("Location: success.php");
            }
        }
        $conn->close();
    }
    else {
        header("Location: ../index.html");
        exit();
    }
?>
