<!DOCTYPE html>
<html>

<head>
<title>Testomania</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../style.css">

<script>

var radios = document.getElementsByName('odpowiedzi');
var odpowiedz = document.getElementsByClassName("odpowiedz");
var wynik = document.getElementById("wynik");
var daneserwer;
var dane_tablica;
var poprawna;

//==============================Ajax======================
function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      
	  			document.getElementById("wynik").innerHTML ='';
for (var k = 0, length = radios.length; k < length; k++) {
			radios[k].disabled = false;
			radios[k].checked = false;
			document.getElementsByClassName("odpowiedz")[k].style.color = 'black';

			
}
	  
     daneserwer = JSON.parse(this.responseText);
	console.log();
	 
	document.getElementById("tresc").innerHTML= 'ID pytania: ' + daneserwer[0].ID + '.</br>' + daneserwer[0].Question ;

	odpowiedz[0].innerHTML = daneserwer[0].A;
	odpowiedz[1].innerHTML = daneserwer[0].B;
	odpowiedz[2].innerHTML = daneserwer[0].C;
	odpowiedz[3].innerHTML = daneserwer[0].D;
	poprawna = daneserwer[0].Correct;
    }
  }
  xhttp.open("GET", "question_one_2.php", true);
  xhttp.send();
}
//=================================================


function sprawdzanie()
{

for (var i = 0, length = radios.length; i < length; i++) {
    if (radios[i].checked) {
        // do whatever you want with the checked radio
        if(radios[i].value.toUpperCase() == poprawna.toUpperCase() )

			{
				document.getElementById("wynik").style.color = 'lightgreen';
				document.getElementById("wynik").innerHTML ='Wybrałeś poprawną odpowiedź! (Odpowiedź ' + poprawna.toUpperCase() + ' ) </br>';
				for(var przycisk = 0; przycisk <4; przycisk++)
				{
					radios[przycisk].disabled = true;

				}

			}
			else
			{
				document.getElementById("wynik").innerHTML ='Wybrałeś błędną odpowiedź! (Poprawna odpowiedź ' + poprawna.toUpperCase() + ' ) </br>';
				document.getElementById("wynik").style.color = 'red';
					for(var przycisk =0; przycisk <4; przycisk++)
				{
					radios[przycisk].disabled = true;

				}
			}

        break;
    }
}

	for(var j=0; j<4;j++)
{
	if(document.getElementsByName("odpowiedzi")[j].value.toUpperCase() == poprawna.toUpperCase() )
	{
		document.getElementsByClassName("odpowiedz")[j].style.color = 'lightgreen';

	}
	else
	{
		document.getElementsByClassName("odpowiedz")[j].style.color = 'red';
	}

}


}


</script>


</head>

<body onload="loadDoc()">

<?php
session_start();
?>

<div id="container">

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<form>

<h2>Wybierz jedną poprawną odpowiedź:</h2>

<p id="wynik"> </p>

<p id="tresc">scacsasac</p></br>
<input type="radio" value="a" name="odpowiedzi" onclick="sprawdzanie()"><p class="odpowiedz"></p> </br>
<input type="radio" value="b" name="odpowiedzi" onclick="sprawdzanie()"><p class="odpowiedz"></p></br>
<input type="radio" value="c" name="odpowiedzi" onclick="sprawdzanie()"><p class="odpowiedz"></p></br>
<input type="radio" value="d" name="odpowiedzi" onclick="sprawdzanie()"><p class="odpowiedz"></p></br>
<button type="button" onclick="loadDoc()">Kolejne pytanie</button>
</form>

</body>

</html>
