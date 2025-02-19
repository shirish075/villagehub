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
    $issue_id = $_GET["id"];

    // Delete statuses related to the issue
    $delete_statuses_sql = "DELETE FROM statuses WHERE issue_id = '$issue_id'";
    if ($conn->query($delete_statuses_sql) === TRUE) {
        // Statuses deleted successfully, now delete the comments
        $delete_comments_sql = "DELETE FROM comments WHERE issue_id = '$issue_id'";
        if ($conn->query($delete_comments_sql) === TRUE) {
            // Comments deleted successfully, now delete the issue
            $delete_issue_sql = "DELETE FROM issues WHERE id = '$issue_id'";
            if ($conn->query($delete_issue_sql) === TRUE) {
                echo "Issue removed successfully";
            } else {
                echo "Error removing issue: " . $conn->error;
            }
        } else {
            echo "Error removing comments: " . $conn->error;
        }
    } else {
        echo "Error removing statuses: " . $conn->error;
    }
}

$conn->close();
?>
