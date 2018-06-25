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

if (isset($_POST['Category'])) {
    $postArray = array("Category" => $_POST['Category']);
    $apiResult = apiRequest("categories/add", "POST", $postArray);
    $response = $apiResult["Body"];
    $response = json_decode($response);
    $statusCode = $apiResult["Status"];
    if ($statusCode != 201) {
        if(property_exists($response,"error")) echo "Error: " . $response->error . "</br>";
        else echo "Error: couldn't connect to the server </br>";
    } else {
        echo "The category was added successfully!</br>";
    }
}
?>
<br />
Add new category:</br></br>
<form action ="category_add.php" target="_self" method="POST">

Category:</br> <input type="textbox" name="Category" required></br>

<input type="submit" value="Save category">
<input type="reset" value="Reset!">
</form>

</html>
