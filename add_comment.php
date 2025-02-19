<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villagehub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["issue_id"]) && isset($_POST["comment"])) {
  $issue_id = $_POST["issue_id"];
  $comment = $_POST["comment"];
  
  // Get the current username (assuming you have a way to authenticate users)
  $by = $_SESSION["user_name"]; // This should be replaced with the actual username
  
  // Insert comment into database
  $insert_sql = "INSERT INTO comments (issue_id, comment, BYO) VALUES ('$issue_id', '$comment', '$by')";
  if ($conn->query($insert_sql) === TRUE) {
    echo "Comment added successfully";
  } else {
    echo "Error adding comment: " . $conn->error;
  }
}

$conn->close();
?>
