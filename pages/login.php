<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/styles.css" class="real">
	<title>Login</title>
</head>
<body>
	<?php include '../components/navbar.php'?>
	<div class="nav_spacer"></div>
	<div class="container">
		<h1 class="center">Login</h1>
		<?php
		// Display error message if login failed
		if (isset($_GET['error'])) {
			echo '<p class="error-message">Invalid username or password.</p>';
		}
		?>

		<form action="login_process.php" method="POST">
			<label for="username">Username or Email:</label>
			<input type="text" id="username" name="username" required>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>

			<input type="submit" value="Login">
		</form>
		<p class="center">Don't have an account? <a href="register.php">create one</a></p>
	</div>
	<div class="nav_spacer"></div>
</body>
</html>
