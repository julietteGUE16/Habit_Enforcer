<?php

include '..\model\Task.php';

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur




//Message si groupe supprimé : de base à 0
if($_SESSION['know_delete'] == 1 ){

  $UpdateUser = $bdd->prepare('UPDATE users SET know_delete = ?  WHERE id_user = ? ');
  $UpdateUser->execute(array(0, $_SESSION['id_user']));
  echo "<script>alert('Votre score de groupe à atteint moins de 0, il a donc été supprimé')</script>";

} else if($_SESSION['id_group'] != null ){

  $currentDate = date("Y-m-d H:i:s");
    //si task pas faite on l'ajoute à l'historique avec la date et le nombre de point perdu
    //on rempli l'historique avec nos données
    $recupTasks = $bdd->prepare('SELECT * FROM tasks WHERE id_user = ?');
    $recupTasks->execute(array($_SESSION['id_user']));
    $fetchTask = $recupTasks->fetchAll();      
     if ($recupTasks->rowCount() > 0) {
      for($i=0; $i<count($fetchTask); $i++){
      
          //todo: ...verif si tache valid sinon isvalid = false
        $isValid = true;
        //todo :recup difficulté pour faire perdre des points
        $difficulty = 0;
        
        $point=0; //calculer les points perdu

        if(!$isValid){
          $insertHistory = $bdd->prepare('INSERT INTO `historical` (id_group,id_user,nb_point,date_hist) VALUES (?,?,?,?)');
          $resul = $insertHistory->execute(array($_SESSION['id_group'], $_SESSION['id_user'], $point, $currentDate));
        }
      }
    }
 
  //on regarde l'historique
  $diff = (strtotime($currentDate) - strtotime($_SESSION['last_connexion']))/86400;
  $recupHistory = $bdd->prepare('SELECT * FROM historical WHERE id_group = ?');
  $recupHistory->execute(array($_SESSION['id_group']));
  $accumulation = 0;
  $pseudoList = array();
  $pointList = array();
  $fetch = $recupHistory->fetchAll();
  if ($recupHistory->rowCount() > 0) { 
    for($i=0; $i<count($fetch); $i++){
      $diffTemp = (strtotime($currentDate) - strtotime($fetch[$i]['date']))/86400;
      if($diff > $diffTemp){
        $accumulation = $accumulation + ($fetch[$i]['nb_point']);
        $recupPseudo = $bdd->prepare('SELECT pseudo FROM users WHERE id_user = ?');
        $recupPseudo->execute(array($fetch[$i]['id_user']));
        $fetchP = $recupPseudo->fetch();
         if ($recupPseudo->rowCount() > 0) { 
          array_push($pseudoList, $fetchP['pseudo']);
          array_push($pointList, $fetch[$i]['nb_point']);
         }        
      }
    }
    $_SESSION['previous_score'] = $_SESSION['last_score'];
    $_SESSION['last_score'] = $_SESSION['last_score'] + $accumulation;
    $UpdateUser = $bdd->prepare('UPDATE groupes SET last_score = ?   WHERE id_group = ? ');
    $UpdateUser->execute(array($_SESSION['last_score'], $_SESSION['id_group']));
    $lost =  $_SESSION['previous_score'] - $_SESSION['last_score'];
    //todo dans une pop up
    echo "Votre groupe à perdu : ". $lost . " points depuis la derniere fois ";
    for($j=0; $j<count($pseudoList); $j++){
      echo "Le membre : ". $pseudoList[$j] ." à fait perdre ". $pointList[$i]." point(s) depuis la derniere fois ";
    }
  }
 

  if($_SESSION['last_score']< 0){    

    $_SESSION['know_delete'] = 0;
    //change know_delete for next connexion
    $UpdateUser = $bdd->prepare('UPDATE users SET know_delete = ?  WHERE id_group = ? ');
    $UpdateUser->execute(array(1, $_SESSION['id_group']));
    //todo concatener avec au dessus 
    $UpdateUser = $bdd->prepare('UPDATE users SET know_delete = ?  WHERE id_user = ? ');
    $UpdateUser->execute(array(0, $_SESSION['id_user']));
    //TODO : correct ??
    //change id group to null
    $UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_group = ? ');
    $UpdateUser->execute(array(null, $_SESSION['id_group']));
    //lister les id_user qui étaient dans le groupe
    $recupUsersOfGroup = $bdd->prepare('SELECT id_user FROM users WHERE id_group = ?');
    $recupUsersOfGroup->execute(array($_SESSION["id_group"]));
    $fetchU = $recupUsersOfGroup->fetchAll();
     if ($recupUsersOfGroup->rowCount() > 0) { 
      //todo : check if is possible
      //todo : jetais entrain de recup le nombre de user pour faire un each et delete toute les invit .. histo... task ..etc... de chaque user
      foreach ($fetchU['id_user'] as $value) 
      {
        //delete les tâches des users
      $deleteTask= $bdd->prepare('DELETE FROM tasks WHERE id_user = ? ');
      $deleteTask->execute(array($_SESSION["id_user"]));
      //delete les invitations en attente demandé aux autres car on quitte le groupe
      $deleteInvit = $bdd->prepare('DELETE FROM invit WHERE id_user = ? ');
      $deleteInvit->execute(array($_SESSION['id_user']));
      //delete les invitations en attente demandé aux autres car on quitte le groupe
      $deleteHist = $bdd->prepare('DELETE FROM historical WHERE id_user = ? ');
      $deleteHist->execute(array($_SESSION['id_user']));
        
      }
     
     }
    //delete le groupe 
    $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
    $deleteGroup = $bdd->prepare('DELETE FROM groupes WHERE id_group = ?');
    $deleteGroup->execute(array( $_SESSION["id_group"]));
    //change id group user  
    $_SESSION["id_group"]= null;  
    //mettre le current user directement a null et know_delete pas besoin pour lui puisqu'il le sait
    //todo : pop-up : votre score de groupes est < 0
    echo "<script>alert('Votre score de groupe à atteint moins de 0, il a donc été supprimé')</script>";
    //todo : reload la page menu ?
  } 
}

