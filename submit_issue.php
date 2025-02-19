<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST["title"]);
    $description = htmlspecialchars($_POST["description"]);
    $category = htmlspecialchars($_POST["category"]);
    $comment = htmlspecialchars($_POST["comment"]);
    $usernamefordb = $_SESSION['user_name'];

    // Retrieve user ID from the users table
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "villagehub";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt_user = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt_user->bind_param("s", $usernamefordb);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    if ($result_user->num_rows > 0) {
        $user_row = $result_user->fetch_assoc();
        $user_id = $user_row["id"];
        $statuss="uploaded";

        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        if(!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {

                // Use prepared statement to prevent SQL injection
                $stmt = $conn->prepare("INSERT INTO issues (title, description, category, photo, user_id,STATUS) VALUES (?, ?, ?, ?, ?,?)");
                $stmt->bind_param("ssssis", $title, $description, $category, $target_file, $user_id, $statuss);


                if ($stmt->execute()) {
                    $issue_id = $stmt->insert_id;
                    $status = "reported";

                    // Use prepared statement for other inserts
                    $stmt_status = $conn->prepare("INSERT INTO statuses (issue_id, status) VALUES (?, ?)");
                    $stmt_status->bind_param("is", $issue_id, $status);
                    $stmt_status->execute();

                    $stmt_comment = $conn->prepare("INSERT INTO comments (issue_id, comment,BYO) VALUES (?, ?,?)");
                    $stmt_comment->bind_param("iss", $issue_id, $comment,$usernamefordb);
                    $stmt_comment->execute();

                    echo "Issue reported successfully";
                    header('Location: home.php'); // Redirect to home.php
                    exit; // Stop further execution
                } else {
                    echo "Error inserting issue: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "User not found.";
    }

    $stmt_user->close();
    $conn->close();
}
?>
