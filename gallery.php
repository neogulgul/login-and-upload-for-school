<!DOCTYPE html>
<html lang="en">
<?php include "./html/head.html"; ?>
<body>
	<div id="site-wrapper">
		<?php include "./html/home.html"; ?>
		<h1>Gallery</h1>
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

			$image_query = $database->query("SELECT * FROM gallery");
			while ($image = $image_query->fetch_assoc())
			{
				$user_id = $image["user_id"];
				$path    = $image["path"];
				$title   = $image["title"];

				$username_query = $database->query("SELECT * FROM users WHERE id='$user_id'");
				$user = $username_query->fetch_assoc()["username"];

				echo "<div class='post'>";
				echo "<img src='$path'>";
				echo "<p class='title'>$title</p>";
				echo "<p class='user'>By $user</p>";
				echo "</div>";
			}
			?>
		</div>
	</div>
</body>
</html>
