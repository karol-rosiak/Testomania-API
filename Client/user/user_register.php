<!DOCTYPE html>
<html>

<head>
<title>Testomania</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../style.css">

</head>
<div id="container">

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php include '../curl.php'; ?>
<?php

require('../lib/password.php');

if(!isset($_SESSION['logged']))
{
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$login = $_POST["login"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$password2 = $_POST["password2"];
		$errors = array();
		
	#	if(!preg_match($_POST["login"],"#^[A-Za-z][A-Za-z1-9_]+[A-Za-z1-9]$#"))
	#		$error[] = "Invalid login. Use only A-Z, 0-9 and _ characters!";
		
		if(strlen($_POST["login"])<6)
			$errors[] = "Login is too short. Minimum length is 6 characters!";
		
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
			$errors[] = "Invalid email format!"; 
		
		if(strlen($_POST["password"])<6)
			$errors[] = "Password is too short. Minimum length is 6 characters!";
		
		if($_POST["password"] != $_POST["password2"])
			$errors[] = "The passwords do not match!"; 

		if(count($errors) == 0){
			$postArray = array(
								"Login" => $_POST["login"],
								"Password" =>$_POST["password"],
								"Email" => $_POST["email"]
								);
								
			$apiResult = apiRequest("users","POST",$postArray);
			$response = $apiResult["Body"];
			$response = json_decode($response);
		
			$statusCode = $apiResult["Status"];
			if($statusCode != 201){
				if($response != NULL)
					echo "Error: " . $response->error . "</br>";
				else{
					echo "Error while adding a user </br>";
				}
			}
			else{
				echo "User registered successfully!";
				die();
			}
		}
		else{
			foreach($errors as $error){
				echo $error . "</br>";
			}
		}
	}
	else{
		$login = "";
		$email = "";
	}
}
?>


<h2>Register</h2>

<form action ="user_register.php" target="_self" method="post">

Login:</br><input type="text" name="login" value="<?=$login ?>" required></br>
Password:</br><input type="password" name="password" required></br>
Repeat password:</br><input type="password" name="password2" required></br>
E-Mail:</br><input type="email" name="email" value="<?=$email ?>" required></br>

<input type="submit" value="Register">
</form>
</div>
</body>
</html>
