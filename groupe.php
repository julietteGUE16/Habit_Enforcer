<?php
class Groupe{
    public static function createGroupe($nom, $description){
        $bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;','root', '');
        $nom = htmlspecialchars($_POST['nom']);
        $description = htmlspecialchars($_POST['description']);
        echo $nom;
        $recupUser = $bdd->prepare('INSERT INTO groupe (nom, description) VALUES (?, ?)');
        $recupUser->execute(array($nom, $description));
               //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
        if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
            $_SESSION['id'] = $recupUser->fetch()['id'];
            $_SESSION['nom'] = $nom;
            $_SESSION['description'] = $description;
            header('Location: groupe.php');
        }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Groupe</title>
    <meta charset="utf-8">
</head>
<body>

<form method="POST" action="" >
<input type="text" name="nom" placeholder="Nom du groupe">
<br/>
<input type="text" name="description" placeholder="Description">
<br/><br/>
<input type="submit" name="envoi" >

<?php
    if(!empty($_POST['nom']) AND !empty($_POST['description'])){
        echo "avant ajout";
        Groupe::createGroupe($_POST['nom'], $_POST['description']);
        echo "groupe ajouté";
    } else {
        echo " Votre nom de groupe ou votre description est incorrecte";
    }
?>
</form>
</body>
</html>