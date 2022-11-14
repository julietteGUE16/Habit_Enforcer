<?php

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8', 'root', '');
if(isset($_POST['task_creator'])){
    if(!empty($_POST['name']) AND !empty($_POST['hebdo']) AND !empty($_POST['period']) AND !empty($_POST['difficulte']) AND !empty($_POST['typetask'])){
        $isvalid = false;
        $name = htmlspecialchars($_POST['name']);
        $type = htmlspecialchars($_POST['typetask']);
        $level = $_POST['difficulte'];
        $isdaily = false;
        $day = "Mardi";
        $insertTask = $bdd->prepare('INSERT INTO task(isvalid,`name`,`type`,`level`,isdaily,`day`,id_users)VALUES(?,?,?,?,?,?,?'); 
        $insertTask->execute(array($isvalid,$name,$type,$level,$isdaily,$day,$_SESSION['id_users']));
    }else{
        echo "veuillez compléter tous les champs !";
    }
}

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
<SELECT name="period" size="1">
<OPTION>...
<OPTION>Quotidienne
<OPTION>hebdomadaire
</SELECT>
<br/><br/>



<label for="type task">si hebdomadaire, choix du jour :</label>
<SELECT name="hebdo" size="1">
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
<SELECT name="difficulte" size="1">
<OPTION>...
<OPTION>1
<OPTION>2
<OPTION>3
</SELECT>
<br/><br/>
<label for="type task">fait ton choix de tâche :</label>
<SELECT name="typetask" size="1">
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