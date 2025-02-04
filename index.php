<?php
// Database connection
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "student_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session start (for login)
session_start();

// Register functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert into the database
    $sql = "INSERT INTO students (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='?action=login'>Login now</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Login functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        if (password_verify($password, $student['password'])) {
            $_SESSION['student_id'] = $student['student_id'];
            header('Location: ?action=dashboard');
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Student not found!";
    }
}

// Logout functionality
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: ?action=login');
    exit();
}

// Dashboard functionality
if (isset($_SESSION['student_id']) && isset($_GET['action']) && $_GET['action'] == 'dashboard') {
    $student_id = $_SESSION['student_id'];

    // Get enrolled courses
    $sql = "SELECT courses.course_name FROM enrollments 
            JOIN courses ON enrollments.course_id = courses.course_id
            WHERE enrollments.student_id = $student_id";
    $courses = $conn->query($sql);

    // Get attendance records
    $sql_attendance = "SELECT * FROM attendance 
                       JOIN enrollments ON attendance.enrollment_id = enrollments.enrollment_id
                       WHERE enrollments.student_id = $student_id";
    $attendance = $conn->query($sql_attendance);

    // Get schedule
    $sql_schedule = "SELECT * FROM schedules 
                     JOIN courses ON schedules.course_id = courses.course_id
                     WHERE schedules.student_id = $student_id";
    $schedule = $conn->query($sql_schedule);

    // Display Dashboard
    echo "<h2>Welcome to Your Dashboard</h2>";
    echo "<h3>Enrolled Courses</h3><ul>";
    while ($row = $courses->fetch_assoc()) {
        echo "<li>" . $row['course_name'] . "</li>";
    }
    echo "</ul>";

    echo "<h3>Attendance</h3><table border='1'><tr><th>Course</th><th>Date</th><th>Status</th></tr>";
    while ($row = $attendance->fetch_assoc()) {
        echo "<tr><td>" . $row['course_name'] . "</td><td>" . $row['date'] . "</td><td>" . $row['status'] . "</td></tr>";
    }
    echo "</table>";

    echo "<h3>Your Schedule</h3><table border='1'><tr><th>Course</th><th>Day</th><th>Time</th></tr>";
    while ($row = $schedule->fetch_assoc()) {
        echo "<tr><td>" . $row['course_name'] . "</td><td>" . $row['day_of_week'] . "</td><td>" . $row['start_time'] . " - " . $row['end_time'] . "</td></tr>";
    }
    echo "</table>";
    echo "<br><a href='?action=logout'>Logout</a>";
    exit();
}

// Render the register/login forms based on the action in the URL
if (!isset($_SESSION['student_id'])) {
    if (isset($_GET['action']) && $_GET['action'] == 'register') {
        // Registration form
        echo "<h2>Register</h2>";
        echo "<form method='POST'><label>Name: <input type='text' name='name' required></label><br><br>";
        echo "<label>Email: <input type='email' name='email' required></label><br><br>";
        echo "<label>Password: <input type='password' name='password' required></label><br><br>";
        echo "<button type='submit' name='register'>Register</button></form>";
    } elseif (isset($_GET['action']) && $_GET['action'] == 'login') {
        // Login form
        echo "<h2>Login</h2>";
        echo "<form method='POST'><label>Email: <input type='email' name='email' required></label><br><br>";
        echo "<label>Password: <input type='password' name='password' required></label><br><br>";
        echo "<button type='submit' name='login'>Login</button></form>";
    } else {
        // Default landing page
        echo "<h2>Welcome to the Student Portal</h2>";
        echo "<a href='?action=register'>Register</a><br><br>";
        echo "<a href='?action=login'>Login</a>";
    }
}
?>
