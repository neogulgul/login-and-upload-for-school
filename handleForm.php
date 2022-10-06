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

$signIn = isset($_POST["sign-in"]);
$signUp = isset($_POST["sign-up"]);
$upload = isset($_POST["upload"]);

$hashAlgorithm = "sha256";

if ($signIn || $signUp)
{
	$username = $_POST["username"];
	$password = $_POST["password"];

	// signing in
	if ($signIn)
	{
		if (validLogin())
		{
			login();
		}
		else
		{
			changePage("./sign-in.php?invalid=true");
		}
	}
	// signing up
	else if ($signUp)
	{
		if (validNewUsername())
		{
			$passwordHash = hash($hashAlgorithm, $password);
			$database->query("INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')");
			changePage("./sign-in.php");
		}
		else
		{
			changePage("./sign-up.php?invalid=true");
		}
	}
}
// uploading
else if ($upload)
{
	session_start();
	$username = $_SESSION["user"];
	$id_query = $database->query("SELECT * FROM users WHERE username='$username'");
	$userId = $id_query->fetch_assoc()["id"];

	$title = $_POST["title"];

	$count_query = $database->query("SELECT * FROM gallery");
	$galleryCount = $count_query->num_rows;

	$fileType = $_FILES["file"]["type"];
	$fileFormat = explode("image/", $fileType)[1];

	$validFormats = ["png", "jpg", "jpeg", "gif"];
	$isValidFormat = false;
	for ($i = 0; $i < sizeof($validFormats); $i++)
	{
		if ($fileFormat === $validFormats[$i])
		{
			$isValidFormat = true;
			break;
		}
	}

	$fileSize = $_FILES["file"]["size"];
	$maxFileSize = 5000000; // 5 MB

	if (!$isValidFormat || $fileSize > $maxFileSize)
	{
		changePage("./your-profile.php?invalid=true");
	}

	$fileName = $username . "_" . $galleryCount . "_" . $title;
	$filePath = "./uploads/$fileName.$fileFormat";

	if (!file_exists("./uploads")) {
		mkdir("./uploads");
	}

	if ($database->query("INSERT INTO gallery (user_id, title, path) VALUES ('$userId', '$title', '$filePath')"))
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
		changePage("./your-profile.php");
	}
}
// no
else
{
	changePage("./index.php");
}

function validNewUsername()
{
	GLOBAL $database;
	GLOBAL $username;

	$username_query = $database->query("SELECT * FROM users WHERE username='$username'");
	return !$username_query->fetch_assoc();
}

function validLogin()
{
	GLOBAL $database;
	GLOBAL $username;
	GLOBAL $password;
	GLOBAL $hashAlgorithm;

	$password_query = $database->query("SELECT * FROM users WHERE username='$username'");
	return $password_query->fetch_assoc()["password"] === hash($hashAlgorithm, $password);
}

function changePage($location)
{
	header("Location: $location");
	exit();
}

function login()
{
	GLOBAL $username;
	
	session_start();
	$_SESSION["user"] = $username;
	changePage("./your-profile.php");
}

?>
