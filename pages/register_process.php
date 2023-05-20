<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform necessary input validation and sanitization here

    // Connect to the database
    $servername = 'localhost';
    $databas_username = 'root';
    $databas_password = '';
    $database = 'blog_post';

    $conn = new mysqli($servername, $databas_username, $databas_password, $database);

    // Check the database connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Check if the username or email already exists in the database
    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the username or email already exists, redirect back to the registration page with an error parameter
    if ($result->num_rows > 0) {
        header('Location: register.php?error=1');
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user's information into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $email, $hashedPassword);
    $stmt->execute();

    // If the registration is successful, set session variables and redirect to the profile page
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $stmt->insert_id;

    header('Location: profile.php');
    exit;
}

// If the form is not submitted, redirect back to the registration page
header('Location: register.php');
exit;
?>
