<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css" class="real">
  	<title>Register</title>
</head>
<body>
	<?php include '../components/navbar.php'?>
	<div class="nav_spacer"></div>
	<div class="container">
		<h2 class="center">Register</h2>
		<?php
		// Display error message if registration failed
		if (isset($_GET['error'])) {
			echo '<p class="error-message">Registration failed. Please try again.</p>';
		}
		?>

		<form action="register_process.php" method="POST">
			<label for="username">Username:</label><br>
			<input type="text" id="username" name="username" required><br><br>

			<label for="email">Email:</label><br>
			<input type="email" id="email" name="email" required><br><br>

			<label for="password">Password:</label><br>
			<input type="password" id="password" name="password" required><br><br>

			<input type="submit" value="Register">
		</form>
		<p class="center">Go Bakc to<a href="login.php"> Login</a></p>
	</div>
	<div class="nav_spacer"></div>
</body>
</html>
