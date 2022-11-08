<?php
?>


<!DOCTYPE html>
<html>

<head>
    <title>Menu</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Habit_Enforcer/Assets/menu.css" crossorigin="anonymous">
</head>

<body>
    <div class="navbar">
        <div class="profil">
    <img class="logoUSER" src="https://zupimages.net/up/22/45/xme3.png" />
      <div class="icon">
        <div class="nameUSER">
        <?php session_start();
        echo $_SESSION['pseudo'];?>
        </div>
        <?php
        echo $_SESSION['email'];?>
      </div>
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
            Tu trouveras en page "TACHES", des habitudes à créer puis à cocher régulierement !
            Rejoins vite un groupe en page "MON GROUPE" et utilise l'enthousiasme collectif pour tenir tes engagements !
            <br>
            <br>
            Ce site à été réalisés par 3 étudiants : Guenard Juliette, Favennec Melaine et Piauger Paul !
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
      <div class="anat">
        
        <img class="c" src="">
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
