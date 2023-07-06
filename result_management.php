<?php
session_start();

// Check if the admin is authenticated
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}

// Database connection details
$hostname = "localhost";
$username = "root";
$password = "";
$database = "quiz_db";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and display quiz results
$sql = "SELECT * FROM results";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Quiz Results</h2>";

    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $username = $row['username'];
        $mobile_number = $row['mobile_number'];
        $score = $row['score'];

        echo "<p>Name: $name</p>";
        echo "<p>Username: $username</p>";
        echo "<p>Mobile Number: $mobile_number</p>";
        echo "<p>Score: $score</p>";
        echo "<hr>";
    }
} else {
    echo "No results found.";
}

// Close the database connection
$conn->close();
?>
