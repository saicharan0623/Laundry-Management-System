<?php
require_once 'db_config.php';

if(isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];
    $extraOtherClothes = isset($_POST['extraOtherClothes']) ? $_POST['extraOtherClothes'] : 0; // Default to 0 if not provided

    // Update total amount and other amount
    $sql_update_amount = "UPDATE laundry_orders SET total_amount = total_amount + ?, other_money = ? WHERE order_id = ?";
    $stmt_update_amount = mysqli_prepare($conn, $sql_update_amount);
    mysqli_stmt_bind_param($stmt_update_amount, "ddi", $extraOtherClothes, $extraOtherClothes, $orderId);
    $result_update_amount = mysqli_stmt_execute($stmt_update_amount);

    if ($result_update_amount) {
        echo "Total amount and other amount updated successfully.";
    } else {
        echo "Error updating total amount and other amount.";
    }

    mysqli_stmt_close($stmt_update_amount);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
