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
        echo "<script>alert('veuillez compléter tous les champs !')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <meta charset="utf-8">
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
</body>
</html>