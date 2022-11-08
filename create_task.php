<?php

//todo : page create task
//vérifier si besoin /!\
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur


 /*
        UNE TASK :
            - id_task
            - name
            - type
            - level
            - isdaily
            - day
            - id_users
            - isvalid
        */


if(isset($_POST['btn'])){//nom du bouton
    
    if(!empty($_POST['name']) AND !empty($_POST['type'])AND !empty($_POST['level'])){

        $type = $_POST['type'];
        $level = $_POST['level'];
        $name = htmlspecialchars($_POST['name']);
        
        if($_POST['periode'] == "Quotidienne"){
             $isdaily = true; 
             $day = $_POST['day'];
        } else {
            $isdaily = false;
            $day = NULL;
        }
        //TODO : verif que cela marche
        $id_users = $_SESSION['id_users'];
        $isvalid = false;
       
        //TODO : 
        $insertUser = $bdd->prepare('INSERT INTO task(day,id_users,isdaily,isvalid,level,name,type)VALUES(?,?,?,?,?,?,?)');
        $insertUser->execute(array($day, $id_users, $isdaily, $isvalid, $level, $name, $type));

    }else{
        echo "Veuillez compléter tous les champs..";
    }
    
}



//TODO : liste de choix parmis les type of task
//TODO rendre invisible le label jour sauf si on select quotidien

?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <meta charset="utf-8">
</head>
<body>

<h4>
Create your custom task !
</h4>
<br/><br/>

<form method="POST" action="" align="center">
<p>
nomme ta tâche :
</p>
<input type="text" name ="name" required="required"  >
<br/>


<br/><br/>
<h3 >Périodicité de la tâche :</h3>
<SELECT name="periode" size="1">
<option value="" disabled selected>...</option>
<option value="Quotidienne">Quotidienne</option>
<option value="hebdomadaire">hebdomadaire</option>
</SELECT>
<br/><br/>



<h3 >si hebdomadaire, choix du jour :</h3>
<SELECT name="day" size="1">
<option value="" disabled selected>...</option>
<option value="Lundi">Lundi</option>
<option value="Mardi">Mardi</option>
<option value="Mercredi">Mercredi</option>
<option value="Jeudi">Jeudi</option>
<option value="Vendredi">Vendredi</option>
<option value="Samedi">Samedi</option>
<option value="Dimanche">Dimanche</option>

</SELECT>
<br/><br/>

<h3>niveau de difficulté:</h3>
<SELECT name="level" size="1">
<option value="" disabled selected>...</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</SELECT>
<br/><br/>


<h3>fait ton choix de tâche :</h3>
<SELECT name="type" size="1">
<option value="" disabled selected>...</option>
<option value="sports">sports</option>
<option value="work">work</option>
<option value="task">task</option>
<option value="social">social</option>
<option value="alimentation">alimentation</option>
<option value="fun">fun</option>
<option value="other">other</option>


</SELECT>

<br/><br/>
<br/><br/>
<br/><br/>
<input type="submit" name="btn" value = "create task!" >


</form>
</body>
</html>