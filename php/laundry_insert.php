<?php

require_once 'db_config.php';

    $date = $_POST['date'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $mobile_no = $_POST['mobile_no'];
    $room_no = $_POST['room_no'];
    $top_wear = $_POST['top_wear'];
    $bottom_wear = $_POST['bottom_wear'];
    $other_cloths = $_POST['other_cloths'];
    $dry_cleaning = $_POST['dry_cleaning'];
    $service_type = $_POST['service_type'];
    $status = "Requested";
    $total_amount = $_POST['total_amount']; 

    $sql = "INSERT INTO laundry_orders (order_date, full_name, gender, mobile_no, room_no, top_wear, bottom_wear, other_cloths, dry_cleaning, service_type, status, total_amount)
            VALUES ('$date', '$full_name', '$gender','$mobile_no', '$room_no', '$top_wear', '$bottom_wear', '$other_cloths', '$dry_cleaning', '$service_type', '$status', '$total_amount')";

    if ($conn->query($sql) === TRUE) {
        header("Location: laundry_request_sucess.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>
