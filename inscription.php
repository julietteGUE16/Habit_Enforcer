<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8', 'root', '');
if(isset($_POST['envoi'])){
    if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'] AND !empty($_POST['email']))){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = sha1($_POST['mdp']);
        $insertUser = $bdd->prepare('INSERT INTO users(pseudo,email,mdp)VALUES(?,?,?)');
        $insertUser->execute(array($pseudo,$email,$mdp));

        //recupérer l'utilisateur grâce à une requête
        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $mdp));
        if($recupUser->rowCount() > 0){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id_users'] = $recupUser->fetch()['id_users'];
        }
        echo $_SESSION['id_users'];
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
            <input type="text" name="email" required placeholder="email">
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
