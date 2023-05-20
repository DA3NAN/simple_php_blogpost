<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page or display an error message
  header('Location: login.php');
  exit();
}

// Check if the post ID is provided
if (!isset($_GET['id'])) {
  // Redirect to the profile page or display an error message
  header('Location: profile.php');
  exit();
}

// Get the logged-in user's username from the session
$username = $_SESSION['username'];

// Get the post ID from the query string
$postId = $_GET['id'];

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

// Delete the post from the database
$sql = "DELETE FROM posts WHERE id = ? AND author = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $postId, $username);
$stmt->execute();

// Check if the delete was successful
if ($stmt->affected_rows === 1) {
  // Redirect to the profile page or display a success message
  header('Location: profile.php');
  exit();
} else {
  // Redirect to an error page or display an error message
  echo 'Error deleting post.';
  exit();
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
