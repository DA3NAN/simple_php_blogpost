<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Perform necessary input validation and sanitization here

    // Connect to the database
    $servername = 'localhost';
    $database_username = 'root';
    $databas_password = '';
    $database = 'blog_post';

    $conn = new mysqli($servername, $database_username, $databas_password, $database);

    // Check the database connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Query the database to check user credentials
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];

            // Redirect to the profile page
            header('Location: profile.php');
            exit;
        }
    }

    // If the login fails, redirect back to the login page with an error parameter
    header('Location: login.php?error=1');
    exit;
}

// If the form is not submitted, redirect back to the login page
header('Location: login.php');
exit;
?>
