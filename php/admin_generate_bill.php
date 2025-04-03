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

          $date = $order['order_date'];
          $full_name = $order['full_name'];
          $mobile_no = $order['mobile_no'];
          $room_no = $order['room_no'];
          $top_wear = $order['top_wear'];
          $bottom_wear = $order['bottom_wear'];
          $dry_cleaning = $order['dry_cleaning'];
          $service_type = $order['service_type'];
          $other_amount = $order['other_money'];

          $top_wear_cost = 0;
          $bottom_wear_cost = 0;
          $dry_cleaning_cost = $dry_cleaning * 100;

          if ($service_type === "Only Wash") {
              $top_wear_cost = $top_wear * 8;
              $bottom_wear_cost = $bottom_wear * 8;
          } elseif ($service_type === "Only Iron") {
              $top_wear_cost = $top_wear * 7;
              $bottom_wear_cost = $bottom_wear * 10;
          } elseif ($service_type === "Wash and Iron") {
              $top_wear_cost = $top_wear * (8 + 7);
              $bottom_wear_cost = $bottom_wear * (8 + 10);
          } elseif ($service_type === "Color Press") {
            $top_wear_cost = $top_wear * (8 + 7);
            $bottom_wear_cost = $bottom_wear * 8;
          }

          $total_amount = $top_wear_cost + $bottom_wear_cost + $dry_cleaning_cost + $other_amount;
          ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laundry Bill</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
   body {
  background-image: url('../images/2.png');
  background-size: cover;
  background-position: center;
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

.container {
  padding: 40px;
  border-radius: 10px;
}

.card-header h2 {
  color: #333;
}

.card-body {
  color: #555;
}

.table th,
.table td {
  text-align: center;
}

.form-group {
  margin-bottom: 1rem;
}
.btn-primary {
  display: inline-block;
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-bottom: 25px;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.form-group label {
  font-weight: bold;
}

.form-check-input {
  margin-right: 5px;
}

.button-container {
  display: flex;
  justify-content: center;
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
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
        <h2>Laundry Bill - Order No: <?php echo $orderId; ?></h2>
        <p>Generated Date and Time: <?php echo date("Y-m-d H:i:s"); ?></p>
    </div>
        <div class="card-body">
          <p><strong>Full Name:</strong> <?php echo $full_name; ?></p>
          <p><strong>Mobile Number:</strong> <?php echo $mobile_no; ?></p>
          <p><strong>Room Number:</strong> <?php echo $room_no; ?></p>
          <p><strong>Service Type:</strong> <?php echo $service_type; ?></p>
          <p><strong>Ordered date:</strong> <?php echo $order['order_date']; ?></p>
          <p><strong>Out date:</strong> <?php echo  $order['out_date'];?></p>
          <hr>
          <h4>Bill Details</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Cost</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Top Wear</td>
                <td><?php echo $top_wear; ?></td>
                <td>₹ <?php echo $top_wear_cost; ?></td>
              </tr>
              <tr>
                <td>Bottom Wear</td>
                <td><?php echo $bottom_wear; ?></td>
                <td>₹ <?php echo $bottom_wear_cost; ?></td>
              </tr>
              <tr>
                <td>Dry Cleaning</td>
                <td><?php echo $dry_cleaning; ?></td>
                <td>₹ <?php echo $dry_cleaning_cost; ?></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Other Amount</strong></td>
                <td><strong>₹ <?php echo $other_amount;?></strong></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Total Amount</strong></td>
                <td><strong>₹ <?php echo $total_amount; ?></strong></td>
              </tr>
            </tbody>
          </table>
          <div class="button-container">
            <a href="download_bill.php?orderId=<?php echo $orderId; ?>" class="btn btn-primary btn-download">Download Invoice</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<a href="admin_dashboard.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>

</body>
</html>
