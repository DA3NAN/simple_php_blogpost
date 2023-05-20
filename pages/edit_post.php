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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css" class="real">
	<title>Blogy</title>
	<style>
		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
		}

		.top_bar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}

		.logout {
			text-decoration: none;
			color: #000;
			background-color: #f5f5f5;
			padding: 5px 10px;
			border-radius: 4px;
		}

		.logout:hover {
			background-color: #ddd;
		}

		.profile-info {
			margin-bottom: 20px;
		}

		.profile-info h2 {
			margin-bottom: 10px;
		}

		.posts-list {
			margin-top: 30px;
		}

		.post {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 10px;
			margin-bottom: 10px;
		}

		.post h4 {
			margin-bottom: 5px;
		}

		.post p {
			margin-bottom: 10px;
		}

		.post a {
			color: #007bff;
			text-decoration: none;
			margin-right: 10px;
		}

		.post a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<?php include '../components/navbar.php'?>
	<div class="nav_spacer"></div>
	<div class="container">
		<div class="top_bar">
			<h1>
				Profile
			</h1>
			<a class="logout" href="logout.php">Logout</a>
		</div>
		<div>
			<?php
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

				// Retrieve the post from the database
				$sql = "SELECT * FROM posts WHERE id = ? AND author = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('is', $postId, $username);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows === 1) {
				$row = $result->fetch_assoc();
				$title = $row['title'];
				$content = $row['content'];

				// Display the edit post form
				echo '<h2>Edit Post</h2>';
				echo '<form action="update_post.php" method="POST">';
				echo '<input type="hidden" name="id" value="' . $postId . '">';
				echo '<label for="title">Title:</label>';
				echo '<input type="text" id="title" name="title" value="' . $title . '" required>';
				echo '<label for="content">Content:</label>';
				echo '<textarea id="content" name="content" rows="5" required>' . $content . '</textarea>';
				echo '<input type="submit" value="Update">';
				echo '</form>';
				} else {
				echo '<p>Post not found.</p>';
				}

				// Close the statement and database connection
				$stmt->close();
				$conn->close();
			?>
		</div>
	</div>
	<div class="nav_spacer"></div>
</body>
</html>
