<?php
session_start();
require '../config.php'; // Adjusted path for the configuration file

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Set course ID for CS50 (Assuming ID is 1)
$course_id = 1;

$sql = "SELECT * FROM courses WHERE id = $course_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<h1>Course not found</h1>";
    exit();
}

$course = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $course['title']; ?> - Course Details</title>
</head>
<body>
    <?php include '../header.php'; ?> <!-- Adjusted path for the header -->

    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $course['title']; ?></h1>
        <p><strong>Description:</strong> <?php echo $course['description']; ?></p>
        
        <h3>Course Notes</h3>
        <ul>
            <li>CS50 is Harvard University's introduction to the intellectual enterprises of computer science and the art of programming.</li>
            <li>This course teaches students how to think algorithmically and solve problems efficiently.</li>
            <li>Topics covered include algorithms, data structures, software engineering, and web development.</li>
            <li>Students will learn languages such as C, Python, and JavaScript, along with HTML and CSS.</li>
            <li>Practical projects allow students to apply concepts to real-world applications.</li>
        </ul>

        <h3>Course Resources</h3>
        <ul>
            <li><a href="https://cs50.harvard.edu/college/2023/fall/" target="_blank">CS50 Course Website</a></li>
            <li><a href="https://cs50.harvard.edu/college/2023/fall/notes/" target="_blank">Lecture Notes</a></li>
            <li><a href="https://cs50.harvard.edu/college/2023/fall/assignments/" target="_blank">Assignments</a></li>
        </ul>
    </div>

    <footer class="text-center mt-5 py-4">
        <div class="container">
            <p class="text-muted">© 2024 Cloud LMS. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
