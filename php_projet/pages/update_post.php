<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page or display an error message
  header('Location: login.php');
  exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the logged-in user's username from the session
  $username = $_SESSION['username'];

  // Get the post ID and updated post data from the form
  $postId = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];

  // Connect to the database
  $servername = 'localhost';
  $db_username = 'root';
  $db_password = '';
  $database = 'blog_post';

  $conn = new mysqli($servername, $db_username, $db_password, $database);

  // Check the database connection
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }

  // Update the post in the database
  $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND author = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssis', $title, $content, $postId, $username);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->affected_rows === 1) {
    // Redirect to the profile page or display a success message
    header('Location: profile.php');
    exit();
  } else {
    // Redirect to an error page or display an error message
    echo'error';
    exit();
  }

  // Close the statement and database connection
  $stmt->close();
  $conn->close();
} else {
  // Redirect to the profile page or display an error message
  header('Location: profile.php');
  exit();
}
?>
