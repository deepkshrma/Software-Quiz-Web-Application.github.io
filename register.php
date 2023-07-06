<?php
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
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Check if username or email already exists
  $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
  $checkResult = $conn->query($checkQuery);
  if ($checkResult->num_rows > 0) {
    echo "Username or email already exists. Please choose a different one.";
  } else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    if ($conn->query($insertQuery) === TRUE) {
      // Registration successful, redirect to login page
      header("Location: login.html");
      exit();
    } else {
      echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
  }
}

$conn->close();
?>
