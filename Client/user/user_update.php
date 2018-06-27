<!DOCTYPE html>
<html>
<head>
<title>Testomania</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>

<div id="container">

<?php 
include '../header.php'; 
include '../nav.php'; 
include '../curl.php'; 

if(!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator"){
	echo "Error. You don't have permission to view this page!";
	die();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die();
}

if(isset($_POST["Login"])){
		$login = $_POST["Login"];
		$email = $_POST["Email"];

		$errors = array();
		
	#	if(!preg_match($_POST["login"],"#^[A-Za-z][A-Za-z1-9_]+[A-Za-z1-9]$#"))
	#		$error[] = "Invalid login. Use only A-Z, 0-9 and _ characters!";
		
		if(strlen($login )<6)
			$errors[] = "Login is too short. Minimum length is 6 characters!";
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			$errors[] = "Invalid email format!"; 
		
		if(count($errors) == 0){
			$postArray = array(
								"Login" => $login,
								"Email" => $email
								);
								
			$apiResult = apiRequest("users/$id","PUT",$postArray);
			$response = $apiResult["Body"];
			$response = json_decode($response);
			$statusCode = $apiResult["Status"];
			if($statusCode != 200){
				if(property_exists($response,"error"))
					echo "Error: " . $response->error . "</br>";
				else
					echo "Couldn't get data from the database </br>";
			}
			else{
				echo "User updated successfully!";
			}
		}
		else{
			foreach($errors as $error) echo $error . "</br>";
		}
}

//get category name from database
$apiResult = apiRequest("users/id/$id", "GET");
$response = $apiResult["Body"];
$response = json_decode($response, true);
$statusCode = $apiResult["Status"];
if ($statusCode != 200) {
    if (property_exists($response,"error")) echo "Error: " . $response->error . "</br>";
    else echo "Error: couldn't connect to the server </br>";
    die();
} else {
    $user = $response[0];
}
?>

<br />
Update user:</br></br>
<form action ="<?="user_update.php?id=" . $id?>" target="_self" method="POST">

Login:</br> <input type="textbox" value="<?=$user['Login']?>" name="Login" required></br>
Email:</br> <input type="textbox" value="<?=$user['Email']?>" name="Email" required></br>

<input type="submit" value="Save user">
<input type="reset" value="Reset!">
</form>


</html>
