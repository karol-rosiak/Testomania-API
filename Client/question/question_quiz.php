<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

</head>

<body>
<div id="container" >


<?php
include '../header.php'; 
include '../nav.php'; 
include '../curl.php';

function calculatePoints($questions, $answers){
	$points = 0;
	$maxPoints = count($questions);
	foreach($questions as $question){
		$id = $question["ID"];
		if(array_key_exists($id,$answers) && strtolower($question["Correct"])==strtolower($answers[$id]))
			$points++;
	}
	if($points/$maxPoints>=0.50)
		echo "<p style='color:lightgreen'>You selected $points/$maxPoints good answers!</p> </br></br>";
	else
		echo "<p style='color:red'>You selected $points/$maxPoints good answers!</p> </br></br>";
	if(isset($_SESSION["Logged"])){
		$postData = array(
						   "Login" => $_SESSION["Logged"],
						   "Points" => $points
						  );
		$apiResult = apiRequest("stats", "PUT",$postData);
		$response = $apiResult["Body"];
		$statusCode = $apiResult["Status"];
		$questions = json_decode($response, true);
		$_SESSION["questions"] = $questions;
		if ($statusCode != 200) {
			echo "Error. Couldn't insert stats to database </br>";
		}
	}
}

function checkAnswer($question, $answers,&$color){
	$id = $question["ID"];
	if(array_key_exists($id,$answers) && strtolower($question["Correct"])==strtolower($answers[$id])){
		echo "<p style='color:lightgreen'>You selected the correct answer! (Answer " . strtoupper($question["Correct"]) . ")</p> </br>";
		$color[$answers[$id]] = "goodanswer";
	}else{
		echo "<p style='color:red'>You selected the wrong answer! (Correct answer " . strtoupper($question["Correct"]) . ")</p> </br>";
		$color[$question["Correct"]] = "goodanswer";
		if(array_key_exists($id,$answers))
		$color[$answers[$id]] = "badanswer";
	}
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"])) {
	$checkingAnswers = true;
    $questions = $_SESSION["questions"];
}else{
	$checkingAnswers = false;
	$apiResult = apiRequest("questions/random/5", "GET");
	$response = $apiResult["Body"];
	$statusCode = $apiResult["Status"];
	$questions = json_decode($response, true);
	$_SESSION["questions"] = $questions;
	if ($statusCode != 200) {
		echo "Error. Couldn't get data from database";
		die();
	}
}

$counter = 1;
?>

<h2>Choose one answer:</h2>
<form action="question_quiz.php" method="post">
<?php 
if($checkingAnswers) calculatePoints($questions,$_POST);
foreach($questions as $question){
	$color = array("A"=>"answer","B"=>"answer","C" => "answer", "D" => "answer");
	if($checkingAnswers){
		checkAnswer($question,$_POST,$color);
	}
		
	echo $counter . ". " . $question["Question"] . "</br>";

	for($answer = "A";$answer <="D";$answer++){
		if(!$checkingAnswers)
			echo"<input type='radio' value='$answer' name='" . $question['ID'] . "'>";
		echo"<p class='$color[$answer]'>$answer. $question[$answer]</p> </br>";
	}
	echo "</br>";
	$counter++;
}

if($checkingAnswers)
	echo "<input type='submit' name='reset' value='Go' style='margin-bottom:10px;'>";
else 
	echo "<input type='submit' name='check' value='Go' style='margin-bottom:10px;'>";

?>


</form>
</div>

</body>

</html>