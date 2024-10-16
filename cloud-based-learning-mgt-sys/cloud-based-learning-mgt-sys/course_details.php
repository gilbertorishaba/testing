<?php
session_start();
require 'config.php'; // Ensure config.php is included

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $course_id = (int)$_GET['id'];

    // Fetch course details from the database using the course_id
    $sql = "SELECT * FROM courses WHERE id = $course_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        echo "Course not found.";
        exit();
    }
} else {
    echo "Course ID is missing.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Course Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for contrast */
        }
        .navbar {
            background-color: #28a745; /* Green navbar */
        }
        .footer {
            background-color: #343a40; /* Dark footer */
        }
        .course-details {
            background-color: #ffffff; /* White background for content */
            padding: 20px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        h3 {
            margin-top: 20px; /* Space above section headers */
        }
        .btn-primary {
            background-color: #007bff; /* Customize primary button color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker on hover */
            border-color: #0056b3;
        }
        .social-icons a {
            color: white; /* White icons */
            margin: 0 10px; /* Space between icons */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">LAITI Cloud LMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Teachers</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="about.php">About Us</a>
                        <a class="dropdown-item" href="contact.php">Contact</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="faq.php">FAQ</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="course-details">
            <h1><?php echo htmlspecialchars($course['title']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
            <p><strong>Teacher ID:</strong> <?php echo htmlspecialchars($course['teacher_id']); ?></p>

            <h3>Links</h3>
            <ul>
                <?php
                $links = explode(',', $course['links']);
                foreach ($links as $link) {
                    echo "<li><a href='" . htmlspecialchars(trim($link)) . "' target='_blank'>" . htmlspecialchars(trim($link)) . "</a></li>";
                }
                ?>
            </ul>

            <h3>Assignments</h3>
            <ul>
                <?php
                $assignments = explode(',', $course['assignments']);
                foreach ($assignments as $assignment) {
                    echo "<li>" . htmlspecialchars(trim($assignment)) . "</li>";
                }
                ?>
            </ul>

            <h3>Videos</h3>
            <ul>
                <?php
                $videos = explode(',', $course['videos']);
                foreach ($videos as $video) {
                    echo "<li><a href='" . htmlspecialchars(trim($video)) . "' target='_blank'>" . htmlspecialchars(trim($video)) . "</a></li>";
                }
                ?>
            </ul>

            <a href="index.php" class="btn btn-primary">Back to Courses</a>
        </div>
    </div>

     <!-- Footer -->
<footer class="bg-dark text-white mt-5 pt-4">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4">
                <h5>About Cloud LMS</h5>
                <p>
                    Cloud LMS is a cutting-edge platform designed to provide quality education from the comfort of your home. We offer a range of interactive courses and advanced learning tools to help you succeed.
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
                <p>Stay updated with the latest news and offers from Cloud LMS.</p>
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
                <p class="mb-0">&copy; 2024 Cloud LMS. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
