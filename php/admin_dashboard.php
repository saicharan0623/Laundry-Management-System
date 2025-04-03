<?php
require_once 'db_config.php';
require_once 'session.php';

$req_requested = 0;
$req_received = 0;
$req_inprocess = 0;
$req_finished = 0;

// Query to count for each category
$query_count_status = "SELECT status, COUNT(*) AS num_status FROM laundry_orders GROUP BY status";
$result_count_status = mysqli_query($conn, $query_count_status);

// Check if query was successful and fetch the counts
if ($result_count_status) {
    while ($row_count_status = mysqli_fetch_assoc($result_count_status)) {
        $status = $row_count_status['status'];
        $count = $row_count_status['num_status'];

        // Update counts based on status
        switch ($status) {
            case 'Requested':
                $req_requested = $count;
                break;
            case 'Accepted':
                $req_received = $count;
                break;
            case 'In Process':
                $req_inprocess = $count;
                break;
            case 'Finished':
                $req_finished = $count;
                break;
            default:
                break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin_dashboard</title>
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
        <li class="nav-item active">
          <a class="nav-link" href="overall_bill.php"><i class="fas fa-barcode"></i> Bills</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="stats.php"><i class="fas fa-tachometer-alt"></i> Stats</a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="contact_admin.php"><i class="fas fa-book"></i> Contact Forms</a>
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

<div class="container" style="margin-top:50px">
<h2 style="text-align:center; margin-bottom:15px;">Order - Details</h2>
  <div class="row">
<div class="col-md-3">
  <div class="dashboard-box new-requests">
    <h3>New Requests</h3>
    <p class="count"><?php echo $req_requested; ?></p>
    <a href="update_request.php" class="details-btn" data-status="Requested">View Details</a>
  </div>
</div>

    <div class="col-md-3">
      <div class="dashboard-box accept">
        <h3>Accepted</h3>
        <p class="count"><?php echo $req_received; ?></p>
        <a href="update_accepted.php" class="details-btn" data-status="Requested">View Details</a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box in-process">
        <h3>In Process</h3>
        <p class="count"><?php echo $req_inprocess; ?></p>
        <a href="update_inprocess.php" class="details-btn" data-status="Requested">View Details</a>

      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box finish">
        <h3>Finished</h3>
        <p class="count"><?php echo $req_finished; ?></p>
        <a href="update_finish.php" class="details-btn" data-status="Requested">View Details</a>
      </div>
    </div>
  </div>
</div>

<section>
  <div class="container" style="background-color: rgba(225, 255, 245, 0.9); padding:20px; margin-top:30px; margin-bottom:30px;">
    <div class="row">
      <div class="col-md-12">
        <h3 style="text-align: center; margin-bottom: 20px; color: black;">Bills</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="left-content" style="display: flex; flex-direction: column; justify-content: center;">
          <h3 style="text-align: center; margin-bottom: 20px; color: black;">Additional Details</h3>
          <p style="color: black; text-align: justify;">Welcome to Overall bill payments platform! Here, you can quickly retrieve information on all orders and effortlessly 
          manage your bills. Review past purchases and stay updated on your spending. Our user-friendly interface allows for easy navigation, ensuring a hassle-free 
          experience. Securely make payments using various methods and set up reminders to never miss a due date. </p>
          
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-content">
          <h3 style="text-align: center; margin-bottom: 20px; color: black;">Your History</h3>
          <img src="../images/bill.webp" alt="Your GIF" style="width: 50%; height: auto; margin: 0 auto; display: block;">
          <a href="overall_bill.php" class="btn btn-primary mt-3" style="display: block; margin: 0 auto; width:150px; text-align: center;">History/Bills</a>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="footer mt-auto py-3" style="background-color: rgb(186,12,47); color: white;">
    <div class="container text-center">
        <span>NM laundry &copy; <?php echo date("Y"); ?></span>
    </div>
</footer>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
