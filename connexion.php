<!DOCTYPE html>
<html>
<html lang="en-US">
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Habit_Enforcer/Assets/style.css" crossorigin="anonymous">
</head>
<img class="logo" src="https://zupimages.net/up/22/45/piq7.png">

<body class="login">


  <div class="container">

    <div class="login-wrapo flex">

      <div class="login-box">

        <h2>Connexion</h2>

        <form id="loginForm"  method="POST" action="" align="center">
            <input type="text" name="pseudo" required placeholder="pseudo">
            <br/>
            <input type="password" name="mdp" required placeholder="mot de passe">
            <br/>
            <?php
            session_start();
            $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur
            if(isset($_POST['envoi'])){//nom du bouton
                if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
                    $pseudo = htmlspecialchars($_POST['pseudo']); //éviter les attaques XSS
                    $mdp = sha1($_POST['mdp']);
                    $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND pwd = ?');
                    $recupUser->execute(array($pseudo, $mdp));
                    //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
                    if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['pwd'] = $mdp; // On ne peux faire qu'un fetch par requête !
                        $fetch = $recupUser->fetch();
                        $_SESSION['email'] = $fetch['email'];
                        $_SESSION['id_user'] = $fetch['id_user'];
                        header('Location: menu.php');
                    } else {
                        echo " Votre mot de passe ou nom d'utilisateur est incorrecte";
                    }}else{echo "Veuillez compléter tous les champs..";}}
                    ?>
            <br/><br/>
            <button type="submit" name= "envoi" class="ripple cursor"> Se connecter ! </button>
        </form>

        <p class="flex"> <a href="../Habit_Enforcer/inscription.php"> Nouvel utilisateur ? </a> </p>

      </div>

    </div>

  </div>

</body>
</html>