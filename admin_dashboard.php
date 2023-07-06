<?php
session_start();

// Check if the admin is authenticated
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <script>
    function showScoreTable() {
      var scoreTable = document.getElementById("scoreTable");
      scoreTable.style.display = "block";
    }
  </script>
</head>
<body>
  <h2>Welcome, Admin!</h2>
  
  <a href="add_question.html">Add Question</a>
  <button onclick="showScoreTable()">Show Score Table</button>

  <h3>Score Table</h3>
  
  <table id="scoreTable" style="display: none;">
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

    // Fetch scores from the database
    $selectQuery = "SELECT * FROM score";
    $result = $conn->query($selectQuery);

    // Check if there are any scores
    if ($result->num_rows > 0) {
        echo "<tr><th>Name</th><th>Username</th><th>Mobile</th><th>Score</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $username = $row['username'];
            $mobile = $row['mobile'];
            $score = $row['score'];

            // Display the score table row
            echo "<tr><td>$name</td><td>$username</td><td>$mobile</td><td>$score</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No scores found.</td></tr>";
    }

    // Free the result set
    $result->free_result();

    // Close the database connection
    $conn->close();
    ?>
  </table>
  
</body>
</html>
