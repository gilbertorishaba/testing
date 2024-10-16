<?php
require 'config.php'; //  config.php is included here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure the SQL query to avoid SQL injection
    $email = $conn->real_escape_string($email);

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Register -  LAITI-Cloud LMS</title>
    <style>
        body {
            background-image: url('images/uni.jpg');
            background-size: cover; 
            background-position: center; 
            font-family: 'Arial', sans-serif;
            color: white; 
        }
        .register-container {
            margin-top: 100px; 
            max-width: 500px;
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            margin-bottom: 20px;
            color: #4CAF50; 
        }
        .form-control {
            border-radius: 50px;
            padding: 10px 15px;
        }
        .btn-primary {
            width: 100%;
            border-radius: 50px;
            padding: 10px 15px;
            background-color: #4CAF50;
            border: none;
        }
        .btn-primary:hover {
            background-color: #45a049;
        }
        .register-footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
        .register-footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .register-footer a:hover {
            text-decoration: underline;
        }

        <style>
    body {
        background-image: url('images/uni.jfif');
        background-size: cover; 
        background-position: center; 
        font-family: 'Arial', sans-serif;
      
    }

    /* Navigation Bar Styles */
    nav.navbar {
        background-color: #28a745;
        border-bottom: 2px solid #4CAF50; 
    }

    nav.navbar .navbar-brand {
        color: #4CAF50; 
    }

    nav.navbar .navbar-brand img {
        margin-right: 10px;
    }

    nav.navbar .navbar-nav .nav-link {
        color: black; 
        transition: color 0.3s; 
        font-weight: bold;
    }

    nav.navbar .navbar-nav .nav-link:hover {
        background-color:rgba(255, 255, 200,0); 
    }

    .register-container {
        margin-top: 100px;
        max-width: 500px;
        background-color: rgba(255, 255, 255, 0.9); 
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .register-container h2 {
        margin-bottom: 20px;
        color: #4CAF50; 
    }

    .form-control {
        border-radius: 50px;
        padding: 10px 15px;
    }

    .btn-primary {
        width: 100%;
        border-radius: 50px;
        padding: 10px 15px;
        background-color: #4CAF50;
        border: none;
    }

    .btn-primary:hover {
        background-color: #45a049;
    }

    .register-footer {
        text-align: center;
        margin-top: 20px;
        color: #888;
    }

    .register-footer a {
        color: #4CAF50;
        text-decoration: none;
    }

    .register-footer a:hover {
        text-decoration: underline;
    }

    <style>
    body {
        background-image: url('images/uni.jfif');
        background-size: cover; 
        background-position: center; 
        font-family: 'Arial', sans-serif;
    }

    /* Navigation Bar Styles */
    nav.navbar {
        background-color: #28a745;
        border-bottom: 2px solid #4CAF50; 
    }

    nav.navbar .navbar-brand {
        color: #000; /
    }

    .navbar-brand img {
            border-radius: 50%; 
            margin-right: 10px; 
            width: 40px; 
            height: 40px;
            transition: transform 0.3s; 
        }


        .navbar-brand:hover img {
            transform: scale(1.1); 
        }

    nav.navbar .navbar-brand img {
        margin-right: 10px;
        background-color: #000; 
    }

    nav.navbar .navbar-nav .nav-link {
        color: #000;
        transition: color 0.3s; 
    }

    .register-container {
        margin-top: 100px;
        max-width: 500px;
        background-color: rgba(255, 255, 255, 0.9); 
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .register-container h2 {
        margin-bottom: 20px;
        color: #4CAF50; 
    }

    .form-group label {
        color: #000; 
    }

    .form-control {
        border-radius: 50px;
        padding: 10px 15px;
    }

    .btn-primary {
        width: 100%;
        border-radius: 50px;
        padding: 10px 15px;
        background-color: #4CAF50;
        border: none;
    }

    .btn-primary:hover {
        background-color: #45a049;
    }

    .register-footer {
        text-align: center;
        margin-top: 20px;
        color: #888;
    }

    .register-footer a {
        color: #4CAF50;
        text-decoration: none;
    }

    .register-footer a:hover {
        text-decoration: underline;
    }
</style>

</style>

    </style>
</head>
<body>
<<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/img3 (2).jpg" alt=" LAITI LMS  " width="40" height="40">LAITI-Cloud LMS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        About Us
                    </a>
                    <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <a class="dropdown-item" href="#">Who We Are</a>
                        <a class="dropdown-item" href="#">Our Mission</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
                <li class="nav-item">
                 <button type="submit" class="btn btn-primary" id="loginButton">Login</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container d-flex justify-content-center">
        <div class="register-container">
            <h2 class="text-center">Register for  LAITI-Cloud LMS</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" name="fullname" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Create a password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <div class="register-footer mt-3">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About LAITI- LAITI-Cloud LMS</h5>
                    <p> LAITI- LAITI-Cloud LMS is a cutting-edge platform designed to provide quality education from the comfort of your home. We offer a range of interactive courses and advanced learning tools to help you succeed.</p>
                    <p><a href="about_us.php" class="text-white">Learn more about us</a></p>
                </div>
                <div class="col-md-2">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Home</a></li>
                        <li><a href="contact_us.php" class="text-white">Contact Us</a></li>
                        <li><a href="privacy_policy.php" class="text-white">Privacy Policy</a></li>
                        <li><a href="terms_conditions.php" class="text-white">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Newsletter</h5>
                    <p>Stay updated with the latest news and offers from  LAITI-Cloud LMS.</p>
                    <form action="subscribe.php" method="POST">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 text-center">
                    <h5>Follow Us</h5>
                    <a href="https://facebook.com" class="text-white"><i class="fab fa-facebook-f fa-2x mr-3"></i></a>
                    <a href="https://twitter.com" class="text-white"><i class="fab fa-twitter fa-2x mr-3"></i></a>
                    <a href="https://instagram.com" class="text-white"><i class="fab fa-instagram fa-2x"></i></a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <p class="mb-0">&copy; 2024 LAITI- LAITI-Cloud LMS. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
