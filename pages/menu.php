<?php

include '../model/Task.php';
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur


setlocale(LC_TIME, "fr_FR.UTF8",'fra');
$currentday = strftime('%A');
$currentDate = date("Y-m-d H:i:s");

if($_SESSION['id_group'] == -1 ){
} else if($_SESSION['id_group'] != null && $_SESSION['last_task_creation'] != $currentDate){ 
  $recupValidTask = $bdd->prepare('SELECT * FROM tasks WHERE id_user = ?');
  $recupValidTask->execute(array($_SESSION['id_user']));
  $fetchVT = $recupValidTask->fetchAll();
  for($i=0; $i < count($fetchVT); $i++){
    $_SESSION['isdaily'] = $fetchVT[$i]['isdaily'];
    $_SESSION['difficulty'] = $fetchVT[$i]['difficulty'];
    $lastvaliddate = $fetchVT[$i]['last_valid_date'];
    if($_SESSION['isdaily']){
      $nbJour = 1;
    }else{
      $nbJour = 7;
    }
    $diff = (strtotime($currentDate) - strtotime($lastvaliddate))/86400;
      if ($diff > $nbJour && $lastvaliddate != null){
        $calcul = $_SESSION['last_score'] - $_SESSION['difficulty'];
        $updateNegScore = $bdd->prepare('UPDATE groupes SET last_score = ? WHERE id_group = ?');
        $updateNegScore->execute(array($calcul, $_SESSION['id_group']));
        $_SESSION['last_score'] = $calcul;
      }
  }


if($_SESSION['last_score']< 0){
    $deleteGroup= $bdd->prepare('DELETE FROM groupes WHERE id_group = ? ');
    $deleteGroup->execute(array($_SESSION['id_group']));
    $_SESSION['id_group'] = null;
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
      <div class="form-popup" id="popupForm" onclick="closeForm()">
        <div class="contentPopUp">
          <form action="/action_page.php" class="form-container">

            <h2>Mon compte</h2>
            <?php
            echo "<p class=\"pseudoPopUP\"> Pseudo :  " . $_SESSION['pseudo'] . "</p>";
            echo "<p class=\"emailPopUp\"> Email :  " . $_SESSION['email'] . "</p>";
            ?>
            <a href="../pages/deconnexion.php" class="btnDeco">Se déconnecter</a>
            <button type="button" class="btncancel" onclick="closeForm()">Fermer</button>
        </div>
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
        <form action="../pages/menu.php" method="POST">
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
              if(strtolower($_SESSION['jour']) == $currentday || $_SESSION['jour']== NULL ){
              ?>
              <div class="box">
              <div class="tache"><?php echo $_SESSION['nom'];?></div>
              <div class= "niveau"><?php echo "niveau : ".$_SESSION['difficulté']; ?></div>
              <div class= "daily"><?php if($_SESSION['jour']== NULL){echo "Quotidien";}; ?></div>
              <div class= "daily"><?php echo $_SESSION['jour']; ?></div>
              <img class = "iconstyle" src="<?php echo $_image?>" />
              <div class="checkbox" >
                  <input type="checkbox" name="<?php echo $_SESSION['idtask'] ?>" 
                  <?php if(isset($_POST[$_SESSION['idtask']])){ echo "checked" ;}?>> 
              </div>
              </div></br><?php
            }}?>
            <div class="submitTask">
                <input type="submit" name="submitvalid" value="Click pour valider !" onclick="<?php Task::setvalidtask($listid,$listdif) ?>"></div>
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
      <h2>Mon Groupe</h2>
    
      <p>Rejoins un groupe ou suis l'actvité de ton groupe ici !</p>
      <br/>
      <?php
      if($_SESSION['id_group'] == null){
        ?> <p class="flex"> <a href="../pages/manageGroup.php"> créer ou rejoindre un groupe ! </a> </p> <?php
      } else {
        ?> <p class="flex"> <a href="../pages/manageGroup.php"> inviter des users ! </a> </p></br> <?php
        ?><p>votre id groupe est : <?php echo  $_SESSION['id_group']; ?> </p>
        </br>
        <p>""<?php echo  "  ".$_SESSION['description']."   "; ?>"" </p>
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