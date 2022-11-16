<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 
      $UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
      
      $UpdateUser->execute(array(NULL, $_SESSION['id_user']));

      $_SESSION["id_group"]= null;
       

        //TODO : delete nos tâches + afficher un messsage de prévention
      header('Location: menu.php');
?>