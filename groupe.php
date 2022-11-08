<?php
class Groupe{
    public static function createGroupe($nom, $description){
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $nom = htmlspecialchars($_POST['nom']);
        $description = htmlspecialchars($_POST['description']);
        echo $nom;
        $recupUser = $bdd->prepare('INSERT INTO group (nom, description) VALUES (?, ?)');
        $recupUser->execute(array($nom, $description));
               //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
        if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
            $_SESSION['id_group'] = $recupUser->fetch()['id_group'];
            $_SESSION['score'] = $recupUser->fetch()[0];
            $_SESSION['nom'] = $nom;
            $_SESSION['description'] = $description;
            header('Location: menu.php');
        }
}
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

<form method="POST" action="" >
<input type="text" name="nom" placeholder="Nom du groupe" required="required" autocomplete="off">
<br/>
<input type="text" name="description" placeholder="Description" required="required" autocomplete="off">
<br/><br/>
<input type="submit" name="envoi" >

<?php
    if(!empty($_POST['nom']) AND !empty($_POST['description'])){
        Groupe::createGroupe($_POST['nom'], $_POST['description']);
    }
?>
</form>

</body>
</html>