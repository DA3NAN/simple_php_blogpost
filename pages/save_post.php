<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page or display an error message
  header('Location: login.php');
  exit();
}

// Get the logged-in user's username from the session
$username = $_SESSION['username'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $title = $_POST['title'];
  $content = $_POST['content'];

  // Check if an image is uploaded
  $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $imagePath = '../img/' . $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
  }

  // Validate the form data (you can add your own validation logic here)

  // Connect to the database and insert the post data
  $servername = 'localhost';
  $database_username = 'root';
  $database_password = '';
  $database = 'blog_post';

  $conn = new mysqli($servername, $database_username, $database_password, $database);

  // Check the database connection
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }

  // Prepare and execute the SQL statement to insert the post data
  $sql = "INSERT INTO posts (title, content, author, image_url) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssss', $title, $content, $username, $imagePath);
  $stmt->execute();

  // Check if the post was inserted successfully
  if ($stmt->affected_rows > 0) {
    header('Location: blog.php');
    exit;
  } else {
    echo 'Error creating post: ' . $conn->error;
  }

  // Close the statement and database connection
  $stmt->close();
  $conn->close();
}
?>
