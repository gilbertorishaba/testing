<?php
session_start();
require 'config.php'; // Ensure config.php is included

// Check if user is logged in and has the admin role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php"); // Only admin can access this page
    exit();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = $_POST['teacher_id']; // Assuming you have a dropdown for selecting teachers

    // Secure the SQL query to avoid SQL injection
    $title = $conn->real_escape_string($title);
    $description = $conn->real_escape_string($description);
    $teacher_id = (int)$teacher_id; // Convert to integer

    // Insert the new course into the database
    $sql = "INSERT INTO courses (title, description, teacher_id) VALUES ('$title', '$description', $teacher_id)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Course added successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Course - LMS</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            padding: 20px;
            border-radius: 8px;
            background: white; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff; 
            text-align: center;
        }
        .form-group label {
            font-weight: bold;
            color: #495057; 
        }
        .form-control {
            border-radius: 5px; 
            border: 1px solid #ced4da;
            transition: border-color 0.3s; 
        }
        .form-control:focus {
            border-color: #007bff; 
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
        }
        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded button */
            padding: 10px 20px; /* Add padding to button */
            font-size: 16px; /* Increase font size */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade on hover */
            cursor: pointer; /* Pointer cursor on hover */
        }
        /* Add responsiveness */
        @media (max-width: 576px) {
            .container {
                margin: 20px; /* Less margin on small screens */
                padding: 15px; /* Less padding on small screens */
            }
            h1 {
                font-size: 1.5rem; /* Smaller heading on small screens */
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Include the navbar here -->

    <div class="container mt-5">
        <h1 class="mb-4">Add New Course</h1>
        <form method="POST" action="add_course.php">
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
                    // Fetch teachers from the database
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
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>
    </div>
</body>
</html>
