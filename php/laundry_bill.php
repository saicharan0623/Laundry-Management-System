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
          <h2>Laundry Bill</h2>
        </div>
        <div class="card-body">
          <?php
          $date = $_POST['date'];
          $full_name = $_POST['full_name'];
          $gender = $_POST['gender'];
          $mobile_no = $_POST['mobile_no'];
          $room_no = $_POST['room_no'];
          $top_wear = $_POST['top_wear'];
          $bottom_wear = $_POST['bottom_wear'];
          $other_cloths = $_POST['other_cloths'];
          $drycleaning = $_POST['dry_cleaning'];
          $service_type = $_POST['service_type'];

          $top_wear_cost = 0;
          $bottom_wear_cost = 0;
          $other_cloths_cost = 0;
          $dry_cleaning_cost = $drycleaning * 100;

          if ($service_type === "Only Wash") {
              $top_wear_cost = $top_wear * 8;
              $bottom_wear_cost = $bottom_wear * 8;
          } elseif ($service_type === "Only Iron") {
              $top_wear_cost = $top_wear * 7;
              $bottom_wear_cost = $bottom_wear * 7;
          } elseif ($service_type === "Wash and Iron") {
              $top_wear_cost = $top_wear * (8 + 7);
              $bottom_wear_cost = $bottom_wear * (8 + 7);
          } elseif ($service_type === "Color Press") {
            $top_wear_cost = $top_wear * (8 + 7);
            $bottom_wear_cost = $bottom_wear * 8;
          }

          // Calculate total amount
          $total_amount = $top_wear_cost + $bottom_wear_cost  + $dry_cleaning_cost;
          ?>
          <p><strong>Date:</strong> <?php echo $date; ?></p>
          <p><strong>Full Name:</strong> <?php echo $full_name; ?></p>
          <p><strong>Mobile Number:</strong> <?php echo $mobile_no; ?></p>
          <p><strong>Room Number:</strong> <?php echo $room_no; ?></p>
          <p><strong>Service Type:</strong> <?php echo $service_type; ?></p>
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
                <td>Other Cloths</td>
                <td><?php echo $other_cloths; ?></td>
                <td>Added when u receive</td>
              </tr>
              <tr>
                <td>Dry Cleaning</td>
                <td><?php echo $drycleaning; ?></td>
                <td>₹ <?php echo $dry_cleaning_cost; ?></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Total Amount</strong></td>
                <td><strong>₹ <?php echo $total_amount; ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>
        <form method="POST" action="laundry_insert.php" class="laundry-form">
          <div class="form-group text-center">
            <label for="payment_method">Payment Method:</label>
            <input type="hidden" name="date" value="<?php echo $date; ?>">
            <input type="hidden" name="full_name" value="<?php echo $full_name; ?>">
            <input type="hidden" name="gender" value="<?php echo $gender; ?>">
            <input type="hidden" name="mobile_no" value="<?php echo $mobile_no; ?>">
            <input type="hidden" name="room_no" value="<?php echo $room_no; ?>">
            <input type="hidden" name="top_wear" value="<?php echo $top_wear; ?>">
            <input type="hidden" name="bottom_wear" value="<?php echo $bottom_wear; ?>">
            <input type="hidden" name="other_cloths" value="<?php echo $other_cloths; ?>">
            <input type="hidden" name="dry_cleaning" value="<?php echo $drycleaning; ?>">
            <input type="hidden" name="service_type" value="<?php echo $service_type; ?>">
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <input type="hidden" name="status" value="Requested">
            <div>
              <input type="radio" id="cash_on_receive" name="payment_method" value="Cash on Receive" checked>
              <label for="cash_on_receive">Cash on Receive</label>
            </div>
          </div>
          <div class="button-container">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<a href="laundry_request.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>
</body>
</html>
