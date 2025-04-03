<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url("../images/2.png");
      margin: 0;
      padding: 0;
      background-size: cover;
      background-repeat: no-repeat;
    }

    header {
      background-color: rgb(186, 12, 47);
      color: white;
      padding: 0px 0;
      text-align: center;
    }
    .navbar-custom {
      background-color: rgb(186, 12, 47);
    }

    .navbar-custom .navbar-brand {
      color: white;
      margin-right: 2rem;
    }

    .navbar-custom .navbar-nav .nav-link {
      color: white;
    }

    .navbar-custom .navbar-toggler-icon {
      background-color:  rgb(186, 12, 47);
    }

    .navbar-custom .dropdown-menu .dropdown-item:hover {
      background-color: rgb(186, 12, 47);
      color: azure;
    }

    table {
      width: 80%;
      margin: 20px auto;
      border-collapse: collapse;
    }

    caption {
      text-align: center;
      font-weight: bold;
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: rgb(186, 12, 47);
      color: white;
    }

    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tbody tr:hover {
      background-color: #f2f2f2;
    }

    td:first-child {
      text-align: center;
    }

    td:last-child {
      text-align: right;
    }

    h1 {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .services {
            list-style: none;
            padding: 0;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .service {
            width: 300px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .service img {
            max-width: 100%;
            border-radius: 5px;
        }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
      <div class="container">
        <a class="navbar-brand" href="#">Nmims - Laundry</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="../index.html"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="prices.php"><i class="fas fa-info-circle"></i> Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="services.php"><i class="fas fa-circle"></i> Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php"><i class="fas fa-address-book"></i> Contact</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i> Login/Signup
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="singin.php"><i class="fas fa-user"></i> User</a>
                <a class="dropdown-item" href="admin_signin.php"><i class="fas fa-user-shield"></i> Admin</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="container">
        <h1>Our Services</h1>
        <ul class="services">
            <li class="service">
                <img src="../images/mach.jpg" alt="Washing Service">
                <h2>Washing</h2>
                <p>Expert washing services for your clothes.</p>
            </li>
            <li class="service">
                <img src="../images/iron.webp" alt="Ironing Service">
                <h2>Ironing</h2>
                <p>Professional ironing to make your clothes crisp.</p>
            </li>
            <li class="service">
                <img src="../images/dry.webp" alt="Dry Cleaning Service">
                <h2>Dry Cleaning</h2>
                <p>Specialized dry cleaning for delicate fabrics.</p>
            </li>
        </ul>
    </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</body>
</html>