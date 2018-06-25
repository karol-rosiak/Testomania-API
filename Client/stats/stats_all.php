<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body>
<div id="container" >

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php include '../curl.php'; ?>
</br>

<?php
if(!isset($_POST["SortBy"])){
	$apiResult = apiRequest("stats", "GET");
}
else{
	$sortBy = $_POST["SortBy"];
	$sortType = $_POST["SortType"];
	$apiResult = apiRequest("stats/ranking/$sortBy/$sortType", "GET");
}

$response = $apiResult["Body"];
$statusCode = $apiResult["Status"];
$stats = json_decode($response, true);
if ($statusCode != 200) {
    echo "Error. Couldn't get data from database";
    die();
}
?>

<form action="stats_all.php" method="POST" >
	<select name="SortBy">
		<option value="Completed">Tests completed </option>
		<option value="Points">Points earned </option>
		<option value="Login">Login </option>
	</select>
	<select name="SortType">
		<option value="ASC">Ascending </option>
		<option value="DESC">Descending </option>
	</select>
	<input type="submit" value="sort" />
</form>
</br>
<?php
$counter = 1;
foreach ($stats as $stat):
?>
	<?=$counter?>. <p><?=$stat["Login"]?></p></br>
	<p>Tests completed: <?=$stat["Completed"]?></p></br>
	<p>Points earned: <?=$stat["Points"]?></p></br>
	</br>

<?php
$counter++;
endforeach; ?>
</div>

</body>

</html>