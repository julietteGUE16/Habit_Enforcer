<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8', 'root', '');
if(isset($_POST['envoi'])){
    if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['mdp']);
        $insertUser = $bdd->prepare('INSERT INTO users(pseudo,mdp)VALUES(?,?)');
        $insertUser->execute(array($pseudo, $mdp));

        //recupérer l'utilisateur grâce à une requête
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $mdp));
        if($recupUser->rowCount() > 0){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $recupUser->fetch()['id'];
        }
        echo $_SESSION['id'];
    }else{
        echo "veuillez compléter tous les champs !";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Habit_Enforcer/style.css" crossorigin="anonymous">
</head>
<img class="logo" src="https://zupimages.net/up/22/44/pbyf.png">

<body class="login">


  <div class="container">

    <div class="login-wrapo flex">

      <div class="login-box">

        <h2>Inscription</h2>

        <form id="loginForm" method="POST" action="">
            <input type="text" name="pseudo" required placeholder="pseudo">
            <br/>
            <input type="password" name="mdp" required placeholder="mot de passe">
            <br/><br/>
            <button type="submit" name= "envoi" class="ripple cursor"> S'inscrire ! </button>
        </form>

        <p class="flex"> <a href="../Habit_Enforcer/connexion.php"> Déjà inscrit ? </a> </p>

      </div>

    </div>

  </div>

</body>
</html>
