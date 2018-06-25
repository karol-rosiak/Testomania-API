<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body onload="menuHighlight()">
<div id="container" >

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php include '../curl.php'; ?>
</br>

<h2>Add category:</h2>

<a href="category_add.php">Add category</a>

<h2>Delete or update categories:</h2>

<?php
if(!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator"){
	echo "Error. You don't have permission to view this page!";
	die();
}

$apiResult = apiRequest("categories", "GET");
$response = $apiResult["Body"];
$statusCode = $apiResult["Status"];
$categories = json_decode($response, true);
if ($statusCode != 200) {
    echo "Error. Couldn't get data from database";
    die();
}
foreach ($categories as $category):
?>

	<p id='tresc'><?=$category["Name"] ?></p></br>
	<a href="<?="category_update.php?id=" . $category['ID']?>" >Update </a>
	<a href="<?="category_delete.php?id=" . $category['ID']?>" >Delete </a>
	</br>

<?php endforeach; ?>
</div>

</body>

</html>