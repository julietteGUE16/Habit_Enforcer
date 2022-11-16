<?php


$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');
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
        
        $nom = htmlspecialchars($nom);
        $description = htmlspecialchars($description);
  
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');
      
        $inserGroup = $bdd->prepare('INSERT INTO groupes(name_group,description)VALUES (?, ?)');
        $inserGroup->execute(array($nom, $description));
       


        $recupGroup = $bdd->prepare('SELECT * FROM groupes WHERE name_group = ? AND description = ?');
        $recupGroup->execute(array($nom, $description));

        $fetch = $recupGroup->fetch();
        //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
        if ($recupGroup->rowCount() > 0) { // on peut connecter l'utilisateur
            $_SESSION['id_group'] = $fetch['id_group'];
            $_SESSION['last_score'] =  $fetch[0];
            $_SESSION['previous_score'] =  $fetch[0];
            $_SESSION['name_group'] = $nom;
            $_SESSION['description'] = $description;


            $UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
       
            $UpdateUser->execute(array($_SESSION['id_group'], $_SESSION['id_user']));

          

            

            header('Location: menu.php');
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

<p class="flex"> <a href="../Habit_Enforcer/menu.php"> retour au menu ? </a> </p>

<?php
      

       
      
        session_start();
        if($_SESSION['id_group'] == null){

            ?>
    <form method="POST" action="">
    <p>Créer ton groupe : </p>
    <br/>

        <input type="text" name="nom" placeholder="Nom du groupe" required="required" autocomplete="off">
        <br />
        <input type="text" name="description" placeholder="Description" required="required" autocomplete="off">
        <br /><br />
        <input type="submit" name="envoi">

        <br/>
        <br/>
        <br/>    
        <p>rejoint une invitation : </p>
    
 
        </form>
        <?php
     
        
      } else {
        //TODO : afficher le groupe
        ?><p>vous êtes déjà dans un groupe, id =  <?php echo  $_SESSION['id_group']; ?> </p> 


              <form action = "leaveGroup.php" name="post">
                
              <input type="submit"  onclick="leaveGroup()" value= "quitter groupe">
              </form>

     

        </br>
        <form method="POST" action="">
        <p>Rentrer un pseudo de user pour l'inviter : </p>

        <input type="text" name="pseudoInvit" placeholder="pseudoInvit" required="required" autocomplete="off">
        <br /><br />
        <input type="submit" name="invit">
      </form>
        <?php
        

      

      }

      
      
      



if(isset($_POST['envoi'])){//nom du bouton)
  
    if( $_SESSION['id_group'] == null){
      
        if (!empty($_POST['nom']) and !empty($_POST['description']) ) {
          
    
        Groupe::createGroupe($_POST['nom'], $_POST['description']);
       
        } else {
            echo "Veuillez compléter tous les champs..";
        }
    } else {
      //?????
    }
    //users invitation
}  else if (isset($_POST['invit'])){
    if(!empty($_POST['pseudoInvit'])){
        $userExist = false;
        $recupUser = $bdd->prepare('SELECT pseudo FROM users ');
        $recupUser->execute();
        
        if($recupUser->rowCount() > 0){ 
           $pseudo =  $recupUser->fetchAll();
        
       // echo "count = ". count($pseudo);
           for($i=0 ; $i<count($pseudo); $i++){
            //echo $pseudo[$i]['pseudo'];

            
            if($pseudo[$i]['pseudo'] == $_POST['pseudoInvit'] && $_POST['pseudoInvit'] != $_SESSION['pseudo']){
               $userExist = true; 
            }
            
            
           }
           if($userExist){
            //todo : envoyer une invitation (la créer dans la base de donnée)
           } else {
            echo "l'utilisateur n'existe pas, veuillez réitérer votre demande ...";
           }
        }


    }else {
        echo "Veuillez écrire un nom de user.";
    }




}

?>
    </form>

</body>

</html>