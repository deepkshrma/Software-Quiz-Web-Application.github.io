<!DOCTYPE html>
<html>
<head>
  <title>Quiz</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<header>
    <nav>
      <div class="logo">
        <img src=".\images\logo.jpeg" alt="63 Moons Technologies Logo">
        <h1>63 Moons Technologies</h1>
      </div>
    </nav>
  </header>
  <h2>Software Quiz</h2>
  <span id="timer">30:00</span>
  <form id="quiz-form" method="POST" action="submit_quiz.php">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="text" name="mobile" placeholder="Mobile" required><br>

    <?php
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
        while ($row = $result->fetch_assoc()) {
            $questionId = $row['id'];
            $question = $row['question'];
            $option1 = $row['option1'];
            $option2 = $row['option2'];
            $option3 = $row['option3'];
            $option4 = $row['option4'];

            // Display the question and options
            echo "<h3>$question</h3>";
            echo "<input type='radio' name='answer[$questionId]' value='$option1'>$option1<br>";
            echo "<input type='radio' name='answer[$questionId]' value='$option2'>$option2<br>";
            echo "<input type='radio' name='answer[$questionId]' value='$option3'>$option3<br>";
            echo "<input type='radio' name='answer[$questionId]' value='$option4'>$option4<br>";
            echo "<br>";
        }
    } else {
        echo "No questions found.";
    }

    // Free the result set
    $result->free_result();

    // Close the database connection
    $conn->close();
    ?>

    <input type="submit" value="Submit Quiz">
  </form>

  <footer>
    <p>&copy; 2023 63 Moons Technologies. All rights reserved.</p>
  </footer>

  <script>
    var timeLeft = 30 * 60; // 30 minutes in seconds

    // Function to update the timer display
    function updateTimer() {
      var minutes = Math.floor(timeLeft / 60);
      var seconds = timeLeft % 60;
      document.getElementById('timer').innerHTML = minutes + ':' + seconds.toString().padStart(2, '0');

      if (timeLeft > 0) {
        timeLeft--;
      } else {
        // Automatically submit the quiz
        document.getElementById('quiz-form').submit();
      }
    }

    // Start the timer
    var timerInterval = setInterval(updateTimer, 1000);
  </script>

</body>
</html>
