<?php
session_start();


$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8', 'root', '');
if (isset($_POST['envoi'])) {
    if (!empty($_POST['pseudo']) and !empty($_POST['mdp'] and !empty($_POST['email']))) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = sha1($_POST['mdp']);
        $pseudoExist = false;
        $recupUser = $bdd->prepare('SELECT id_user ,pseudo FROM users ');
            $recupUser->execute();
            if($recupUser->rowCount() > 0){ 
                $users =  $recupUser->fetchAll();
                //verifie si le pseudo n'existe pas déjà 
                for($i=0 ; $i<count($users); $i++){
                    if($users[$i]['pseudo'] == $_POST['pseudo']){
                        $pseudoExist = true;
                    }
                }
            }
        if(!$pseudoExist){


            $insertUser = $bdd->prepare('INSERT INTO users (pseudo,email,pwd) VALUES (?,?,?)');
            $resul = $insertUser->execute(array($pseudo, $email, $mdp));
            //recupérer l'utilisateur grâce à une requête
            $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND pwd = ?');
            $recupUser->execute(array($pseudo, $mdp));
            if ($recupUser->rowCount() > 0) {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['pwd'] = $mdp;
                $_SESSION['email'] = $email;
                $fetch = $recupUser->fetch();
                $_SESSION['id_user'] = $fetch['id_user'];
                $_SESSION['id_group'] = $fetch['id_group'];
                $_SESSION['last_task_creation'] = $fetch['last_task_creation'];
                $_SESSION['last_connexion'] = $fetch['last_connexion'];
            }
            //echo $_SESSION['id_user'];
            header('Location: menu.php');
        } else {
            echo "<script>alert('le pseudo existe déjà !')</script>";
        }


    } else {
        echo "<script>alert('veuillez compléter tous les champs !')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Inscription</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/style.css" crossorigin="anonymous">

</head>



<img class="logo" src="https://zupimages.net/up/22/44/pbyf.png">

<body class="login">


    <div class="container">

        <div class="login-wrapo flex">

            <div class="login-box">

                <h2>Inscription</h2>

                <form id="loginForm" method="POST" action="">
                    <input type="text" name="pseudo" required placeholder="pseudo" id="pseudo" autocomplete="off">
                    <br />
                    <input type="text" name="email" id="email" required placeholder="email" id="email" autocomplete="off">
                    <script>
                        function checkEmail(email) {
                            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            return re.test(email);
                        }
                        function validate() {
                            var email = document.getElementById("email").value;

                            if (!checkEmail(email)) {
                                document.getElementById("pseudo").value = "";
                                document.getElementById("email").value = "";
                                document.getElementById("mdp").value = "";
                                document.getElementById("email").placeholder = "Email invalide";
                                document.getElementById("email").style.border = "1px solid red";
                                document.getElementById("email").focus();
                                alert("Invalid email address!");
                                
                            }

                        }

                    </script>

                    <br />
                    <input type="password" name="mdp" required placeholder="mot de passe" id="mdp" autocomplete="off">
                    <br /><br />
                    <button type="submit" name="envoi" class="ripple cursor" onclick="validate()"> S'inscrire !
                    </button>

                </form>

                <p class="flex"> <a href="../pages/connexion.php"> Déjà inscrit ? </a> </p>

            </div>

        </div>

    </div>

</body>

</html>