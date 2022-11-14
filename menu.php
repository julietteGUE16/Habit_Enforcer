<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur


if(isset($_POST['button'])){//nom du bouton
    header('Location: create_task.php');
}else{
    //TODO : error
}
    $id = $_SESSION['id_users'];
    echo "id = ".$id;
    //compte le nombre de ligne pour un id user
    $recupUser = $bdd->prepare('SELECT COUNT(*) AS COUNT FROM task WHERE id_users = ? GROUP BY id_users ' ); //
    
    $recupUser->execute(array($id));
    
    //echo "total = [". $total. "]";
    //echo "total = ". $recupUser->fetch()["COUNT"];
    $total = $recupUser->fetch()["COUNT"];
     
    for ($i = 0; $i < $total; $i++){
      //TODO : select : order by id_user et recup chaque ligne avec le id user
      //TODO : get id de chaque task
      echo "passage 0";
      $task1 = new Task(3);
      echo "passage 1";
      //$task->getData();
      echo "passage 2";
      //echo "test = ". $task->getName();



      //TODO list of task



    
    }



 
    

    //TODO display color of task en fonction du type de task
    //TODO : display task with grid


/*
* 1) take list of task by id_user ( for the current user)
* 2) creat a task objet and fill it with information in database by id_task (use a function)
* 3) display using function of task object ! :)
*
*
*/

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
      <div class="anat">
        <img class="c" src="">
        <p class="flex"> <a href="../Habit_Enforcer/create_task.php"> nouvelle tâche ? </a> </p>
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
