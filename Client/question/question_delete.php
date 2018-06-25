
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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die();
}
if (!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator") {
    echo "Error. You don't have permission to view this page!";
    die();
}
$apiResult = apiRequest("questions/one/$id/delete", "DELETE");
$response = $apiResult["Body"];
$response = json_decode($apiResult["Body"]);
$statusCode = $apiResult["Status"];
if ($statusCode != 204) {
    if (property_exists($response, "error")) echo "Error: " . $response->error . "</br>";
    else echo "Error: couldn't connect to the server </br>";
} else {
    echo "Deleted successfully!</br>";
}
?>

<a href="question_all.php">Go back </a></br>

</html>
