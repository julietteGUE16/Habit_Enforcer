<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur
if(isset($_POST['envoi'])){//nom du bouton
    if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
       $pseudo = htmlspecialchars($_POST['pseudo']);
       $mdp = sha1($_POST['mdp']);

       $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
       $recupUser->execute(array($pseudo, $mdp));
       //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
       if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['mdp'] = $mdp;
        $_SESSION['id'] = $recupUser->fetch()['id'];
        header('Location: menu.php');
       } else {
        echo " Votre mot de passe ou nom d'utilisateur est incorrecte";
       }
    }else{
        echo "Veuillez compléter tous les champs..";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
</head>
<body>

<p>
    Create task !
</p>

<form method="POST" action="" align="center">
<input type="text" name="pseudo">
<br/>
<input type="password" name="mdp">
<br/><br/>
<input type="submit" name="envoi">
</form>
</body>
</html>
