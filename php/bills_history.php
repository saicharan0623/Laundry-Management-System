<?php
include 'db_config.php';
require_once 'session.php';

$email = $_SESSION['email'];

$query_email_to_mobile = "SELECT mobile_no FROM users WHERE email='$email'";
$result_email_to_mobile = mysqli_query($conn, $query_email_to_mobile);

if ($result_email_to_mobile && mysqli_num_rows($result_email_to_mobile) > 0) {
    $row_email_to_mobile = mysqli_fetch_assoc($result_email_to_mobile);
    $mobile_number = $row_email_to_mobile['mobile_no'];

    $sql = "SELECT * FROM laundry_orders WHERE mobile_no = '$mobile_number'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History/Bills</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }
        .edit-btn, .generate-bill-btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            color: white;
            width: 100%;
        }
        .edit-btn {
            background-color: #007bff;
        }
        .generate-bill-btn {
            background-color: #28a745;
        }
        .btn-container {
            display: flex;
            justify-content: center;
        }
        .btn-container button:hover {
        background-color: black;
        }
        .btn-container button {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .container {
            display: flex;
            justify-content: center;
            height: 100vh;
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
        .thead-dark-custom{
            background-color: rgb(186,12,47);
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="mt-5 mb-4">Order History</h1>
                <table class="table table-bordered">
            <thead class="thead-dark-custom">
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Out Date</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Mobile No</th>
                    <th>Room No</th>
                    <th>Top Wear</th>
                    <th>Bottom Wear</th>
                    <th>Other Clothes</th>
                    <th>Dry Cleaning</th>
                    <th>Others</th>
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result) && mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row['order_id']."</td>";
                        echo "<td>".$row['order_date']."</td>";
                        echo "<td>".$row['out_date']."</td>";
                        echo "<td>".$row['full_name']."</td>";
                        echo "<td>".$row['gender']."</td>";
                        echo "<td>".$row['mobile_no']."</td>";
                        echo "<td>".$row['room_no']."</td>";
                        echo "<td>".$row['top_wear']."</td>";
                        echo "<td>".$row['bottom_wear']."</td>";
                        echo "<td>".$row['other_cloths']."</td>";
                        echo "<td>".$row['dry_cleaning']."</td>";
                        echo "<td>".$row['others']."</td>";
                        echo "<td>".$row['service_type']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "<td>".$row['total_amount']."</td>";
                        echo "<td class='btn-container'>";
                        echo "<button class='edit-btn' onclick='editOrder(".$row['order_id'].")'>Edit</button>";
                        echo "<button class='generate-bill-btn' onclick='generateBill(".$row['order_id'].")'>Generate Bill</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='16'>No orders found</td></tr>";
                }
                ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>
    <a href="student_dashboard.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>


   
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   
    <script>
        function editOrder(orderId) {
           
            window.location.href = "update_outdate.php?orderId=" + orderId;
        }

        function generateBill(orderId) {
           
            window.location.href = "generate_bill.php?orderId=" + orderId;
        }
    </script>
</body>
</html>
