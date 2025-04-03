<?php
// Include database configuration and session
include 'db_config.php';
require_once 'session.php';

// Check if orderId is provided in the URL
if(isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Fetch order details from the database
    $query = "SELECT * FROM laundry_orders WHERE order_id = $orderId";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    } else {
        echo "Order not found.";
        exit;
    }
} else {
    echo "Order ID not provided.";
    exit;
}

// Update or add Out Date in the database
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $outDate = $_POST['out_date'];

    // Check if Out Date is empty
    if(empty($outDate)) {
        echo "Out Date cannot be empty.";
        exit;
    }

    // Update query
    $updateQuery = "UPDATE laundry_orders SET out_date = '$outDate' WHERE order_id = $orderId";

    if(mysqli_query($conn, $updateQuery)) {
        $successMessage = "Out Date updated successfully.";
    } else {
        echo "Error updating Out Date: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Out Date</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
       <style>
    body {
        background-image: url("../images/2.png");
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: black; 
    }
    .form-group {
        width: 45%; 
        float: left;
        margin-right: 5%; 
    }
    .form-group:last-child {
        margin-right: 0; 
    }
    .clearfix {
        clear: both;
    }

        .success-message {
            color: rgb(186, 12, 47); 
            margin-top: 10px;
        }
    h1 {
            font-size: 2.0rem;
            color: rgb(186, 12, 47); 
        }

        .btn-primary{
            background-color:rgb(186,12,47);
        }
        .back-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: black;
        }
        @media (max-width: 768px) {
            .back-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 10px;
            }
        }
</style>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Out Date</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $order['full_name']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="orderId">Order ID</label>
                <input type="text" class="form-control" id="orderId" name="order_id" value="<?php echo $order['order_id']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="money">Total Money</label>
                <input type="text" class="form-control" id="money" name="money" value="<?php echo $order['total_amount']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="orderDate">Order Date</label>
                <input type="text" class="form-control" id="orderDate" name="order_date" value="<?php echo $order['order_date']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="outDate">Out Date</label>
                <input type="date" class="form-control" id="outDate" name="out_date" value="<?php echo $order['out_date']; ?>">
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Update Out Date</button>
            <?php if(isset($successMessage)) { ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php } ?>
        </form>
        <a href="bills_history.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
