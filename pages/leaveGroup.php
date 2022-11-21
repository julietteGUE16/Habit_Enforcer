<?php

session_start();



$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 
$idGroupTemp = $_SESSION["id_group"];
$_SESSION["id_group"]= null;  

 
//delete les tâches du user
$deleteTask= $bdd->prepare('DELETE FROM tasks WHERE id_user = ? ');
$deleteTask->execute(array($_SESSION["id_user"]));
//delete les invitations en attente demandé aux autres car on quitte le groupe
$deleteInvit = $bdd->prepare('DELETE FROM invit WHERE id_user = ? ');
$deleteInvit->execute(array($_SESSION['id_user']));


//delete l'historique des points perdu
$deleteHist = $bdd->prepare('DELETE FROM historical WHERE id_user = ? ');
$deleteHist->execute(array($_SESSION['id_user']));

//todo : si groupe delete on change last_tast_creation dans user ??


// si plus personnes dans le groupe il faut delete le groupe : ici on calcul la taille du groupe
$getSizeGroup = $bdd->prepare('SELECT * FROM users WHERE id_group = ?');
$getSizeGroup->execute(array($idGroupTemp));
$fetchU = $getSizeGroup->fetch();
//TODO : en train de count le nombre d eperosnne qui reste dans le groupe pour savoir si il faut le delete
echo "test = ". $fetchU[0];
if ($getSizeGroup->rowCount() > 0) { 
    
    
    if(count($fetchU[0]) <= 1){

        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $deleteGroup = $bdd->prepare('DELETE FROM groupes WHERE id_group = ?');
        $deleteGroup->execute(array($idGroupTemp));
    }
    

   // $monGroupe = new Group($idGroupTemp, $description , 0 ,, 0 );
  
   // $monGroupe->RemoveGroupToDataBase();
    //unset($monGroupe);  
    
}

$UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
$UpdateUser->execute(array(NULL, $_SESSION['id_user']));



//header('Location: menu.php');
?>