<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body>

<div id="container">
<?php
include '../header.php'; 

$loggedOut = false; 
if(isset($_SESSION['Logged'])){
	unset($_SESSION['Logged']);
	session_destroy();
	$loggedOut = true;
}

include '../nav.php'; 

if($loggedOut) 	echo "<br />You were succssefully logged off!";
else echo "Error</br>";

?>

</div>
</body>
</html>