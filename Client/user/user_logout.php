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

<?php

if(isset($_SESSION['Logged']))
{
			session_destroy();
			echo '<br />You were succssefully logged off!';
}
else
{
	echo 'Error';  
}

?>
</div>
</body>
</html>