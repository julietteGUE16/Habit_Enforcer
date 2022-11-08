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
        echo "<script>alert('veuillez compléter tous les champs !')</script>";
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
<body>

<div class="content-total">
    <div class="signindiv">
        <h2>Connectez vous</h2>
        <form method="POST" action="">
            <input type="text" class="pseudo" name="pseudo" placeholder="Nom d'utilisateur" autocomplete="off">
            <br/>
            <input type="password" class="mdp" name="mdp" placeholder="Mot de Passe" autocomplete="off">
            <br/><br/>
            <input type="submit" class="envoi" name="envoi" value="Validé">
        </form>
        <p>Deja un compte ? <a href="connexion.php">Connectez vous ici </a></p>
    </div>
    <!-- peut etre mettre une email et une verif de mdp vu que c'est une creation de compte comme ca en plus on pourrais
     essayé d'envoyé un mail au user pour validé son compte donc que des mail valide donc plus secur -->
    <div class="welcomediv">
        <h2>Taroutyn</h2>
        <h4>Bienvenue sur Taroutyn, le site pour prende les bonnes habitudes !</h4>
        <p>Connectez-vous pour accéder à votre espace personnel</p>
    </div>
</div>


<!-- <img class="logo" src="https://zupimages.net/up/22/44/pbyf.png">
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

  </div> -->

</body>
</html>
