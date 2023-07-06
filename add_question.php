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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    $option1 = $_POST["option1"];
    $option2 = $_POST["option2"];
    $option3 = $_POST["option3"];
    $option4 = $_POST["option4"];
    $correctOption = $_POST["correct_option"];

    // Insert question into the "questions" table
    $insertQuery = "INSERT INTO questions (question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssssss", $question, $option1, $option2, $option3, $option4, $correctOption);

    if ($stmt->execute()) {
        echo "Question added successfully.";
    } else {
        echo "Error adding question: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
