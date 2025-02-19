<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $village_id = $_POST["username"];
    $password = $_POST["password"];

    // Example: Connect to a database and validate credentials
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "villagehub";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL query to check if the Village ID and password match
    $sql = "SELECT * FROM users WHERE username = '$village_id' AND password = '$password'";
    $result = $conn->query($sql);
    $_SESSION["admin_logged_in"]=false;

    if ($result->num_rows == 1) {
        // Village ID and password match, determine if admin or user
        $row = $result->fetch_assoc();
        if ($row["username"] == 'admin') {
            // Admin login
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_name"] = $row["username"];
            $_SESSION["user_name"] = "admin";
            $_SESSION["admin_id"] = $row["id"];
            header("Location: admin.php");
            exit;
        } 
        elseif($village_id === "dept"){
            $_SESSION["dept_login"] = true;
            $_SESSION["dept_name"] = $password ;
            $_SESSION["user_name"] = $password . $village_id;
            $_SESSION["admin_name"] = $password . $village_id;
            $_SESSION["admin_logged_in"] = true;

            header("Location: dept.php");
            exit;
        }
        
        else {
            // User login
            $_SESSION["user_logged_in"] = true;
            $_SESSION["user_name"] = $row["username"];
            $_SESSION["user_id"] = $row["id"];

            echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        sleep(5);

            header("Location: home.php");
            exit;
        }
    } else {
        // Invalid credentials, redirect back to login page
        header("Location: login.html");
        exit;
    }

    $conn->close();
}
?>
