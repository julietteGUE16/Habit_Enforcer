<?php
// session_start();
// $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur
// if(isset($_POST['envoi'])){//nom du bouton
//     if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
//        $pseudo = htmlspecialchars($_POST['pseudo']);
//        $mdp = sha1($_POST['mdp']);

//        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
//        $recupUser->execute(array($pseudo, $mdp));
//        //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
//        if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
//         $_SESSION['pseudo'] = $pseudo;
//         $_SESSION['mdp'] = $mdp;
//         $_SESSION['id_users'] = $recupUser->fetch()['id_users'];
//         header('Location: menu.php');
//        } else {
//         echo "<script>alert('Votre mot de passe ou nom d'utilisateur est incorrecte')</script>";
//        }
//     }else{
//         echo "<script>alert('Veuillez compléter tous les champs')</script>";
//     }
// }
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="connexion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Finger+Paint&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../Habit_Enforcer/Assets/style.css" crossorigin="anonymous"> -->
</head>
<body>
<!-- <img class="logo" src="https://zupimages.net/up/22/45/piq7.png"> -->

<div class="content-total">
    <div class="logindiv">
        <h2>Connectez vous</h2>
        <form method="POST" action="">
        <input type="text" class="pseudo" name="pseudo" placeholder="Nom d'utilisateur" autocomplete="off">
        <br/>
        <input type="password" class="mdp" name="mdp" placeholder="Mot de Passe" autocomplete="off">
        <br/><br/>
        <input type="submit" class="envoi" name="envoi" value="Se connecter">
        </form>
        <p>Pas de compte ? <a href="inscription.php">Cliquez ici </a></p>
        
    </div>
    <div class="welcomediv">
        <h2>Taroutyn</h2>
        <h4>Bienvenue sur Taroutyn, le site pour prende les bonnes habitudes !</h4>
        <p>Connectez-vous pour accéder à votre espace personnel</p>
    </div>
</div>
<!-- 
<img class="logo" src="https://zupimages.net/up/22/44/pbyf.png">
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
            // session_start();
            // $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); //on créer notre objet PDO pour pouvoir exécuter nos requetes, host --> hebergeur
            // if(isset($_POST['envoi'])){//nom du bouton
            //     if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
            //         $pseudo = htmlspecialchars($_POST['pseudo']);
            //         $mdp = sha1($_POST['mdp']);
            //         $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
            //         $recupUser->execute(array($pseudo, $mdp));
            //         //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
            //         if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
            //             $_SESSION['pseudo'] = $pseudo;
            //             $_SESSION['mdp'] = $mdp; // On ne peux faire qu'un fetch par requête !
            //             $fetch = $recupUser->fetch();
            //             $_SESSION['email'] = $fetch['email'];
            //             $_SESSION['id_users'] = $fetch['id_users'];
            //             header('Location: menu.php');
            //         } else {
            //             echo " Votre mot de passe ou nom d'utilisateur est incorrecte";
            //         }}else{echo "Veuillez compléter tous les champs..";}}
                    ?>
            <br/><br/>
            <button type="submit" name= "envoi" class="ripple cursor"> Se connecter ! </button>
        </form>

        <p class="flex"> <a href="../Habit_Enforcer/inscription.php"> Nouvel utilisateur ? </a> </p>

      </div>

    </div>

  </div> -->

</body>
</html>
