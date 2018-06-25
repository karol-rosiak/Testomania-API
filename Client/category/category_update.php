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

//update the category with given data
if (isset($_POST['Category'])) {
    $postArray = array("Category" => $_POST['Category']);
    $apiResult = apiRequest("categories/$id/update", "PUT", $postArray);
    $response = $apiResult["Body"];
    $statusCode = $apiResult["Status"];
    if ($statusCode != 200) {
        if ($response != NULL) echo "Error: " . $response->error . "</br>";
        else echo "Error: couldn't connect to the server </br>";
    } else {
        echo "Updated successfully!</br>";
    }
}
//get category name from database
$apiResult = apiRequest("categories/$id", "GET");
$response = $apiResult["Body"];
$response = json_decode($response, true);
$statusCode = $apiResult["Status"];
if ($statusCode != 200) {
    if ($response != NULL) echo "Error: " . $response->error . "</br>";
    else echo "Error: couldn't connect to the server </br>";
    die();
} else {
    $category = $response[0];
}
?>

<br />
Update category:</br></br>
<form action ="<?="category_update.php?id=" . $id?>" target="_self" method="POST">

Category:</br> <input type="textbox" value="<?=$category['Name']?>" name="Category" required></br>

<input type="submit" value="Save category">
<input type="reset" value="Reset!">
</form>


</html>
