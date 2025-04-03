<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            color: black; /* Text color */
        }

        .background-container {
            position: fixed;
            width: 100%;
            height: 100%;
            background-image: url('../images/2.png');
            background-size: cover;
            background-position: center;
            z-index: -1; /* Send it behind other elements */
        }

        .forgot-password-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 350px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a shadow effect */
            animation: fadeIn 0.5s ease forwards; /* Apply fade-in animation */
            opacity: 0; /* Start with 0 opacity */
        }

        .forgot-password-container h2 {
            color: rgb(186,12,47); /* Heading color */
            text-align: center;
        }

        .forgot-password-container .form-group label {
            color: rgb(186,12,47); /* Label color */
        }

        .forgot-password-container .btn-primary {
            background-color: rgb(186,12,47); /* Button background color */
            border-color: rgb(186,12,47); /* Button border color */
        }

        .forgot-password-container .btn-primary:hover {
            background-color: rgb(156,2,37); /* Button background color on hover */
            border-color: rgb(156,2,37); /* Button border color on hover */
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="background-container"></div> <!-- Background overlay -->

    <div class="container forgot-password-container">
        <h2 class="text-center mb-4">Forgot Password</h2>
        <form action="reset_validate.php" method="post">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter your email">
            </div>
            <button type="submit" name="reset" class="btn btn-primary btn-block">Send Mail</button>
        </form>
    </div>
</body>
</html>
