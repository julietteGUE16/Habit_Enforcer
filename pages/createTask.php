<?php

require ('../model/Task.php');
require ('../model/User.php');

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur
$currentDate = date("Y-m-d H:i:s");
//pour faire les test et créer plusieurs tâche à la suite
//$_SESSION['last_task_creation'] = date("22-10-10 01:15:47");
if($_SESSION['last_task_creation'] != null){
  //on obtient un nombre à virgule en jour (si diff = 1 --> 1 jour)
  $diff = (strtotime($currentDate) - strtotime($_SESSION['last_task_creation']))/86400;
  } else {
    $diff = 1;
  }
if(isset($_POST['btn'])){  
    if(abs($diff) >= 1){
      if(!empty($_POST['name']) AND !empty($_POST['category'])AND !empty($_POST['difficulty'])AND !empty($_POST['periode'])){   
       
        $category = $_POST['category'];
        $difficulty = $_POST['difficulty'];
        $daySelect = false;
        $name = htmlspecialchars($_POST['name']);
        //$id_user = $currentUser.getIdUser();
        $id_user = $_SESSION['id_user'];
        $isvalid = false;     
        if($_POST['periode'] == "Quotidienne"){
            $jour = NULL;
            $isdaily = true;
        } else {
          $isdaily = false;
          if(!empty($_POST['jour'])){
            $jour = $_POST['jour'];
            $daySelect = true;
          } else {
            $daySelect = false;
          }   
        }    
            

        if(!$daySelect AND  $_POST['periode'] == "hebdomadaire"){
          //TODO : le replacer correctement 
          ?>
          <h3> il faut selectionner un jour ! </h3>
          <?php

        } else {
          $UpdateUser = $bdd->prepare(' UPDATE users SET last_task_creation = ?  WHERE id_user = ? ');
         $UpdateUser->execute(array($currentDate, $_SESSION['id_user']));
         $_SESSION['last_task_creation'] = $currentDate;
          $task = new Task(null,$isvalid,$name, $category, $difficulty, $id_user, $isdaily, $jour,null);
          $task->addTaskToDataBase();        



          /*------------------------------*/
         //TODO : insert dans notre current user la date de last creat task
         header('Location: menu.php');
        }
        
    }else{
      echo "<script>alert('veuillez compléter tous les champs !')</script>";
    }
    
  }else {
   
    echo "il n'y a pas eu 24h entre 2 créations de tâche !";
  }
    
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/task.css" crossorigin="anonymous">
</head>
<body>

<div class="navbar">
    <div class="profil">
      <button class="open-button" onclick="openForm()">
    <img class="logoUSER" src="https://zupimages.net/up/22/45/xme3.png" />
      <div class="icon">
        <div class="nameUSER">
        <?php 
        echo $_SESSION['pseudo'];?>
        </div>
        <?php
        echo $_SESSION['email'];
        ?>
      </div>
    </button>
    </div>
    <div class="login-popup">
      <div class="form-popup" id="popupForm">
        <form action="/action_page.php" class="form-container">
          <h2>Mon compte</h2><br/><br/>
          <a>Changer de pseudo</a><br/><br/>
          <a href="../pages/deconnexion.php">se déconnecter</a><br/><br/>
          <button type="button" class="btncancel" onclick="closeForm()">Fermer</button>
        </form>
      </div>
    <script>
      function openForm() {
        document.getElementById("popupForm").style.display = "block";
      }

      function closeForm() {
        document.getElementById("popupForm").style.display = "none";
      }
    </script>
      </div>
      <div class="menu">
        <ul>
          <li><a href="../pages/menu.php">Retour au menu !</a></li>
        </ul>
      </div>
    </div>
<section class="createtask">
    <section class="page1">
<div>
<form method="POST" action="" align="center">

<?php 

   if(abs($diff) >= 1){
?>
<input type="text" name ="name" required placeholder="Nom de la tâche" autocomplete="off">
<br/>


<br/><br/>
<SELECT name="periode" size="1">
<option value="" disabled selected>Périodicité de la tâche</option>
<option value="Quotidienne">Quotidienne</option>
<option value="hebdomadaire">hebdomadaire</option>
</SELECT>
<br/><br/>



<SELECT name="jour" size="1">
<option value="" disabled selected>si hebdomadaire, choix du jour</option>
<option value="Lundi">Lundi</option>
<option value="Mardi">Mardi</option>
<option value="Mercredi">Mercredi</option>
<option value="Jeudi">Jeudi</option>
<option value="Vendredi">Vendredi</option>
<option value="Samedi">Samedi</option>
<option value="Dimanche">Dimanche</option>

</SELECT>
<br/><br/>

<SELECT name="difficulty" size="1">
<option value="" disabled selected>niveau de difficulté</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</SELECT>
<br/><br/>

<SELECT name="category" size="1">
<option value="" disabled selected>Dans quelle catégorie ajouterais-tu cette tâche ?</option>
<option value="sport">sport</option>
<option value="travail">travail</option>
<option value="social">social</option>
<option value="alimentation">alimentation</option>
<option value="loisir">loisir</option>
<option value="important">important</option>
<option value="autre">autre</option>
</SELECT>

<br/><br/>
<br/><br/>
<br/><br/>

<button type="submit" href="../pages/createTask.php" name="btn">Créer votre Tâche !</button>
<?php
   } else {
    ?><p>Vous devez attendre 24h entre la création de 2 tâches !</p>

    
   <?php
   }
?>

</form>
    </section>
    </section>
</body>
</html>