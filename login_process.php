<?php
session_start();

// Database connection details
$hostname = "localhost";
$dbUsername = "root";
$dbPassword = "";
$database = "quiz_db";

// Retrieve the submitted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Create a database connection
$conn = new mysqli($hostname, $dbUsername, $dbPassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the hashed password
$sql = "SELECT password FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    $hashedPasswordFromDatabase = $admin['password'];

    // Verify the entered password with the hashed password
    if (password_verify($password, $hashedPasswordFromDatabase)) {
        // Authentication successful
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit;
    }
}

// Invalid username or password
echo "Invalid username or password.";

// Close the database connection
$conn->close();
?>
