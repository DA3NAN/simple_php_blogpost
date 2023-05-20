<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css" class="real">
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
	<title>Blogy</title>
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
		<div class="profile-info">
			<?php

				// Get the logged-in user's username from the session
				$sessionUsername = $_SESSION['username'];

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

				// Retrieve user information from the database
				$sql = "SELECT * FROM users WHERE username = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $sessionUsername);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$name = $row['username'];
					$email = $row['email'];

					// Display user information
					echo '<h2>Welcome, ' . $name . '</h2>';
					echo '<p>Username: ' . $sessionUsername . '</p>';
					echo '<p>Email: ' . $email . '</p>';
				}
			?>
		</div>
		<div class="posts-list">
			<?php
				// Retrieve user's posts from the database
				$sql = "SELECT * FROM posts WHERE author = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $sessionUsername);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					// Display user's posts
					echo '<h3>Your Posts</h3>';

					while ($row = $result->fetch_assoc()) {
						$postId = $row['id'];
						$title = $row['title'];
						$content = $row['content'];

						echo '<div class="post">';
						echo '<h4>' . $title . '</h4>';
						echo '<p>' . $content . '</p>';
						echo '<a href="edit_post.php?id=' . $postId . '">Edit</a> | ';
						echo '<a href="delete_post.php?id=' . $postId . '">Delete</a>';
						echo '</div>';
					}
				} else {
					echo '<p>You have no posts.</p>';
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
