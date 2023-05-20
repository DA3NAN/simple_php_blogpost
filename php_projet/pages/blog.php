<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css" class="real">
  	<title>Blog</title>
</head>
<body>
	<?php include '../components/navbar.php'?>
	<div class="nav_spacer"></div>
	<div class="container">
		<?php
		$authenticated = false; // Set to true if the user is authenticated
		if (!isset($_SESSION['loggedin'])) {
			$authenticated = true; // Set to true if the user is authenticated
		}
		// Check if the user is authenticated

		if ($authenticated) {
			// If the user is authenticated, display the navigation bar with the "New Post" link
			echo '
			<div class="blog_navbar">
				<h1>Blog</h1>
				<ul>
				<li><a class="new_post_button" href="create_post.php">New Post</a></li>
				</ul>
			</div>
			';
		} else {
			// If the user is not authenticated, display only the blog title
			echo '<h1>Blog</h1>';
		}
		?>

		<?php
		// Connect to the database and fetch all the posts
		$servername = 'localhost';
		$database_username = 'root';
		$database_password = '';
		$database = 'blog_post';

		$conn = new mysqli($servername, $database_username, $database_password, $database);

		// Check the database connection
		if ($conn->connect_error) {
			die('Connection failed: ' . $conn->connect_error);
		  }

		  // Query to fetch all posts from the database, ordered by the creation date in descending order
		  $sql = "SELECT * FROM posts ORDER BY created_at DESC";
		  $result = $conn->query($sql);

		  // Display each blog post
		  if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
			  echo '
				<div class="blog-post">
				  <h2>' . $row['title'] . '</h2>
				  ';
				if (!empty($row['image_url'])) {
					echo '<img src="' . $row['image_url'] . '" alt="Post Image" width="400px">';
				}
				echo '
				  <p>' . $row['content'] . '</p>
				  <p>Author: ' . $row['author'] . '</p>
				</div>
			  ';
			}
		  } else {
			echo '<p>No posts found.</p>';
		  }

		  // Close the database connection
		  $conn->close();
		  ?>
	</div>
</body>
</html>
