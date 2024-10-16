<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>About Us - Cloud LMS</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .hero {
            background-image: url('images/std1.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .hero h1 {
            font-size: 48px;
            font-weight: bold;
        }
        .hero p {
            font-size: 24px;
            margin-top: 10px;
        }
        .section {
            padding: 60px 0;
        }
        .section h2 {
            margin-bottom: 30px;
            color: #4CAF50;
            text-align: center;
        }
        .about-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }
        .team-member img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-bottom: 10px;
        }
        .testimonials {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .testimonials p {
            font-style: italic;
            text-align: center;
        }
        .cta {
            text-align: center;
            padding: 40px 0;
        }
        .cta a {
            font-size: 18px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #4CAF50;">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/img3 (2).jpg" alt=" LAITI-Cloud LMS " width="40" height="40"> Cloud LMS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
                    <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <a class="dropdown-item" href="about/whoweare.php">Who We Are</a>
                        <a class="dropdown-item" href="#">Our Mission</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                <li class="nav-item"><button type="submit" class="btn btn-primary" id="loginButton">Login</button></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <div>
        <h1>Welcome to LAITI-Cloud LMS</h1>
        <p>Empowering Education Through Innovation</p>
    </div>
</div>

<!-- About Section -->
<div class="section">
    <div class="about-container">
        <h2>About Us</h2>
        <p>At <strong>Cloud LMS</strong>, we are committed to transforming education through innovative technology. Our platform is designed for learners of all ages, offering an accessible and interactive learning environment.</p>
        <h4>Why Choose LAITI-Cloud LMS?</h4>
        <ul>
            <li><strong>Cutting-Edge Technology:</strong> Utilizing the latest advancements in e-learning technology.</li>
            <li><strong>Personalized Learning:</strong> Adapting to your learning needs with recommendations and progress tracking.</li>
            <li><strong>Expert Instructors:</strong> Learn from industry professionals dedicated to your success.</li>
        </ul>
    </div>
</div>

<!-- Team Section -->
<div class="section">
    <h2>Meet Our Team</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-4 team-member">
                <img src="images/std1.jpg" alt="Team Member 1">
                <h5>Gilbert Orishaba</h5>
                <p>CEO & Founder</p>
            </div>
            <div class="col-md-4 team-member">
                <img src="images/std2.jpg" alt="Team Member 2">
                <h5>Jane Smith</h5>
                <p>CTO</p>
            </div>
            <div class="col-md-4 team-member">
                <img src="images/std3.jpg" alt="Team Member 3">
                <h5>Emily Johnson</h5>
                <p>COO</p>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="section testimonials">
    <h2>What Our Users Say</h2>
    <p>"Cloud LMS has changed the way I learn. The platform is intuitive, and the courses are highly engaging!"</p>
    <p>- Sarah Lee, Student</p>
</div>

<!-- Call to Action Section -->
<div class="section cta">
    <h2>Join Us Today!</h2>
    <p>Experience the future of education with <strong> LAITI-Cloud LMS</strong>. <a href="register.php">Sign up now</a> and take the first step towards achieving your educational goals!</p>
</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-5 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>About Cloud LMS</h5>
                <p>Cloud LMS is a cutting-edge platform designed to provide quality education from the comfort of your home.</p>
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
                <p>Subscribe to our newsletter for the latest updates.</p>
                <form>
                    <input type="email" class="form-control" placeholder="Email address" required>
                    <button type="submit" class="btn btn-primary mt-2">Subscribe</button>
                </form>
            </div>
            <div class="col-md-3">
                <h5>Follow Us</h5>
                <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white ml-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white ml-2"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
        <div class="text-center py-3">
            <p>&copy; 2024 LAITI-Cloud LMS. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
