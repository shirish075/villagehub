<?php
session_start();
$isAdmin = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true;
$isDept = isset($_SESSION["dept_login"]) && $_SESSION["dept_login"] === true;

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

  // Fetch issue details
  $sql = "SELECT * FROM issues WHERE id = $issue_id";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $title = htmlspecialchars($row["title"]);
    $description = htmlspecialchars($row["description"]);
    $category = htmlspecialchars($row["category"]);
    $photo = htmlspecialchars($row["photo"]);
    $status = htmlspecialchars($row["STATUS"]);

    echo "<h2><strong>Title:</strong>$title</h2>";
    echo "<p><strong>Description:</strong> $description</p>";
    echo "<p><strong>Category:</strong> $category</p>";
    echo "<p><strong>Status:</strong> $status</p>";

    if ($isAdmin && !($isDept)) {
      // Display status update form for admins
      ?>
      <form action="" method="post">
        <input type="hidden" name="issue_id" value="<?= $issue_id ?>">
        <label for="status">Change Status:</label>
        <select id="status" name="status">
          <option value="UPLOADED">Uploaded</option>
          <option value="SARPANCH VIEWED">Sarpanch Viewed</option>
          <option value="COMPLETED">Completed</option>
        </select>
        <input type="submit" value="Update">
      </form>
      <?php
    }
    if ($isDept && $isAdmin) {
      // Display status update form for admins
      ?>
      <form action="" method="post">
        <input type="hidden" name="issue_id" value="<?= $issue_id ?>">
        <label for="status">Change Status:</label>
        <select id="status" name="status">
          <option value="UPLOADED">Uploaded</option>
          <option value="Dept took case">Dept took case</option>
          <option value="Dept handling case">Dept handling case</option>
          <option value="COMPLETED">Completed</option>
        </select>
        <input type="submit" value="Update">
      </form>
      <?php
    }


    echo "<p><strong>Photo:</strong><br><img src='$photo' alt='Issue Photo' style='max-width: 700px;'></p>";

    // Fetch comments for the issue
    $sql_comments = "SELECT * FROM comments WHERE issue_id = $issue_id";
    $result_comments = $conn->query($sql_comments);

    if ($result_comments->num_rows > 0) {
      echo "<h3>Comments:</h3>";
      while ($comment_row = $result_comments->fetch_assoc()) {
        $comment_id = $comment_row["id"]; // Get the comment ID
        $comment = htmlspecialchars($comment_row["comment"]);
        $by = htmlspecialchars($comment_row["BYO"]);
        $created_at = htmlspecialchars($comment_row["created_at"]);
        $user_id = $comment_row["BYO"]; // Get the user ID of the comment author

        echo "<p><strong>By $by on $created_at:</strong><br>$comment</p>";

        if ($isAdmin || (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $user_id)) {
          // Display remove comment link for admins and comment author
          echo "<a href='remove_comment.php?id=$comment_id'>Remove Comment</a></p>";
        }
      }
    } else {
      echo "<p>No comments yet</p>";
    }
  } else {
    echo "Issue not found";
  }
} else {
  echo " request OK";
}

// Update status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["issue_id"]) && isset($_POST["status"]) && $isAdmin) {
  $issue_id = $_POST["issue_id"];
  $status = $_POST["status"];

  $update_sql = "UPDATE issues SET STATUS = '$status' WHERE id = $issue_id";
  if ($conn->query($update_sql) === TRUE) {
    echo "<p>Status updated successfully</p>";
  } else {
    echo "Error updating status: " . $conn->error;
  }
}

$conn->close();
?>

<?php if ($isAdmin || (isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]))): ?>
<form onsubmit="return addComment(<?= $issue_id ?>, this.comment.value)" autocomplete="off">
    <input type="text" name="comment" placeholder="Enter your comment">
    <input type="submit" value="Add Comment">
</form>
<script>
   function addComment(issueId, comment) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Comment added successfully, you can handle the response here
                alert("Comment added successfully");
                
            } else {
                // Error adding comment, you can handle the error here
                console.error("Error adding comment: " + xhr.statusText);
            }
        }
    };
    xhr.open("POST", "add_comment.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("issue_id=" + issueId + "&comment=" + encodeURIComponent(comment));

    return false; // Prevent form submission
}
</script>
<?php endif; ?>
</body>
</html>
