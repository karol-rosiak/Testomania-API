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
//add question
if (isset($_POST['Question'])) {
    $postArray = array(
						"Question" => $_POST['Question'], 
						"A" => $_POST['A'], 
						"B" => $_POST['B'], 
						"C" => $_POST['C'], 
						"D" => $_POST['D'], 
						"Correct" => $_POST['Correct'], 
						"Category" => $_POST['Category'], 
						"User" => $_SESSION['Logged']
						);
    $apiResult = apiRequest("questions/add", "POST", $postArray);
    $response = $apiResult["Body"];
    $statusCode = $apiResult["Status"];
    if ($statusCode != 201) {
       if (property_exists($response,"error")) 
		echo "Error: " . $response->error . "</br>";
    else 
		echo "Error: couldn't connect to the server </br>";
    } else {
        echo "Added successfully!</br>";
    }
}
$apiResult = apiRequest("categories", "GET");
$response = $apiResult["Body"];
$response = json_decode($response, true);
$statusCode = $apiResult["Status"];
if ($statusCode != 200) {
    if ($response != NULL) echo "Error: " . $response->error . "</br>";
    else echo "Error: couldn't connect to the server </br>";
    die();
} else {
    $categories = $response;
}
?>
<br />
Add new question:</br></br>
<form action ="question_add.php" target="_self" method="post" enctype="multipart/form-data">

Question: </br><textarea rows="4" class="txtbox" name="Question" required></textarea></br>
Answer A:</br> <textarea rows="4" class="txtbox" name="A" required></textarea></br>
Answer B:</br> <textarea rows="4" class="txtbox" name="B" required></textarea></br>
Answer C:</br> <textarea rows="4" class="txtbox" name="C" required></textarea></br>
Answer D:</br> <textarea rows="4" class="txtbox" name="D" required></textarea></br>
Correct answer:
<select name="Correct">
  <option value="A">A</option>
  <option value="B">B</option>
  <option value="C">C</option>
  <option value="D">D</option>
</select></br></br>

Category:
<select name="Category">
<?php foreach($categories as $category): ?>
		  <option value="<?=$category["Name"] ?>"><?=$category["Name"] ?></option>
<?php endforeach; ?>
</select></br></br>

<input type="submit" value="Save question">
<input type="reset" value="Reset!">
</form>


</html>
