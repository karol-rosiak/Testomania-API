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
include '../nav.php';
include '../curl.php';
require ('../lib/password.php');
if (!isset($_SESSION['Logged'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $postArray = array("Login" => $login);
        $apiResult = apiRequest("users/$login/login", "GET", $postArray);
        $response = $apiResult["Body"];
        $response = json_decode($response);
        $statusCode = $apiResult["Status"];
        if ($statusCode != 200) {
            if ($response != NULL) echo "Error: " . $response->error . "</br>";
            else echo "Error: couldn't connect to the server </br>";
        } else {
            $passwordConfirm = $response[0]->Password;
            if (password_verify($password, $passwordConfirm)) {
                echo "Logged in successfully!";
                $_SESSION["ID"] = $response[0]->Id;
                $_SESSION["Logged"] = $login;
                $_SESSION["Rank"] = $response[0]->Rank;
                die();
            } else {
                echo "Wrong username or password! </br>";
            }
        }
    } else {
        $login = "";
    }
} else {
    echo '<br />You are already logged in!';
    die();
}
?>
<br />
<form action ="user_login.php" target="_self" method="post"> 
Login:<input type="textbox" name="login" value = "<?=$login ?>"> </br>
Password:<input type="password" name="password" > </br><br />
<input type="submit" value="Log in">
</form>
</div>
</body>
</html>