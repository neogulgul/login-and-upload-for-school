<!DOCTYPE html>
<html lang="en">
<?php include "./html/head.html"; ?>
<body>
	<div id="site-wrapper">
		<?php include "./html/home.html"; ?>
		<h1>Create your account</h1>
		<form action="./handleForm.php" method="POST">
			<label for="username">Username</label>
			<input name="username" type="text">
			<label for="password">Password</label>
			<input name="password" type="password">
			<p>*Your password will be unrecoverable.</p>
			<input name="sign-up" type="submit" value="Sign up">
			<?php
			parse_str($_SERVER["QUERY_STRING"], $queryString);
			if ($queryString["invalid"] === "true")
			{
				echo "<h2 class='error'>Invalid.<br>That username<br>is already in use.</h2>";
			}
			?>
		</form>
		<p>Already have an account? <a href="./sign-in.php">Sign in</a></p>
	</div>
	<script src="./js/form.js"></script>
</body>
</html>
