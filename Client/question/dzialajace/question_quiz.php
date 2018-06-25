<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css"/>
<title>Testomania</title>

<style>
p
{
	display:inline;
}
</style>

<script>
//przeładowuje strone gdy klika sie przycisk "wróć"
    setTimeout(function () {
        var el = document.getElementById('alwaysFetch');
        el.value = el.value ? location.reload() : true;
    }, 0);
	
	window.onbeforeunload = function() {
  return "Nie będziesz mógł już zmienić swoich odpowiedzi. Kontynuować?";
};


function kek(){
	for(i=1;i<=40;i++)
	{
		   var array = document.getElementsByName(i);
   var randomNumber=Math.floor(Math.random()*4);

   array[randomNumber].checked = true;
		
	}

}

</script>

</head>

<body onload="menuHighlight()">
<div id="container" >

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
</br>
<input type="button" onclick="kek()" name="ruletka" value="ruletka">

<h2>Choose one answer:</h2>
<form action="kilka2.php" method="post">
<?php

$numer = 1;
/*
	foreach($zapytanie as $wiersz){

echo "<p id='tresc'>$numer. $wiersz[1]</p></br>";

if($wiersz[7] != 'none')
{
	echo "<img src='uploads/$wiersz[7]' /> ";
	
}

echo '<hr>';
echo "<input type='radio' value='a' name='$numer'> <p id='a'> A. $wiersz[2]</p>  </br>";
echo '<hr>';
echo "<input type='radio' value='b' name='$numer'> <p id='b'> B. $wiersz[3]</p>  </br>";
echo '<hr>';
echo "<input type='radio' value='c' name='$numer'> <p id='c'> C. $wiersz[4]</p>  </br>";
echo '<hr>';
echo "<input type='radio' value='d' name='$numer'> <p id='d'> D. $wiersz[5]</p>  </br>";
echo '<hr>';

$numer++;
	}
*/
?>

<input type="submit" value="Go" style="margin-bottom:10px;">
<input id="alwaysFetch" type="hidden" /> <!-- do javascriptu przeładowującego strone -->
</form>
</div>

</body>

</html>