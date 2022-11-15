<?php
//TODO : 

/**Chaque utilisateur peut faire partie d'un et un seul groupe d'amis à la fois. Il peut

    créer un nouveau groupe,
    le quitter,
    inviter d'autres utilisateurs dans son groupe,
    accepter une invitation pour rejoindre le groupe de quelqu'un d'autre.
 */


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
        //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
        if ($recupUser->rowCount() > 0) { // on peut connecter l'utilisateur
            $_SESSION['id_group'] = $recupUser->fetch()['id_group'];
            $_SESSION['score'] = $recupUser->fetch()[0];
            $_SESSION['nom'] = $nom;
            $_SESSION['description'] = $description;
            header('Location: groupe.php');
        }
 }
    // public static function addPoint($level){
    //     TODO;
    // }

}
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

</body>

</html>