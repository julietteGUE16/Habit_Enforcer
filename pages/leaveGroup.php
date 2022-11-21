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


// si plus personnes dans le groupe il faut delete le groupe : ici on calcul la taille du groupe
$getSizeGroup = $bdd->prepare('SELECT * FROM users WHERE id_group = ?');
$getSizeGroup->execute(array($idGroupTemp));
$fetchU = $getSizeGroup->fetch();

echo "test = ". $getSizeGroup->rowCount();
if ($getSizeGroup->rowCount() == 1) { 
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $deleteGroup = $bdd->prepare('DELETE FROM groupes WHERE id_group = ?');
        $deleteGroup->execute(array($idGroupTemp));    
}

$UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
$UpdateUser->execute(array(NULL, $_SESSION['id_user']));



header('Location: menu.php');
?>