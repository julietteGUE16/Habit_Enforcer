<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 
$idGroupTemp = $_SESSION["id_group"];
$_SESSION["id_group"]= null;   
//delete les tâches du user
$deleteGroup= $bdd->prepare('DELETE FROM tasks WHERE id_user = ? ');
$deleteGroup->execute(array($_SESSION["id_user"]));
//delete les invitations en attente demandé aux autres car on quitte le groupe
$deleteInvit = $bdd->prepare('DELETE FROM invit WHERE host_pseudo = ? ');
$deleteInvit->execute(array($_SESSION['pseudo']));
// si plus personnes dans le groupe il faut delete le groupe 
$getSizeGroup = $bdd->prepare('SELECT * FROM users WHERE id_group = ?');
$getSizeGroup->execute(array($idGroupTemp));

if ($getSizeGroup->rowCount() == 1) { 
    //suppression du groupe si on quitte en étant le dernier
    $deleteGroup= $bdd->prepare('DELETE FROM groupes WHERE id_group = ? ');
    $deleteGroup->execute(array($idGroupTemp));
}

$UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?,last_task_creation = ?  WHERE id_user = ? ');
$UpdateUser->execute(array(NULL, NULL, $_SESSION['id_user']));
$_SESSION['last_task_creation'] = null;
header('Location: menu.php');
?>