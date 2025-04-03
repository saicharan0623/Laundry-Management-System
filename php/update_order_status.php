<?php
require_once 'db_config.php';

if(isset($_POST['orderId']) && isset($_POST['status'])) {
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];

    $sql = "UPDATE laundry_orders SET status = ? WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $orderId);
    $result = mysqli_stmt_execute($stmt);

    if($result) {
       
    } else {
     
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>