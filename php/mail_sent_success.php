<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Sent</title>
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
            z-index: -1; 
        }

        .success-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 350px;
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            animation: fadeIn 0.5s ease forwards; /* Apply fade-in animation */
            opacity: 0; /* Start with 0 opacity */
            text-align: center;
        }

        .success-container h2 {
            color: rgb(186,12,47); /* Heading color */
            text-align: center;
        }

        .success-container .message {
            margin-bottom: 20px;
        }

        .success-container .btn-primary {
            background-color: rgb(186,12,47); /* Button background color */
            border-color: rgb(186,12,47); /* Button border color */
        }

        .success-container .btn-primary:hover {
            background-color: rgb(156,2,37); /* Button background color on hover */
            border-color: rgb(156,2,37); /* Button border color on hover */
        }

        @media (max-width: 576px) {
            .success-container {
                width: 90%;
            }
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
    <div class="background-container"></div>

    <div id="success-container" class="container success-container">
        <h2>Mail Sent Successfully</h2>
        <h3 class="message">Check Your Inbox</h3>
        <p class="message">Thank You</p>

    </div>
    <div id="loading" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <img src="../images/mail.gif" alt="Loading..." style="width: 100%; height:auto;">
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('success-container').style.display = 'block';
            document.getElementById('loading').style.display = 'none'; 
        }, 1500);
    </script>
</body>
</html>
