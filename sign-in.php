<!DOCTYPE html>
<html lang="en">
<?php include "./html/head.html"; ?>
<body>
	<div id="site-wrapper">
		<?php include "./html/home.html"; ?>
		<h1>Sign in to your account</h1>
		<form action="./handleForm.php" method="POST">
			<label for="username">Username</label>
			<input name="username" type="text">
			<label for="password">Password</label>
			<input name="password" type="password">
			<a href="./forgot-password.php">Forgot your password?</a>
			<input name="sign-in" type="submit" value="Sign in">
			<?php
			parse_str($_SERVER["QUERY_STRING"], $queryString);
			if ($queryString["invalid"] === "true")
			{
				echo "<h2 class='error'>Invalid.<br>Either the username<br>or password was wrong.</h2>";
			}
			?>
		</form>
		<p>Don't have an account? <a href="./sign-up.php">Sign up</a></p>
	</div>
	<script src="./js/form.js"></script>
</body>
</html>
