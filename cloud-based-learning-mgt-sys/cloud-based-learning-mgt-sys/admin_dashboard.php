<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_course') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = (int)$_POST['teacher_id'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO courses (title, description, teacher_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $teacher_id);

    if ($stmt->execute()) {
        echo "<script>alert('Course added successfully!');</script>";
    } else {
        echo "<script>alert('Error: Unable to add course. Please try again.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css"> <!-- Custom CSS for further styling -->
    <title>LAITI Cloud LMS</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        h1, h3 {
            color: #343a40;
        }
        .navbar {
            background-color: #28a745;
        }
        .navbar .nav-link {
            color: white;
            margin-right: 20px;
            transition: color 0.3s ease;
        }
        .navbar .nav-link:hover {
            color: #cce7cc;
        }
        .navbar-brand {
            font-weight: bold;
            color: white;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: bold;
            color: #495057;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
            margin-top: 40px;
        }
        footer a {
            color: #cce7cc;
            transition: color 0.3s ease;
        }
        footer a:hover {
            color: white;
        }
        .social-icons a {
            margin-right: 15px;
            color: white;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        .social-icons a:hover {
            color: #cce7cc;
        }

        footer {
    background-color: #343a40;
    color: white;
    padding: 40px 0;
    margin-top: 40px;
    width: 100%; /* Ensures footer takes full width */
    position: relative; /* Allows it to sit correctly at the bottom */
}

    </style>
    <script>
        function toggleForm(formId) {
            const form = document.getElementById(formId);
            const isHidden = form.style.display === 'none' || form.style.display === '';
            form.style.display = isHidden ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">LAITI Cloud LMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="toggleForm('courseForm')">Add Course</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="toggleForm('teacherForm')">Add Teacher</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Available Courses</h1>

        <!-- Add Course Form -->
        <div id="courseForm" class="form-container" style="display: none;">
            <h3 class="text-center">Add New Course</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_course">
                <div class="form-group">
                    <label for="title">Course Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Course Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="teacher_id">Select Teacher</label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <option value="">Select Teacher</option>
                        <?php
                        $sql = "SELECT id, fullname FROM users WHERE role = 'teacher'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['fullname']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Course</button>
            </form>
        </div>

        <!-- Teacher Addition Form -->
        <div id="teacherForm" class="form-container" style="display: none;">
            <h3 class="text-center">Add New Teacher</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_teacher">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Teacher</button>
            </form>
        </div>

        <?php
        $courses_sql = "SELECT id, title, description, image FROM courses";
        $courses_result = $conn->query($courses_sql);

        if ($courses_result->num_rows > 0) {
            while ($course = $courses_result->fetch_assoc()) {
                echo "
                <div class='col-md-3 mb-4'>
                    <div class='card'>
                        <img src='{$course['image']}' class='card-img-top' alt='{$course['title']}'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$course['title']}</h5>
                            <p class='card-text'>{$course['description']}</p>
                            <a href='course_details.php?id={$course['id']}' class='btn btn-outline-primary'>View Details</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }
        ?>

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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
