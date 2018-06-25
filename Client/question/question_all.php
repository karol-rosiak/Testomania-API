<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>
</head>

<body onload="menuHighlight()">
<div id="container" >

<?php 
include '../header.php'; 
include '../nav.php'; 
include '../curl.php';
?>
</br>
<h2>Add question:</h2>
<a href="question_add.php">Add question</a></br>

<h2>Delete or update questions:</h2>
<form action="kilka2.php" method="post">
<?php
if (!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator") {
    echo "Error. You don't have permission to view this page!";
    die();
}

$apiResult = apiRequest("questions", "GET");
$response = $apiResult["Body"];
$statusCode = $apiResult["Status"];
$questions = json_decode($response, true);
if ($statusCode != 200) {
    echo "Error. Couldn't get data from database";
    die();
}
$questions = $questions;
foreach ($questions as $question):
?>
		<p id='tresc'><?=$question["Question"] ?></p></br>
		<a href="<?="question_update.php?id=" . $question['ID']?>" >Update </a>
		<a href="<?="question_delete.php?id=" . $question['ID']?>" >Delete </a>
		</br>
		</hr>
		</hr>
<?php endforeach; ?>

</form>
</div>

</body>

</html>