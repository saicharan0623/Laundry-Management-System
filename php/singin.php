
<?php
$error = isset($_GET['error']) ? $_GET['error'] : ''; // Retrieve the error parameter from the URL
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - user</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
           body {
            color: black; 
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

        .login-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 350px;
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            animation: fadeIn 0.5s ease forwards; 
            opacity: 0; 
        }

        .login-container h2 {
            color: rgb(186,12,47);
            text-align: center;
        }

        .login-container .form-group label {
            color: rgb(186,12,47);
        }

        .login-container .btn-primary {
            background-color: rgb(186,12,47); 
            border-color: rgb(186,12,47); 
        }

        .login-container .btn-primary:hover {
            background-color: rgb(156,2,37); 
            border-color: rgb(156,2,37); 
        }

        @media (max-width: 576px) {
            .login-container {
                width: 90%;
            }
        }

        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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
    <div class="container login-container">
        <h2 class="text-center mb-4">Login</h2>
        
        <form method="POST" action="signin_validate.php">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="emails" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="passwords">
            </div>
            <?php if (!empty($error)) : ?> 
        <div class="alert alert-danger" role="alert"> 
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="text-center mt-3">
                <a href="reset.php" style="color: rgb(186,12,47);">Forgot Password?</a>
            </div>
            <div class="text-center mt-3">
                <p>Not a member? <a href="signup.php" style="color: rgb(186,12,47);">Sign Up</a></p>
            </div>
        </form>
    </div>
    <a href="../index.html" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>
</body>
</html>
