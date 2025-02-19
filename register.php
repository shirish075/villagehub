<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villagehub";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $username = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);
    $confirmPassword = sanitize($_POST["confirmPassword"]);
    $email = sanitize($_POST["email"]);

    // Check if passwords match
    if ($password != $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists.";
        exit;
    }

    // // Hash the password
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.html"); // Redirect to the login page
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VillageHub Registration</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <img src="logo.ico" alt="VillageHub Logo">
        <h1>Join Your Community</h1>
    </header>
    <main>
        <img src="background.jpg" alt="Village Landscape">
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="terms">
                <input type="checkbox" id="terms" name="terms" required>
                I agree to the <a href="terms-of-service.php">Terms of Service</a>
            </label>

            <button type="submit">Register</button>
        </form>
        <img src="illustrations.png" alt="Villagers engaging in community activities">
    </main>
    <footer>
        <a href="login.html">Already have an account? Login</a>
        <a href="contact-us.php">Contact Us</a>
    </footer>
</body>
</html>
