<!DOCTYPE html>
<html>

<head>
<title>Testomania</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../style.css">
<script>
    var apiAddress = "http://127.0.0.1:5000/questions/one";

    var radios = document.getElementsByName('answers');
    var answer = document.getElementsByClassName("answer");
    var result = document.getElementById("result");
    var serverdata;
    var dane_tablica;
    var correct;

    //==============================Ajax======================
    function getQuestion() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {

                    document.getElementById("result").innerHTML = '';
                    for (var k = 0, length = radios.length; k < length; k++) {
                        radios[k].disabled = false;
                        radios[k].checked = false;
                        document.getElementsByClassName("answer")[k].style.color = 'black';
                    }

                    serverdata = JSON.parse(this.responseText);

                    document.getElementById("content").innerHTML = 'Question ID: ' + serverdata[0].ID + '</br>' + serverdata[0].Question;

                    answer[0].innerHTML = serverdata[0].A;
                    answer[1].innerHTML = serverdata[0].B;
                    answer[2].innerHTML = serverdata[0].C;
                    answer[3].innerHTML = serverdata[0].D;
                    correct = serverdata[0].Correct;
                }
            }
            xhttp.open("GET", apiAddress, true);
            xhttp.send();
        }
        //=================================================


    function check() {

        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {

                if (radios[i].value.toUpperCase() == correct.toUpperCase()){
                    document.getElementById("result").style.color = 'lightgreen';
                    document.getElementById("result").innerHTML = 'You selected the correct answer! (Answer ' + correct.toUpperCase() + ' ) </br>';
                    for (var i = 0; i < 4; i++) {
                        radios[i].disabled = true;
                    }
                } else {
                    document.getElementById("result").innerHTML = 'You selected the wrong answer! (Correct answer ' + correct.toUpperCase() + ' ) </br>';
                    document.getElementById("result").style.color = 'red';
                    for (var button = 0; button < 4; button++) {
                        radios[button].disabled = true;
                    }
                }
                break;
            }
        }

        for (var j = 0; j < 4; j++) {
            if (document.getElementsByName("answers")[j].value.toUpperCase() == correct.toUpperCase()) {
                document.getElementsByClassName("answer")[j].style.color = 'lightgreen';
            } else {
                document.getElementsByClassName("answer")[j].style.color = 'red';
            }
        }
    }
</script>
</head>

<body onload="getQuestion()">


<div id="container">

<?php
 include '../header.php'; 
 include '../nav.php'; 
 ?>

<form>

<h2>Choose one correct answer:</h2>

<p id="result"> </p>

<p id="content">Loading question...</p></br>
<input type="radio" value="a" name="answers" onclick="check()"><p class="answer"></p> </br>
<input type="radio" value="b" name="answers" onclick="check()"><p class="answer"></p></br>
<input type="radio" value="c" name="answers" onclick="check()"><p class="answer"></p></br>
<input type="radio" value="d" name="answers" onclick="check()"><p class="answer"></p></br>
<button type="button" onclick="getQuestion()">Another one</button>
</form>

</body>

</html>
