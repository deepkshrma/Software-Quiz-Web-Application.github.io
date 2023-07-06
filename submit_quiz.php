<?php
// Check if all the required fields are filled
if (!empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['mobile'])) {
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

    // Fetch questions from the database
    $selectQuery = "SELECT * FROM questions";
    $result = $conn->query($selectQuery);

    // Check if there are any questions
    if ($result->num_rows > 0) {
        // Calculate the score
        $score = 0;
        while ($row = $result->fetch_assoc()) {
            $questionId = $row['id'];
            $correctAnswer = $row['correct_option'];

            if (isset($_POST['answer'][$questionId]) && $_POST['answer'][$questionId] == $correctAnswer) {
                $score++;
            }
        }

        // Insert the score into the database
        $name = $_POST['name'];
        $username = $_POST['username'];
        $mobile = $_POST['mobile'];

        $insertQuery = "INSERT INTO score (name, username, mobile, score) VALUES ('$name', '$username', '$mobile', $score)";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Quiz submitted successfully!<br>";
            echo "Your score: $score";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        echo "No questions found.";
    }

    // Free the result set
    $result->free_result();

    // Close the database connection
    $conn->close();
} else {
    echo "Please fill in all the required fields.";
}
?>
