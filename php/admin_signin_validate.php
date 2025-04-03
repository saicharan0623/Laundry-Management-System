<?php
require_once 'db_config.php';
$email= $_POST['emails'];
$password= $_POST['passwords'];

if(strlen($email)>0 && strlen($password)>0){

    $select = "SELECT * FROM admins WHERE email='$email'";
    $getUser = mysqli_query($conn,$select);
    if(mysqli_num_rows($getUser)==1){
        while($row=mysqli_fetch_array($getUser)){
            $encrypted = $row['PASSWORD'];
            if($encrypted){
                echo "Logged in successfully!";
                session_start();
                $_SESSION['username']=$email;
                header("location:admin_dashboard.php");
            } else{
                echo "<script>alert('Wrong email/password');</script>";
            }
        }
    }
} else{
    echo "<script>alert('Please fill all the mandatory fields');</script>";
}
?>