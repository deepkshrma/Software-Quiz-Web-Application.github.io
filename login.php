<?php
// Start session
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Check if username or email exists
  $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
  $checkResult = $conn->query($checkQuery);
  if ($checkResult->num_rows > 0) {
    $user = $checkResult->fetch_assoc();
    // Verify password
    if (password_verify($password, $user["password"])) {
      // Password is correct, create session
      $_SESSION["username"] = $user["username"];
      $_SESSION["email"] = $user["email"];
      // Redirect to index page
      header("Location: index.html");
      exit();
    } else {
      echo "Incorrect password.";
    }
  } else {
    echo "User not found.";
  }
}

$conn->close();
?>
