<?php
require_once 'db_config.php';

require_once 'session.php';

$email = $_SESSION['email'];


$query_email_to_mobile = "SELECT mobile_no,full_name FROM users WHERE email='$email'";
$result_email_to_mobile = mysqli_query($conn, $query_email_to_mobile);

$req_requested = 0;
$req_received = 0;
$req_inprocess = 0;
$req_finished = 0;

if ($result_email_to_mobile && mysqli_num_rows($result_email_to_mobile) > 0) {
    $row_email_to_mobile = mysqli_fetch_assoc($result_email_to_mobile);
    $mobile_number = $row_email_to_mobile['mobile_no'];
    $name = $row_email_to_mobile['full_name'];

    $query_count_requested = "SELECT COUNT(*) AS num_requested FROM laundry_orders WHERE mobile_no='$mobile_number' AND status='Requested'";
    $result_count_requested = mysqli_query($conn, $query_count_requested);

    $query_count_received = "SELECT COUNT(*) AS num_received FROM laundry_orders WHERE mobile_no='$mobile_number' AND status='Accepted'";
    $result_count_received = mysqli_query($conn, $query_count_received);

    $query_count_inprocess = "SELECT COUNT(*) AS num_inprocess FROM laundry_orders WHERE mobile_no='$mobile_number' AND status='In Process'";
    $result_count_inprocess = mysqli_query($conn, $query_count_inprocess);

    $query_count_finished = "SELECT COUNT(*) AS num_finished FROM laundry_orders WHERE mobile_no='$mobile_number' AND status='Finished'";
    $result_count_finished = mysqli_query($conn, $query_count_finished);

    if ($result_count_requested) {
        $row_count_requested = mysqli_fetch_assoc($result_count_requested);
        $req_requested = $row_count_requested['num_requested'];
    }

    if ($result_count_received) {
        $row_count_received = mysqli_fetch_assoc($result_count_received);
        $req_received = $row_count_received['num_received'];
    }

    if ($result_count_inprocess) {
        $row_count_inprocess = mysqli_fetch_assoc($result_count_inprocess);
        $req_inprocess = $row_count_inprocess['num_inprocess'];
    }

    if ($result_count_finished) {
        $row_count_finished = mysqli_fetch_assoc($result_count_finished);
        $req_finished = $row_count_finished['num_finished'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>student_dashboard</title>
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
          <a class="nav-link" href="student_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="laundry_request.php"><i class="fas fa-shopping-cart"></i> Laundry Request</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bills_history.php"><i class="fas fa-tasks"></i> History/Bills</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> Profile
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="singin.php"><i class="fas fa-arrow-left"></i> logout</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top:50px">
          <h4 style="color: black; margin-top: 1rem; margin-left: 1rem; text-align:center; font-size:1.5rem; margin-bottom:15px;">Welcome, <?php echo $name; ?></h4>
  <div class="row">
    <div class="col-md-3">
      <div class="dashboard-box new-requests">
        <h3>New Requests</h3>
        <p class="count"><?php echo $req_requested; ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box accept">
        <h3>Accepted</h3>
        <p class="count"><?php echo $req_received; ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box in-process">
        <h3>In Process</h3>
        <p class="count"><?php echo $req_inprocess; ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box finish">
        <h3>Finished</h3>
        <p class="count"><?php echo $req_finished; ?></p>
      </div>
    </div>
  </div>
</div>

<section>
  <div class="container" style="background-color: rgba(225, 255, 245, 0.5); height:fit-content; max-width:1115px; padding:20px;">
    <div class="row">
      <div class="col-md-6">
        <div class="left-content" style="display: flex; flex-direction: column; justify-content: center;">
          <h3 style="text-align: center; margin-bottom:20px; color:black;">Add Your Request</h3>
          <img src="../images/laundry08.gif" alt="Your GIF" style="width: 50%; height: auto; margin: 0 auto;">
          <a href="laundry_request.php" class="btn btn-primary mt-3" style="display: block; margin: 0 auto;">Add Here to Wash</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-content">
          <h5 style="color:black; margin-top:20px;">Prices of Each Unit</h5>
          <table class="table">
            <thead style="color:black;">
              <tr>
                <th>Item</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody style="color:black;">
              <tr>
                <td>Shirt</td>
                <td>&#8377; 8 - Wash</td>
              </tr>
              <tr>
                <td>Pant</td>
                <td>&#8377; 8 - Wash</td>
              </tr>
              <tr>
                <td>Shirt</td>
                <td>&#8377; 7 - Iron</td>
              </tr>
              <tr>
                <td>Jeans</td>
                <td>&#8377; 7 - Iron</td>
              </tr>
              <tr>
                <td>Bedsheet</td>
                <td>&#8377; 25 - Wash</td>
              </tr>
              <tr>
                <td>Towel</td>
                <td>&#8377; 10 - Wash</td>
              </tr>
              <tr>
                <td>Blazzer</td>
                <td>&#8377; 100 - Dry cleaning</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container" style="background-color: rgba(225, 255, 245, 0.5); padding:20px; margin-top:30px; margin-bottom:30px;">
    <div class="row">
      <div class="col-md-12">
        <h3 style="text-align: center; margin-bottom: 20px; color: black;">Bills/History</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="left-content" style="display: flex; flex-direction: column; justify-content: center;">
          <h3 style="text-align: center; margin-bottom: 20px; color: black;">Additional Details</h3>
          <p style="color: black; text-align: justify;">Welcome to our order details and bill payments platform! Here, you can quickly retrieve information on previous orders and effortlessly 
          manage your bills. Review past purchases, track delivery statuses, and stay updated on your spending. Our user-friendly interface allows for easy navigation, ensuring a hassle-free 
          experience. Securely make payments using various methods and set up reminders to never miss a due date. </p>
          <p style="color: black; text-align: justify;"><strong>Note:</strong>Onces your order finishes update your out date.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-content">
          <h3 style="text-align: center; margin-bottom: 20px; color: black;">Your History</h3>
          <img src="../images/bill.webp" alt="Your GIF" style="width: 60%; height: auto; margin: 0 auto; display: block;">
          <a href="bills_history.php" class="btn btn-primary mt-3" style="display: block; margin: 0 auto; width:150px; text-align: center;">History/Bills</a>
        </div>
      </div>
    </div>
  </div>
  
  <section>
  <div class="container" style="background-color: rgba(225, 255, 245, 0.5); padding: 20px; margin-top: 30px;margin-bottom:30px;">
    <div class="row">
      <div class="col-md-12">
        <h3 style="text-align: center; margin-bottom: 20px; color: black;">Monthly Laundry Coupon</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="right-content">
          <h4 style="text-align: center; margin-bottom: 20px; color: black;">Buy Now</h4>
          <img src="../images/2000.gif" alt="Monthly Coupon" style="width: 50%; height: auto; margin: 0 auto; display: block;">
          <a href="coming_soon.php" class="btn btn-primary mt-3" style="display: block; margin: 0 auto; width: 150px; text-align: center;">Buy Coupon</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="left-content" style="display: flex; flex-direction: column; justify-content: center;">
          <h4 style="text-align: center; margin-bottom: 20px; color: black;">Get Your Monthly Laundry Coupon Now!</h4>
          <p style="text-align: center; color: black;">Purchase a monthly coupon to avail discounted laundry services for an entire month.</p>
          <p style="text-align: center; color: black;">Enjoy hassle-free laundry with our monthly subscription.</p>
          <p style="text-align: center; color: black;">With this coupon, you can get unlimited washing and ironing services for one month.</p>
          <p style="text-align: center; color: black;">After one month, the coupon will expire, and you can purchase a new one to continue enjoying the benefits.</p>
        </div>
      </div>
    </div>
  </div>
</section>



</section>
<footer class="footer mt-auto py-3" style="background-color: rgb(186,12,47); color: white;">
    <div class="container text-center">
        <span>NM laundry &copy; <?php echo date("Y"); ?></span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
