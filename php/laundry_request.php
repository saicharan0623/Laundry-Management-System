<?php
require_once 'db_config.php';
require_once 'session.php';
$email = $_SESSION['email'];

$query = "SELECT full_name, mobile_no, gender FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $full_name = $row['full_name'];
    $mobile_number = $row['mobile_no'];
    $gender = $row['gender'];
} else {
    // Handle error if no data found or query fails
    $full_name = "";
    $mobile_number = "";
    $gender = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laundry Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .background-container {
      position: fixed;
      width: 100%;
      height: 100%;
      background-image: url('../images/2.png'); /* Replace with your image path */
      background-size: cover;
      background-position: center;
      z-index: -1;
    }

    .form-container {
      position: relative;
      z-index: 1;
      background-color: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      text-align: center;
      animation: fadeIn 0.5s ease;
      margin-top: 200px;
      margin-bottom: 40px;
 
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      margin-bottom: 20px;
      color: rgb(186, 12, 47);
      font-size: 32px;
    }

    .btn-custom {
      background-color: rgb(186, 12, 47);
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #b80c3a;
    }

    .not-member {
      margin-top: 10px;
      color: rgb(44, 42, 41);
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
<div class="background-container"></div>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="form-container">
        <form method="POST" action="laundry_bill.php" class="laundry-form">
          <h2>Laundry Service</h2>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              <label for="full_name">Name</label>
                <input type="text" class="form-control" placeholder="Full Name" name="full_name" id="full_name" value="<?php echo $full_name; ?>" required readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label for="date">Gender:</label>
                <input type="text" class="form-control" name="gender" id="gender" value="<?php echo $gender; ?>" required readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              <label for="mobile_no">Mobile Number:</label>
                <input type="tel" class="form-control" placeholder="Mobile Number" name="mobile_no" id="mobile_no" value="<?php echo $mobile_number; ?>" readonly required>
              </div>
            </div>
        </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="date">Order Date:</label>
                <input type="date" class="form-control" name="date" id="date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="room_no">Room Number:</label>
                <input type="text" class="form-control" placeholder="Room Number" name="room_no" id="room_no" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="top_wear">Number of Top Wear:</label>
                <input type="number" class="form-control" placeholder="Number of Top Wear" name="top_wear" id="top_wear" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="bottom_wear">Number of Bottom Wear:</label>
                <input type="number" class="form-control" placeholder="Number of Bottom Wear" name="bottom_wear" id="bottom_wear" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="other_cloths">Other Cloths:</label>
                <input type="number" class="form-control" placeholder="Number of other cloths" name="other_cloths" id="other_cloths" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="dry_cleaning">Dry Cleaning:</label>
                <input type="number" class="form-control" placeholder="Dry Cleaning" name="dry_cleaning" id="dry_cleaning" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="others">Any other instructions?</label>
            <textarea class="form-control" placeholder="Any other instructions?" name="others" id="others"></textarea>
          </div>
          <div class="form-group">
            <label for="service_type">Service Type:</label>
            <select class="form-control" name="service_type" id="service_type" required>
              <option value="">Select Service Type</option>
              <option value="Wash and Iron">Wash and Iron</option>
              <option value="Only Wash">Only Wash</option>
              <option value="Color Press">Color Press</option>
              <option value="Only Iron">Only Iron</option>
            </select>
          </div>
          <button type="submit" class="btn btn-custom">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<a href="student_dashboard.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>
</body>
</html>