?>


<!DOCTYPE html>
<html>

<head>
  <title>Menu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../Assets/menu.css" crossorigin="anonymous">
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
        <li><a href="#page2">Tâches</a></li>
        <li><a href="#page3">Mon Groupe <?php if($_SESSION['id_group'] != NULL){echo " : ".$_SESSION['name_group'];} ?></a></li>
      </ul>
    </div>
  </div>
  <section class="main">
    <section class="page1" id="page1">
      <div class="intro">
        <h1>Une plateforme pour vous guider dans le modelelage d'un quotidien qui vous ressemble <br /><span><img
              class="logotaroutyn" src="https://zupimages.net/up/22/45/piq7.png" /></span></h1>
        <p class="text">
          Tu trouveras en page "TACHES", des habitudes à créer puis à cocher régulierement !<br />
          Rejoins vite un groupe en page "MON GROUPE" et utilise l'enthousiasme <br />collectif pour tenir tes
          engagements !
          <br>
          <br>
          Site réalisé par 3 étudiants :<br /> Guenard Juliette, Favennec Melaine et Piauger Paul !
        </p>
      </div>

        <div>
            <img class = "photomobile" src="https://zupimages.net/up/22/45/kxzp.png" />
        </div>
      </section>
    </section>
    <section class="page2" id="page2">
      <h2>Tâches</h2>
      <p>Crée et retrouve tes habitudes ici !</p>
          </br>
        <?php
          if($_SESSION['id_group'] != null){

        ?>
        <p class="flex"> <a href="../pages/createTask.php"> nouvelle tâche ? </a> </p></br>
        <?php
          if($_SESSION['last_task_creation'] != null){
  
        ?>
        <div class= "taches">
        <div><img class = "photomobile" src="https://zupimages.net/up/22/45/pr92.png" /></div>
        <div class = "listetaches">
        <?php 
        $recupCount = $bdd->prepare('SELECT COUNT(*) FROM tasks WHERE id_user = ?');
        $recupCount->execute(array($_SESSION['id_user']));
        $fetchC = $recupCount->fetch();
        $_SESSION['nombreTaches'] = $fetchC[0];

        $recupTask = $bdd->prepare('SELECT * FROM tasks WHERE id_user = ?');
        $recupTask->execute(array($_SESSION['id_user']));
        $fetch = $recupTask->fetchAll();?>
        <form action="../pages/menu.php" method="POST" >
          <?php
          $listid = array();
            for($i=0; $i < $_SESSION['nombreTaches']; $i++){
              $_SESSION['nom'] = $fetch[$i]['name_task'];
              $_SESSION['difficulté'] = $fetch[$i]['difficulty'];
              $_SESSION['jour'] = $fetch[$i]['chosen_day'];
              $_SESSION['style'] = $fetch[$i]['category'];
              $_SESSION['idtask'] = $fetch[$i]['id_task'];
              $_SESSION['idvalid'] = $fetch[$i]['isvalid'];
              $listid[$i] =$_SESSION['idtask'];
              $listdif[$i] = $_SESSION['difficulté'];
              $_image = "https://zupimages.net/up/22/46/3wl6.png";
              if($_SESSION['style'] == 'important'){
                $_image = "https://zupimages.net/up/22/46/do4e.png";
              }
              if($_SESSION['style'] == 'sport'){
                $_image = "https://zupimages.net/up/22/46/9dzn.png";
              }
              if($_SESSION['style'] == 'loisir'){
                $_image = "https://zupimages.net/up/22/46/8b8a.png";
              }
              if($_SESSION['style'] == 'alimentation'){
                $_image = "https://zupimages.net/up/22/46/tl8e.png";
              }
              if($_SESSION['style'] == 'social'){
                $_image = "https://zupimages.net/up/22/46/sexb.png";
              }
              if($_SESSION['style'] == 'travail'){
                $_image = "https://zupimages.net/up/22/46/pmtj.png";
              }
              ?>
              <div class="box">
              <div class="tache"><?php echo $_SESSION['nom'];?></div>
              <div class= "niveau"><?php echo "niveau : ".$_SESSION['difficulté']; ?></div>
              <div class= "daily"><?php if($_SESSION['jour']== NULL){echo "Quotidien";}; ?></div>
              <div class= "daily"><?php echo $_SESSION['jour']; ?></div>
              <img class = "iconstyle" src="<?php echo $_image?>" />
              <div class="checkbox" >
                  <input type="checkbox" name="<?php echo $_SESSION['idtask'] ?>" <?php if(isset($_POST[$_SESSION['idtask']])) echo "checked" ; ?>>
              </div>
              </div></br><?php
            }?>
            <div class="submitTask">
                <input type="submit" name= "submitvalid" onclick="appeltest()"  value="Click pour valider !"></div>
            </form>
            <div class= "score">SCORE : <?php
            echo $_SESSION['last_score'];
        ?></div>
            <?php
          }} else {
           ?> 
           <p>Avant de pouvoir créer des tâches il te faut un groupe !</p>
           <br>
           <p>Scroll vers le bas :)</p>
           </br>
           </br>
           </br>
           <?php
            //todo :marche pas
            function appeltest(){
              Task::setvalidtask($listid, $listdif);
           }
          }
        ?>

        </div>
          </div>
          <p>Légende des catégories :</p>
          </br>
          <div align="center">
          <div class="cate">important<img class = "iconstyle" src="https://zupimages.net/up/22/46/do4e.png" /></div>
          <div class="cate">sport<img class = "iconstyle" src="https://zupimages.net/up/22/46/9dzn.png" /></div>
          <div class="cate">travail<img class = "iconstyle" src="https://zupimages.net/up/22/46/pmtj.png" /></div>
          <div class="cate">social<img class = "iconstyle" src="https://zupimages.net/up/22/46/sexb.png" /></div>
          <div class="cate">alimentation<img class = "iconstyle" src="https://zupimages.net/up/22/46/tl8e.png" /></div>
          <div class="cate">loisir<img class = "iconstyle" src="https://zupimages.net/up/22/46/8b8a.png" /></div>
          </div>
    </section>
    <section class="page3" id="page3">
      <h2>Mon Groupe <?php if($_SESSION['id_group'] != NULL){echo " : ".$_SESSION['name_group'];} ?></h2>
      <p>Rejoins un groupe ou suis l'actvité de ton groupe ici !</p>
      <br/>
      <?php
      if($_SESSION['id_group'] == null){
        ?> <p class="flex"> <a href="../pages/manageGroup.php"> créer ou rejoindre un groupe ! </a> </p> <?php
      } else {
        ?> <p class="flex"> <a href="../pages/manageGroup.php"> inviter des users ! </a> </p></br> <?php
        
        ?>
        </br> 
        <div class= "scoregroup" >SCORE DE GROUPE : <?php echo  $_SESSION['last_score']; ?>
        <div class="quitgroup">
              <form action = "leaveGroup.php" name="post">
                
               
                  <input type="submit" onclick="leaveGroup()" name="btnLeave" value="Quitter mon groupe !">
              </form>
        </div>
        <?php
      }
    
      ?>

      <br/>
    
    </section>
    <section class="git" id="git">
      <h1>Jetez un coup d'oeil à notre code !<br /><span
          >habit_enforcer</span
        >
      </h1>
      <p>
        <img class= "icontea" src="https://logosmarcas.net/wp-content/uploads/2020/12/GitHub-Logo.png" />
      </p>
      <br/>
      <a href = "https://github.com/julietteGUE16/Habit_Enforcer">Lien vers notre dépôt !</a>
    </section>
  </body>
</html>