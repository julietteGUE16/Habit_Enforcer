<?php
class Groupe
{
    public static function createGroupe($nom, $description)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');
        $nom = htmlspecialchars($nom);
        $description = htmlspecialchars($description);
        echo $nom;
        $recupUser = $bdd->prepare('INSERT INTO groupe(nom,description)VALUES (?, ?)');
        $recupUser->execute(array($nom, $description));
        if ($recupUser->rowCount() > 0) {
            $_SESSION['id_group'] = $recupUser->fetch()['id_group'];
            $_SESSION['score'] = $recupUser->fetch()[0];
            $_SESSION['nom'] = $nom;
            $_SESSION['description'] = $description;
            header('Location: menu.php');
        }
    }

    public static function selectGroupe($nom, $description)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');
        $nom = htmlspecialchars($nom);
        $description = htmlspecialchars($description);
        $recupUser = $bdd->prepare('SELECT * FROM groupe WHERE nom = ? AND description = ?');
        $recupUser->execute(array($nom, $description));
        if ($recupUser->rowCount() > 0) {
            $_SESSION['score'] = $recupUser->fetch()[0];
            $_SESSION['nom'] = $nom;
            $_SESSION['description'] = $description;
            header('Location: menu.php');
        }
    }

    // public static function joinGroupe($nom, $id_group){
    //     $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');
    //     $nom = htmlspecialchars($nom);
    //     $recupUser = $bdd->prepare('SELECT * FROM users WHERE nom = ?');
    //     $recupUser->execute(array($nom));
    //     if($recupUser->rowCount() > 0){
    //         $_SESSION['id_group'] = $id_group;
    //     }
    // }
}
// public static function addPoint($level){
//     TODO;
// }

?>

<!DOCTYPE html>
<html>

<head>
    <title>Groupe</title>
    <link rel="stylesheet" type="text/css" href="groupe.css">
    <meta charset="utf-8">
</head>

<body>

    <form method="POST" action="">
        <input type="text" name="nom" placeholder="Nom du groupe" required="required" autocomplete="off">
        <br />
        <input type="text" name="description" placeholder="Description" required="required" autocomplete="off">
        <br /><br />
        <input type="submit" name="envoi">

        <?php

        if (!empty($_POST['nom']) and !empty($_POST['description'])) {
            Groupe::createGroupe($_POST['nom'], $_POST['description']);
        }
        ?>
    </form>

    <form action="" method="POST">
        <input type="search" id="searchBar" name="searchBar">
        <input type="submit" name="search" value="Rechercher">
    

    <div id="result">
        <!-- si le groupe existe ajouté le user au groupe si il n'est pas deja dans un groupe -->
        <?php
        if (isset($_POST['search'])) {
            $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');
            $search = htmlspecialchars($_POST['searchBar']);
            $recupGroupe = $bdd->prepare('SELECT * FROM groupe WHERE nom = ?');
            $recupGroupe->execute(array($search));
            if ($recupGroupe->rowCount() > 0) {
                $fetch  = $recupGroupe->fetch();
                $nom = $fetch['nom'];
                $description = $fetch['description'];
                $group = $fetch['id_group'];
                echo "<p>id du groupe : $id_group</p>";
                echo "<p>Le groupe existe</p>";
                echo "<p>nom : $nom</p>";
                echo "<p>description : $description</p>";
                echo "<input type='submit' name='join' value='Rejoindre le groupe'>";
                if (isset($_POST['join'])) {
                    Groupe::joinGroupe($nom, $id_group);
                }
            } else {
                echo "<p>Le groupe n'existe pas</p>";
            }
        }
        ?>
    </div>
    </form>
    <!-- <div>
        <?php
        // session_start();
        // Groupe::selectGroupe($_SESSION['nom'], $_SESSION['description']);
        ?>
    </div> -->

</body>

</html>