<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body>
<div id="container">

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php include '../curl.php'; ?>
<?php
		
$login = "";

if($_GET['user']!="")
{
	$login = $_GET['user'];
}
elseif(isset($_SESSION['Logged']))
{
	$login = $_SESSION['Logged'];
}
else{
	echo "No user to show </br>";
}

if($login !=""){
	$apiResult = apiRequest("stats/name/$login","GET");
	$response = $apiResult["Body"];
	$response = json_decode($response);

	$statusCode = $apiResult["Status"];

	if($statusCode != 200){
		if($response !=NULL)
			echo "Error: " . $response->error . "</br>";
		else
			echo "Error" . PHP_EOL;
	}
	else{
		echo "User: " . $response[0]->Login . "</br>";
		echo "Tests completed: " . $response[0]->Completed . "</br>";
		echo "Points earned: " . $response[0]->Points . "</br>";
		
	}
}


?>

</div>
</body>

</html>