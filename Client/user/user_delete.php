
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

$apiResult = apiRequest("users/$id", "DELETE");
$response = $apiResult["Body"];
$statusCode = $apiResult["Status"];
if ($statusCode != 204) {
    if (property_exists($response,"error")) echo "Error: " . $response->error . "</br>";
    else echo "Error: couldn't connect to the server </br>";
} else {
    echo "Deleted successfully!</br>";
}
?>

<a href="user_all.php">Go back </a></br>



</html>
