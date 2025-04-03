<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
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
            background-image: url('../images/2.png');
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
      margin-top: 20px;
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
  </style>
</head>
<body>
<div class="background-container"></div> 
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="form-container">
        <form method="POST" action="signup_validate.php" class="signup-form">
          <h2>Sign Up</h2>
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" placeholder="SAP ID" name="sap_id" required>
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" placeholder="Full Name" name="full_name" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <select class="form-control" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <select class="form-control" name="school" required>
                <option value="">Select School</option>
                <option value="STME">STME</option>
                <option value="SPTM">SPTM</option>
                <option value="SBM">SBM</option>
                <option value="SOL">SOL</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <input type="tel" class="form-control" placeholder="Mobile Number" name="mobile_no" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email ID" name="email" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-custom">Create Account</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>