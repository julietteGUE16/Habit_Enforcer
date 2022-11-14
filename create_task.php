<?php

//todo : vérif type écrire (upper case, lower case ,etc...)
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
            - jour
            - id_users
            - isvalid
        */

//TODO : do a function ???? createTask () ....
if(isset($_POST['btn'])){//nom du bouton
    
    if(!empty($_POST['name']) AND !empty($_POST['type'])AND !empty($_POST['level'])){

        $style = $_POST['type'];
        $niveau = $_POST['level'];
        $nom = htmlspecialchars($_POST['name']);
        //echo "periode = ". $_POST['periode'] .'||';
        if($_POST['periode'] == "Quotidienne"){
            $jour = NULL;
             $isdaily = true;
            
        } else {
            if(!empty($_POST['jour'])){
            } else {
                echo "choisi un jour";
            }
            $isdaily = false;
            $jour = $_POST['jour'];
           
        }
       

        $id_users = $_SESSION['id_users'];
        $isvalid = false;

       if( $jour == null){
        //echo "jour est nul ||";
       }

       echo "user = " . $id_users. " | jour = ". $jour . " | isdaily = ". $isdaily . " | isvalid = ". $isvalid . " | niveau = ". $niveau . " | nom = ". $nom . " | style = ". $style. "\n";
    
       $insertTask = $bdd->prepare('INSERT INTO task(isvalid,nom,style,niveau,isdaily,jour,id_users)VALUES(?,?,?,?,?,?,?)');
       echo "passage : 1\n";
       $insertTask->execute(array($isvalid?1:0,$nom,$style,$niveau,$isdaily?1:0,$jour,$id_users));
       echo "passage : 2\n";
       $recupTask = $bdd->prepare('SELECT * FROM task WHERE nom = ? ');
       $recupTask->execute(array($nom));
       if($recupTask->rowCount() > 0){
        $_SESSION['nom'] = $nom;
        $_SESSION['id_task'] = $recupTask->fetch()['id_task'];
    }
    
    header('Location: menu.php');
        
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
<SELECT name="jour" size="1">
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