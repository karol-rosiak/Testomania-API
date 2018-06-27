<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body>

<div id="container">

<?php
include '../header.php';
include '../curl.php';
require ('../lib/password.php');
if (!isset($_SESSION['Logged'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $postArray = array(
							"Login" => $login,
							"Password" => $password
							);
        $apiResult = apiRequest("users/login", "POST", $postArray);
        $response = $apiResult["Body"];
        $response = json_decode($response);
        $statusCode = $apiResult["Status"];
        if ($statusCode != 200) {
            if ($response != NULL) echo "Error: " . $response->error . "</br>";
            else echo "Error: couldn't connect to the server </br>";
        } else {
                include '../nav.php';
				echo "Logged in successfully!";
                $_SESSION["ID"] = $response[0]->Id;
                $_SESSION["Logged"] = $login;
                $_SESSION["Rank"] = $response[0]->Rank;
				die();
            
        }
    } else {
        $login = "";
    }
} else {
    echo '<br />You are already logged in!';
	include '../nav.php';
    die();
}

include '../nav.php';
?>
<br />
<form action ="user_login.php" target="_self" method="post"> 
Login:</br>
<input type="textbox" name="login" value = "<?=$login ?>"> </br>
Password:</br>
<input type="password" name="password" > </br><br />
<input type="submit" value="Log in">
</form>
</div>
</body>
</html>