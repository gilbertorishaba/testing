<?php
session_start();
require 'config.php'; // Ensure config.php is included

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password using password_verify
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id']; // Set user ID
            $_SESSION['fullname'] = $user['fullname']; // Set full name
            $_SESSION['user'] = $user; // Store user details in session

            // Redirect based on user role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'teacher':
                    header("Location: teacher_dashboard.php");
                    break;
                case 'student':
                    header("Location: student_dashboard.php");
                    break;
                default:
                    header("Location: index.php");
                    break;
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found.";
    }

    // Close statement
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Login -  LAITI-Cloud LMS</title>
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #4CAF50; 
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
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        .navbar-nav .nav-link {
            color: white;
            margin-right: 20px;
        }
        .navbar-nav .nav-link:hover {
            color: #f0f0f0;
        }
        
        /* Sliding banner styles */
        .carousel-item img {
            height: 400px;
            object-fit: cover;
            width: 100%;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }

        /* Login form styles */
        .login-container {
            margin-top: 30px;
            max-width: 400px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
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
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
        .login-footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }

    footer {
        padding-top: 30px;
        background-color: #333; /* Dark theme */
        color: #f0f0f0;
    }
    footer a {
        color: #f0f0f0;
        text-decoration: none;
    }
    footer a:hover {
        text-decoration: underline;
        color: #4CAF50;
    }
    .input-group .form-control {
        border-radius: 0;
        border-right: none;
    }
    .input-group .input-group-append .btn {
        border-radius: 0;
    }
    .fa-2x {
        margin-right: 15px;
    }

    /* Fixed top navigation */
    .navbar {
        background-color: #4CAF50; /* LMS theme color */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }
    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
        color: white;
    }
    .navbar-nav .nav-link {
        color: white;
        margin-right: 20px;
    }
    .navbar-nav .nav-link:hover, .navbar-nav .dropdown-item:hover {
        color: #f0f0f0;
        background-color: #45a049;
    }
    .dropdown-menu {
        background-color: #4CAF50;
        border: none;
    }
    .dropdown-item {
        color: white;
    }



    </style>
</head>
<body>

<<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/img3 (2).jpg" alt=" LAITI- LAITI-Cloud LMS " width="40" height="40">  LAITI-Cloud LMS
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
                        <a class="dropdown-item" href="about/whoweare.php">Who We Are</a>
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


<!-- Sliding Banner -->
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/img1 (2).jpg" class="d-block w-100" alt="First Slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Cloud-Based Learning</h5>
                <p>Access quality education anywhere, anytime.</p>
            </div>
        </div>

        <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/" class="d-block w-100" alt="Second Slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Cloud-Based Learning</h5>
                <p>Access quality education anywhere, anytime.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/img3 (2).jpg" class="d-block w-100" alt="Third Slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Interactive Courses</h5>
                <p>Engage with instructors and peers in real-time.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/img2 (2).jpg" class="d-block w-100" alt="FourthSlide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Advanced Learning Tools</h5>
                <p>Utilize cutting-edge resources to excel in your studies.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<!-- Hidden Login Form Section -->
<div class="container d-flex justify-content-center">
    <div class="login-container" id="loginForm" style="display:none;">
        <h2 class="text-center">Login to  LAITI-Cloud LMS</h2>
<!-- this enables me to track an error while submiting the form usually stored in the script  -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Email or Username</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email or username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>
            <div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
        </form>
        <div class="login-footer mt-3">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</div>

<!-- Access Section -->
<section class="container my-5">
    <h2 class="text-center mb-4">Accessing  LAITI-Cloud LMS</h2>
    <p class="text-center">
        Accessing our  LAITI-Cloud LMS is easy and convenient. Simply follow these steps:
    </p>
    <div class="row text-center">
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Step 1: Register</h5>
                    <p class="card-text">Create an account by filling out the registration form to gain access to our platform.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Step 2: Browse Courses</h5>
                    <p class="card-text">Explore our wide range of courses tailored to various subjects and skill levels.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Step 3: Enroll</h5>
                    <p class="card-text">Select your desired courses and enroll to start your learning journey.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Step 4: Learn Anytime, Anywhere</h5>
                    <p class="card-text">Access your courses anytime and anywhere with our cloud-based platform.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white mt-5 pt-4">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4">
                <h5>About  LAITI- LAITI-Cloud LMS</h5>
                <p>
                     LAITI- LAITI-Cloud LMS is a cutting-edge platform designed to provide quality education from the comfort of your home. We offer a range of interactive courses and advanced learning tools to help you succeed.
                </p>
                <p>
                    <a href="about_us.php" class="text-white">Learn more about us</a>
                </p>
            </div>
            <!-- Quick Links Section -->
            <div class="col-md-2">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-white">Home</a></li>
                    <li><a href="contact_us.php" class="text-white">Contact Us</a></li>
                    <li><a href="privacy_policy.php" class="text-white">Privacy Policy</a></li>
                    <li><a href="terms_conditions.php" class="text-white">Terms & Conditions</a></li>
                </ul>
            </div>
            <!-- Newsletter Section -->
            <div class="col-md-3">
                <h5>Newsletter</h5>
                <p>Stay updated with the latest news and offers from  LAITI- LAITI-Cloud LMS.</p>
                <form action="subscribe.php" method="POST">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Social Media Links Section -->
            <div class="col-md-3 text-center">
                <h5>Follow Us</h5>
                <a href="https://facebook.com" class="text-white"><i class="fab fa-facebook-f fa-2x mr-3"></i></a>
                <a href="https://twitter.com" class="text-white"><i class="fab fa-twitter fa-2x mr-3"></i></a>
                <a href="https://instagram.com" class="text-white"><i class="fab fa-instagram fa-2x"></i></a>
            </div>
        </div>
        <!-- Bottom Footer Section -->
        <div class="row mt-4">
            <div class="col text-center">
                <p class="mb-0">&copy; 2024  LAITI-Cloud LMS. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- CSS for Footer -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    document.getElementById('loginButton').onclick = function() {
        var loginForm = document.getElementById('loginForm');
        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
        } else {
            loginForm.style.display = 'none';
        }
    };

    //javascript for sliding the images 
    
</script>

</body>
</html>