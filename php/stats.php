<?php
require_once 'db_config.php';
require_once 'session.php';

// Initialize variables to store counts
$total_users = 0;
$total_orders = 0;
$total_revenue = 0;
$total_washed_cloths = 0;

// Query to count total users
$query_count_users = "SELECT COUNT(*) AS total_users FROM users";
$result_count_users = mysqli_query($conn, $query_count_users);

// Check if query was successful and fetch the count of users
if ($result_count_users) {
    $row_count_users = mysqli_fetch_assoc($result_count_users);
    $total_users = $row_count_users['total_users'];
}

// Query to count total orders
$query_count_orders = "SELECT COUNT(*) AS total_orders FROM laundry_orders";
$result_count_orders = mysqli_query($conn, $query_count_orders);

// Check if query was successful and fetch the count of orders
if ($result_count_orders) {
    $row_count_orders = mysqli_fetch_assoc($result_count_orders);
    $total_orders = $row_count_orders['total_orders'];
}

// Query to calculate total revenue from finished orders
$query_total_revenue = "SELECT SUM(total_amount) AS total_revenue FROM laundry_orders WHERE status = 'Finished'";
$result_total_revenue = mysqli_query($conn, $query_total_revenue);

// Check if query was successful and fetch the total revenue
if ($result_total_revenue) {
    $row_total_revenue = mysqli_fetch_assoc($result_total_revenue);
    $total_revenue = $row_total_revenue['total_revenue'];
}


$query_total_washed_cloths = "SELECT SUM(top_wear) + SUM(bottom_wear) + SUM(other_cloths) AS total_washed_cloths FROM laundry_orders WHERE status = 'Finished'";
$result_total_washed_cloths = mysqli_query($conn, $query_total_washed_cloths);

if ($result_total_washed_cloths) {
    $row_total_washed_cloths = mysqli_fetch_assoc($result_total_washed_cloths);
    $total_washed_cloths = $row_total_washed_cloths['total_washed_cloths'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stats</title>
  <link rel="stylesheet" href="../css/style.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body{
        background-image: url("../images/2.png");
        background-size: cover;
        background-repeat: no-repeat;
        margin: 0;
        padding: 0;
    }
    .navbar-custom {
      background-color: rgb(186,12,47);
    }
    .navbar-custom .navbar-brand {
      color: white;
      margin-right: 2rem;
    }
    .navbar-custom .navbar-nav .nav-link {
      color: white;
    }
    .navbar-custom .navbar-toggler-icon {
      background-color:  rgb(186,12,47);
    }
    .navbar-custom .dropdown-menu .dropdown-item:hover {
      background-color: rgb(186,12,47);
      color: azure;
    }
    .dashboard-box {
      border: 1px solid #ccc;
      padding: 20px;
      margin-bottom: 20px;
      color: #fff;
      text-align: center;
    }
    .new-requests { background-color: #432C7A; }
    .accept { background-color: #80489C; } 
    .in-process { background-color: #FF8FB1; } 
    .finish { background-color: #6D67E4; } 

    .details-btn{
        color:white;
        text-decoration: none;
    }

    .details-btn:hover{
        color:black;
    }
    .count{
        font-size:30px;
    }

    .add-laundry {
  border: 1px solid #ccc;
  padding: 20px;
  margin-bottom: 20px;
  color: #000; /* Text color */
  text-align: center;
  background-color: rgba(225, 255, 245, 0.5);  height:450px; width:1115px; align-self: center; margin:0 auto;
}

.add-laundry .details-btn {
  color: black;
  text-decoration: none;
}

.add-laundry .details-btn:hover {
  color: black;
}
.footer {
      background-color: red;
      color: white;
    }
    h3{
      color:white;
    }

  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container">
    <a class="navbar-brand" href="#">Nmims - Laundry</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="overall_bill.php"><i class="fas fa-barcode"></i> Bills</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="stats.php"><i class="fas fa-tachometer-alt"></i> Stats</a>
        </li>
    
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> Profile
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="admin_signin.php"><i class="fas fa-arrow-left"></i> logout</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top: 50px;">
    <h2 style="text-align:center; margin-bottom:15px;">Full - Details</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="dashboard-box new-requests">
                <h3>Customers</h3>
                <p class="count"><?php echo $total_users; ?></p>
                <a href="view_customers.php" class="details-btn">View Details</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-box accept">
                <h3>Total Orders</h3>
                <p class="count"><?php echo $total_orders; ?></p>
                <a href="view_orders.php" class="details-btn">View Details</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-box in-process">
                <h3>Total Revenue</h3>
                <p class="count"><?php echo $total_revenue; ?></p>
                <a href="view_revenue.php" class="details-btn">View Details</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-box finish">
                <h3>Washed Cloths</h3>
                <p class="count"><?php echo $total_washed_cloths; ?></p>
                <a href="view_washed_cloths.php" class="details-btn">View Details</a>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
