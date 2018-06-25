
<!DOCTYPE html>
<html>
<head>
<title>Testomania</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>

<?php
//session_start();
?>

<div id="container">
<?php
include '../header.php';
include '../nav.php';
include '../curl.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die();
}

if(!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator"){
	echo "Error. You don't have permission to view this page!";
	die();
}

$apiResult = apiRequest("stats/$id/clear", "PUT");
$response = $apiResult["Body"];
$statusCode = $apiResult["Status"];
$response = json_decode($response);
if ($statusCode != 200) {
    if (property_exists($response,"error")) echo "Error: " . $response->error . "</br>";
    else echo "Error: couldn't connect to the server </br>";
} else {
    echo "Cleared successfully!</br>";
}
?>

<a href="../user/user_all.php">Go back </a></br>



</html>
