<?php
// Assuming you already have a database connection established in your config file
include 'config.php'; 

session_start();

// Check if the teacher's ID is set in the session
if (!isset($_SESSION['id'])) {
    echo "Error: User not logged in.";
    exit; // Stop further execution
}

// Retrieve the teacher's ID from session
$teacherId = $_SESSION['id'];

// Prepare the SQL statement to retrieve the teacher's name
$query = "SELECT fullname FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    // Handle error for statement preparation failure
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $teacherId);
$stmt->execute();
$stmt->bind_result($teacherName);
$stmt->fetch();
$stmt->close();

// Check if the teacher's name was retrieved successfully
if (!$teacherName) {
    echo "Error: Teacher not found.";
    exit;
}

// Display the teacher's name
$_SESSION['teacher_name'] = $teacherName;
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
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
    background-color: #f4f4f4;
}

.container {
    display: flex;
}

.sidebar {
    background-color: #3a3f51;
    color: white;
    width: 250px;
    min-height: 100vh;
}

.sidebar-header {
    padding: 20px;
    text-align: center;
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
    background-color: #575b79;
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

.search-container input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
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

.notifications {
    cursor: pointer;
}

.dashboard-overview {
    margin-top: 20px;
}

.stats {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.stat-card {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    flex: 1;
    margin: 0 10px;
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
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 10px;
    min-width: 200px;
    transition: transform 0.3s;
}

.course-card:hover {
    transform: scale(1.05);
}

.footer {
    background-color: #3a3f51;
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
    color: #f4f4f4;
}
</style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Teacher Dashboard</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="active">Dashboard Overview</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Assignments</a></li>
                    <li><a href="#">Students</a></li>
                    <li><a href="#">Communication</a></li>
                    <li><a href="#">Reports</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <!-- <div class="search-container">
                    <input type="text" placeholder="Search...">
                </div> -->
                <div class="profile">
                    <img src="profile.jpg" alt="Profile Picture">
                    <div class="notifications">🔔</div>
                </div>
            </header>
            <section class="dashboard-overview">
            <h3>Welcome, <?php echo htmlspecialchars($teacherName); ?>!</h3> <!-- Display teacher's name -->
                <div class="stats">
                    <div class="stat-card">Total Students: <span id="totalStudents">30</span></div>
                    <div class="stat-card">Active Courses: <span id="activeCourses">5</span></div>
                    <div class="stat-card">Upcoming Assignments: <span id="upcomingAssignments">2</span></div>
                    <div class="stat-card">Recent Feedback: <span id="recentFeedback">3</span></div>
                </div>
            </section>
            <section class="course-management">
    <h3>Your Courses</h3>
    <div class="search-container">
        <input type="text" id="courseSearch" placeholder="Search Courses..." onkeyup="filterCourses()">
    </div>
    <div class="course-slider" id="courseSlider">
        <div class="course-card" data-title="Mathematics 101">
            <h4>Mathematics 101</h4>
            <p>Enrolled Students: 30</p>
            <p>Status: Active</p>
            <button>View Course</button>
            <button>Edit Course</button>
        </div>
        <div class="course-card" data-title="Science 202">
            <h4>Science 202</h4>
            <p>Enrolled Students: 25</p>
            <p>Status: Active</p>
            <button>View Course</button>
            <button>Edit Course</button>
        </div>
        <div class="course-card" data-title="History 303">
            <h4>History 303</h4>
            <p>Enrolled Students: 28</p>
            <p>Status: Active</p>
            <button>View Course</button>
            <button>Edit Course</button>
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
    <script>
// script.js

// script.js

document.addEventListener("DOMContentLoaded", () => {
    // Add functionality for sliding cards
    const courseSlider = document.querySelector('.course-slider');
    let isMouseDown = false;
    let startX;
    let scrollLeft;

    courseSlider.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        startX = e.pageX - courseSlider.offsetLeft;
        scrollLeft = courseSlider.scrollLeft;
    });

    courseSlider.addEventListener('mouseleave', () => {
        isMouseDown = false;
    });

    courseSlider.addEventListener('mouseup', () => {
        isMouseDown = false;
    });

    courseSlider.addEventListener('mousemove', (e) => {
        if (!isMouseDown) return;
        e.preventDefault();
        const x = e.pageX - courseSlider.offsetLeft;
        const walk = (x - startX) * 1; // Scroll-fast
        courseSlider.scrollLeft = scrollLeft - walk;
    });
});

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
