<?php
// Assuming you already have a database connection established in your config file
include 'config.php'; 

session_start();

// Check if the student's ID is set in the session
if (!isset($_SESSION['id'])) {
    echo "Error: User not logged in.";
    exit; // Stop further execution
}

// Retrieve the student's ID from session
$studentId = $_SESSION['id'];

// Prepare the SQL statement to retrieve the student's name
$query = "SELECT fullname FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    // Handle error for statement preparation failure
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $studentId);
$stmt->execute();
$stmt->bind_result($studentName);
$stmt->fetch();
$stmt->close();

// Check if the student's name was retrieved successfully
if (!$studentName) {
    echo "Error: Student not found.";
    exit;
}

// Display the student's name
$_SESSION['student_name'] = $studentName;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef2f3;
        }

        .container {
            display: flex;
        }

        .sidebar {
            background-color: #222;
            color: white;
            width: 250px;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }

        .sidebar-header {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .sidebar-nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar-nav li {
            padding: 15px;
        }

        .sidebar-nav a {
            color: white;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: #4caf50; /* Green hover effect */
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dashboard-overview {
            margin-top: 20px;
        }

        .welcome-message {
            font-size: 1.5em;
            color: #222;
        }

        .course-management {
            margin-top: 40px;
        }

        .course-slider {
            display: flex;
            overflow-x: auto;
            padding: 10px 0;
            scrollbar-width: none; /* Firefox */
        }

        .course-slider::-webkit-scrollbar {
            display: none; /* Safari and Chrome */
        }

        .course-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            margin: 10px;
            min-width: 200px;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer; /* Change cursor to pointer */
        }

        .course-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Enhanced shadow */
        }

        .footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer-icons {
            margin-top: 10px;
        }

        .footer-icons a {
            color: white;
            margin: 0 10px;
            font-size: 1.5em;
            transition: color 0.3s;
        }

        .footer-icons a:hover {
            color: #4caf50; /* Green hover effect */
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 600px; /* Max width for modal */
            border-radius: 10px; /* Rounded corners */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .search-container {
    margin-top: 20px; /* Space above the search input */
}

.search-container input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}


    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Student Dashboard</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="active">Dashboard Overview</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Assignments</a></li>
                    <li><a href="#">Grades</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="profile">
                    <img src="profile.jpg" alt="Profile Picture">
                </div>
            </header>
            <section class="dashboard-overview">
                <h3 class="welcome-message">Welcome, <?php echo htmlspecialchars($studentName); ?>!</h3>
            </section>
            <div class="search-container">
        <input type="text" id="courseSearch" placeholder="Search Courses..." onkeyup="filterCourses()">
    </div>
            <section class="course-management">
                <h3>Your Courses</h3>
                <div class="course-slider" id="courseSlider">
                    <div class="course-card" data-title="Mathematics 101" data-description="Introduction to basic mathematics concepts.">
                        <h4>Mathematics 101</h4>
                        <p>Description: Introduction to basic mathematics concepts.</p>
                        <button onclick="openModal('Mathematics 101', 'Introduction to basic mathematics concepts.')">View Details</button>
                    </div>
                    <div class="course-card" data-title="Science 202" data-description="Explore the fundamentals of scientific inquiry.">
                        <h4>Science 202</h4>
                        <p>Description: Explore the fundamentals of scientific inquiry.</p>
                        <button onclick="openModal('Science 202', 'Explore the fundamentals of scientific inquiry.')">View Details</button>
                    </div>
                    <div class="course-card" data-title="History 303" data-description="A journey through significant historical events.">
                        <h4>History 303</h4>
                        <p>Description: A journey through significant historical events.</p>
                        <button onclick="openModal('History 303', 'A journey through significant historical events.')">View Details</button>
                    </div>
                    <!-- Add more course cards as needed -->
                </div>
            </section>
            <footer class="footer">
                <p>&copy; 2024 LAITI Learning Management System | All Rights Reserved</p>
                <div class="footer-icons">
                    <a href="#" class="fab fa-facebook"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div>
            </footer>
        </main>
    </div>

    <!-- Modal Structure -->
    <div id="courseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle"></h2>
            <p id="modalDescription"></p>
        </div>
    </div>

    <script>
        function openModal(title, description) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('courseModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('courseModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('courseModal')) {
                closeModal();
            }
        }

        // Function to filter courses based on search input
function filterCourses() {
    const input = document.getElementById('courseSearch');
    const filter = input.value.toLowerCase();
    const courseCards = document.querySelectorAll('.course-card');

    courseCards.forEach((card) => {
        const title = card.getAttribute('data-title').toLowerCase();
        if (title.includes(filter)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
    </script>
</body>
</html>
