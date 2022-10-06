<!DOCTYPE html>
<html lang="en">
<?php include "./html/head.html"; ?>
<body>
	<div id="site-wrapper">
		<?php include "./html/home.html"; ?>
		<?php
		session_start();

		if (!$_SESSION["user"])
		{
			die();
		}
		else
		{
			$username = $_SESSION["user"];
		}
		?>
		<h1>Your profile</h1>
		<h2>Upload an image!</h2>
		<form action="./handleForm.php" method="POST" enctype="multipart/form-data">
			<label for="title">Title</label>
			<input name="title" type="text">
			<label for="file">Image ("png", "jpeg", "jpg", "gif")</label>
			<input name="file" type="file">
			<input name="upload" type="submit" value="Upload">
			<?php
			parse_str($_SERVER["QUERY_STRING"], $queryString);
			if ($queryString["invalid"] === "true")
			{
				echo "<h2 class='error'>Invalid.<br>Either the file is not an image<br>or the file is too large.</h2>";
			}
			?>
		</form>
		<h2>Your uploaded images</h2>
		<div id="gallery">
			<?php
			$db_hostname = "localhost";
			$db_username = "root";
			$db_password = "";
			$db_database = "filuppladning";
			$database = new mysqli($db_hostname, $db_username, $db_password, $db_database);

			if ($database->connect_error)
			{
				die("connection to database failed :(");
			}

			$id_query = $database->query("SELECT * FROM users WHERE username='$username'");
			$user_id = $id_query->fetch_assoc()["id"];

			$image_query = $database->query("SELECT * FROM gallery WHERE user_id='$user_id'");
			$imageCount = 0;
			while ($image = $image_query->fetch_assoc())
			{
				$imageCount++;
				$path    = $image["path"];
				$title   = $image["title"];

				echo "<div class='post'>";
				echo "<img src='$path'>";
				echo "<p class='title'>$title</p>";
				echo "<p class='user'>By You</p>";
				echo "</div>";
			}
			if ($imageCount === 0)
			{
				echo "<p>Not uploaded any :(</p>";
			}
			?>
		</div>
		<a href="./log-out.php">
			<button>Log out</button>
		</a>
	</div>
	<script src="./js/form.js"></script>
</body>
</html>
