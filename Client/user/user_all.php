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

<?php
if(!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator"){
	echo "Error. You don't have permission to view this page!";
	die();
}

$apiResult = apiRequest("users", "GET");
$response = $apiResult["Body"];
$statusCode = $apiResult["Status"];
$users = json_decode($response, true);
if ($statusCode != 200) {
    echo "Error. Couldn't get data from database";
    die();
}
foreach ($users as $user):
?>

	<p><?=$user["Login"]?></p></br>
	<a href="<?="user_update.php?id=" . $user['ID']?>" >Update </a>
	<a href="<?="user_delete.php?id=" . $user['ID']?>" >Delete </a>
	<a href="<?="../stats/stats_clear.php?id=" . $user['ID']?>" >Clear stats </a>
	</br>

<?php endforeach; ?>
</div>

</body>

</html>