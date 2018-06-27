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

if(!isset($_SESSION["Logged"]) || $_SESSION["Rank"] != "Administrator"){
	echo "Error. You don't have permission to view this page!";
	die();
}
if(isset($_GET['id'])){
	$id = $_GET['id'];
} else{
	die();
}
if (isset($_POST['Question'])) {
    $postArray = array(
						"Question" => $_POST['Question'], 
						"A" => $_POST['A'], 
						"B" => $_POST['B'], 
						"C" => $_POST['C'], 
						"D" => $_POST['D'], 
						"Correct" => $_POST['Correct'], 
						"Category" => $_POST['Category']
						);
    $apiResult = apiRequest("questions/$id", "PUT", $postArray);
    $response = $apiResult["Body"];
    $statusCode = $apiResult["Status"];
    if ($statusCode != 200) {
        if (property_exists($response,"error")) 
			echo "Error: " . $response->error . "</br>";
        else 
			echo "Error: couldn't connect to the server </br>";
    } else {
        echo "Updated successfully!</br>";
    }
}
//get cquestion to update
$apiResult = apiRequest("questions/one/$id", "GET");
$response = $apiResult["Body"];
$response = json_decode($response, true);
$statusCode = $apiResult["Status"];
if ($statusCode != 200) {
    if (property_exists($response,"error")) 
		echo "Error: " . $response->error . "</br>";
    else 
		echo "Error: couldn't connect to the server </br>";
    die();
} else {
    $question = $response[0];
} 
//get categories
$apiResult = apiRequest("categories", "GET");
$response = $apiResult["Body"];
$response = json_decode($response, true);
$statusCode = $apiResult["Status"];
if ($statusCode != 200) {
    if (property_exists($response,"error")) 
		echo "Error: " . $response->error . "</br>";
    else 
		echo "Error: couldn't connect to the server </br>";
    die();
} else {
    $categories = $response;
} 



?>
<br />
Update question:</br></br>
<form action ="<?="question_update.php?id=" . $id?>" target="_self" method="POST" enctype="multipart/form-data">

Question: </br><textarea rows="4" class="txtbox" name="Question" required><?=$question["Question"] ?></textarea></br>
Answer A:</br> <textarea rows="4" class="txtbox" name="A" required><?=$question["A"] ?></textarea></br>
Answer B:</br> <textarea rows="4" class="txtbox" name="B" required><?=$question["B"] ?></textarea></br>
Answer C:</br> <textarea rows="4" class="txtbox" name="C" required><?=$question["C"] ?></textarea></br>
Answer D:</br> <textarea rows="4" class="txtbox" name="D" required><?=$question["D"] ?></textarea></br>
Correct answer:

<select name="Correct">
  <option value="A" <?php if ($question["Correct"] == "A") echo 'selected' ; ?> >A</option>
  <option value="B" <?php if ($question["Correct"] == "B") echo 'selected' ; ?> >B</option>
  <option value="C" <?php if ($question["Correct"] == "C") echo 'selected' ; ?> >C</option>
  <option value="D" <?php if ($question["Correct"] == "D") echo 'selected' ; ?> >D</option>
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
