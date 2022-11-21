<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 
$idGroupTemp = $_SESSION["id_group"];
$_SESSION["id_group"]= null;   
//delete les tâches du user
$deleteGroup= $bdd->prepare('DELETE FROM tasks WHERE id_user = ? ');
$deleteGroup->execute(array($_SESSION["id_user"]));
//delete les invitations en attente demandé aux autres car on quitte le groupe
$deleteInvit = $bdd->prepare('DELETE FROM invit WHERE id_user = ? ');
$deleteInvit->execute(array($_SESSION['id_user']));
// si plus personnes dans le groupe il faut delete le groupe 
$getSizeGroup = $bdd->prepare('SELECT * FROM users WHERE id_group = ?');
$getSizeGroup->execute(array($idGroupTemp));

//todo : si groupe delete on change last_tast_creation dans user ??


//todo : delete historique défaite
if ($getSizeGroup->rowCount() < 0) { 
    
    
} else {
    //suppression du groupe si on quitte en étant le dernier
    $deleteGroup= $bdd->prepare('DELETE FROM groupes WHERE id_group = ? ');
    $deleteGroup->execute(array($idGroupTemp));
}

$UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
$UpdateUser->execute(array(NULL, $_SESSION['id_user']));
header('Location: menu.php');
?>