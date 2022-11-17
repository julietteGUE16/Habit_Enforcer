<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 
      $UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
      
      $UpdateUser->execute(array(NULL, $_SESSION['id_user']));

      $_SESSION["id_group"]= null;
       

       //TODO : delete les tâches du user
        //delete les invitations en attente
        $deleteInvit = $bdd->prepare('DELETE FROM invit WHERE id_user = ? ');
        $deleteInvit->execute(array($_SESSION['id_user']));

              

        //TODO : si plus personnes dans le groupe il faut delete le groupe + toutes les demandes

        

      header('Location: menu.php');
?>