<?php

//todo : page create task
//vérifier si besoin /!\
session_start();



//TODO : liste de choix parmis les type of task

?>


<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
</head>
<body>

<p>
Create your custom task :
</p>
<br/><br/>

<form method="POST" action="" align="center">
<p>
nomme ou décrit ta tâche :
</p>
<input type="text" name ="name"  >
<br/>


<br/><br/>
<label for="type task">périodicité de la tâche :</label>
<SELECT name="nom" size="1">
<OPTION>...
<OPTION>Quotidienne
<OPTION>hebdomadaire
</SELECT>
<br/><br/>



<label for="type task">si hebdomadaire, choix du jour :</label>
<SELECT name="nom" size="1">
<OPTION>...
<OPTION>Lundi
<OPTION>Mardi
<OPTION>Mercredi
<OPTION>Jeudi
<OPTION>Vendredi
<OPTION>Samedi
<OPTION>Dimanche
</SELECT>
<br/><br/>

<label for="type task">niveau de difficulté:</label>
<SELECT name="nom" size="1">
<OPTION>...
<OPTION>1
<OPTION>2
<OPTION>3
</SELECT>
<br/><br/>
<label for="type task">fait ton choix de tâche :</label>
<SELECT name="nom" size="1">
<OPTION>...
<OPTION>sports
<OPTION>work
<OPTION>study
<OPTION>task
<OPTION>social
<OPTION>alimentation
<OPTION>fun
<OPTION>other
</SELECT>

<br/><br/>
<br/><br/>
<br/><br/>
<input type="submit" name="task_creator" value = "create task!" >


</form>
</body>
</html>