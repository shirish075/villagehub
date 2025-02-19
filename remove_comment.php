<?php
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $comment_id = $_GET["id"];

    // Delete comment from database
    $delete_sql = "DELETE FROM comments WHERE id = $comment_id";
    if ($conn->query($delete_sql) === TRUE) {
        // echo "Comment removed successfully";
    } else {
        echo "Error removing comment: " . $conn->error;
    }
}

$conn->close();
?>
