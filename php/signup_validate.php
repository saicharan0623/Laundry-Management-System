<?php

require_once 'db_config.php';

$sapid =$_POST['sap_id'];
$fullname= $_POST['full_name'];
$gender = $_POST['gender'];
$school =$_POST['school'];
$mobile =$_POST['mobile_no'];
$email= $_POST['email'];
$password= $_POST['password'];
$confirm_password= $_POST['confirm_password'];


if($password==$confirm_password){

    if(strlen($fullname)>0 && strlen($email)>0 && strlen($gender)>0 && strlen($password)>0 && strlen($sapid)>0 && strlen($school)>0 &&
    strlen($mobile)>0){


        $select="SELECT * FROM users WHERE email='$email'";

        $getUser = mysqli_query($conn,$select);
        if(mysqli_num_rows($getUser)==1){
            echo "<script>alert('Already registered with this mail');</script>";
        } else{

            $encrypted = password_hash($password,PASSWORD_BCRYPT);
            
            $insert = "INSERT INTO users (sapid,full_name,gender,school,mobile_no,email,password)
                        VALUES ($sapid,'$fullname','$gender','$school','$mobile','$email','$encrypted')";
            $insertUser = mysqli_query($conn,$insert);
            if($insertUser){
                header("location: signup_success.php");
            } else{
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    } else{
        echo "<script>alert('Please fill all the mandatory fields');</script>";
    }
} else{
    echo "<script>alert('Passwords are not matching');</script>";
}
?>