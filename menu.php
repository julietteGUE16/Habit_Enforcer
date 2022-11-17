<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur
?>


<!DOCTYPE html>
<html>

<head>
    <title>Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Habit_Enforcer/Assets/menu.css" crossorigin="anonymous">
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
          <a href="../Habit_Enforcer/deconnexion.php">se déconnecter</a><br/><br/>
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
          <li><a href="#page3">Mon Groupe</a></li>
        </ul>
      </div>
    </div>
    <section class="main">
      <section class="page1" id="page1">
        <div class="intro">
          <h1>Une plateforme pour vous guider dans le modelelage d'un quotidien qui vous ressemble <br/><span><img class = "logotaroutyn" src="https://zupimages.net/up/22/45/piq7.png" /></span></h1>
          <p class="text">
            Tu trouveras en page "TACHES", des habitudes à créer puis à cocher régulierement !<br/>
            Rejoins vite un groupe en page "MON GROUPE" et utilise l'enthousiasme <br/>collectif pour tenir tes engagements !
            <br>
            <br>
            Site réalisé par 3 étudiants :<br/> Guenard Juliette, Favennec Melaine et Piauger Paul !
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
        <p class="flex"> <a href="../Habit_Enforcer/create_task.php"> nouvelle tâche ? </a> </p>
        <div class= "taches">
        <div><img class = "photomobile" src="https://zupimages.net/up/22/45/pr92.png" /></div>
        <div class = "listetaches">
        <?php 
        $recupCount = $bdd->prepare('SELECT COUNT(*) FROM task WHERE id_users = ?');
        $recupCount->execute(array($_SESSION['id_users']));
        $fetchC = $recupCount->fetch();
        $_SESSION['nombreTaches'] = $fetchC[0];

        $recupTask = $bdd->prepare('SELECT * FROM task WHERE id_users = ?');
        $recupTask->execute(array($_SESSION['id_users']));
        $fetch = $recupTask->fetchAll();?>
        <form action="menu.php" method="POST" >
          <?php
          $listid = array();
            for($i=0; $i < $_SESSION['nombreTaches']; $i++){
              $_SESSION['nom'] = $fetch[$i]['nom'];
              $_SESSION['difficulté'] = $fetch[$i]['niveau'];
              $_SESSION['jour'] = $fetch[$i]['jour'];
              $_SESSION['difficulté'] = $fetch[$i]['niveau'];
              $_SESSION['style'] = $fetch[$i]['style'];
              $_SESSION['idtask'] = $fetch[$i]['id_task'];
              $_SESSION['idvalid'] = $fetch[$i]['isvalid'];
              $listid[$i] =$_SESSION['idtask'];
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
                  <input type="checkbox" name="<?php echo $_SESSION['idtask'] ?>" <?php if($_SESSION['idvalid'] == 1){?>checked<?php }?>>
              </div>
              </div></br><?php
            }?>
            <div class="submitTask"><input type="submit" value="Click pour valider !"></div>
            </form>
            <?php
            $countvalid = 0;
            $countinvalid = 0;
            foreach ($listid as $value) 
            { 
              if (isset($_POST["$value"])) 
              { 
                $countvalid = $countvalid + 1;
                $valid = 1;
                $updateValid = $bdd->prepare('UPDATE task SET isvalid=? WHERE id_task = ?');
                $updateValid->execute(array(1,$value));
              } 
              else {
                $countinvalid = $countvalid + 1;
                $valid = 0;
                $updateValid = $bdd->prepare('UPDATE task SET isvalid=? WHERE id_task = ?');
                $updateValid->execute(array(0,$value));
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
      <h2>Mon Groupe</h2>
      <p>Rejoins un groupe ou suis l'actité de ton groupe ici !</p>
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
