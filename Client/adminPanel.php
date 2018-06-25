<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body>

<div id="container">

<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>

<?php 
if(!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator"){
	var_dump($_SESSION);
	echo "Error. You don't have permission to view this page!";
	die();
}
?>

</br>

<a href="user/user_all.php">Users </a> </br>
<a href="category/category_all.php">Categories </a> </br>
<a href="question/question_all.php">Questions </a> </br>

</div>
</body>

</html>