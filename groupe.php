<?php


$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');



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
<br> </br> 

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
        <input type="submit" name="envoi" value="créer groupe">

        <br/>
        <br/>
        <br/>    
        <p>rejoint une invitation : </p>

      
    
 
        </form>
        <?php
     
        
      } else {
       
        ?><p>vous êtes déjà dans le groupe qui se nomme : <?php echo  $_SESSION['name_group']; ?> </p> 


              <form action = "leaveGroup.php" name="post">
                
              <input type="submit"  onclick="leaveGroup()" value= "quitter <?= $_SESSION['name_group'];  ?>"  >
              </form>

     

        </br>
        <br> </br> 
<br> </br> 
        <form method="POST" action="">
        <p>Rentrer un pseudo de user pour l'inviter : </p>

        <input type="text" name="pseudoInvit"  placeholder="pseudo de l'utilisateur..." required="required" autocomplete="off">
        <br /><br />
        <?php



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
} 


$userExist = false;
$recupUser = $bdd->prepare('SELECT id_user ,pseudo FROM users ');
$recupUser->execute();

if($recupUser->rowCount() > 0){ 
   $users =  $recupUser->fetchAll();

   echo "liste des pseudos : ";
   //afficher la liste des users avant de cliquer sur le pseudo 

   for($i=0 ; $i<count($users); $i++){
    if($users[$i]['pseudo'] != $_SESSION['pseudo']){
    echo $users[$i]['pseudo'] . ", ";
    }
}

?>
<br /><br />
           
<input type="submit" name="invit" value="inviter dans <?= $_SESSION['name_group'];  ?>">
<br /><br />
           
<?php

    if (isset($_POST['invit'])){
        if(!empty($_POST['pseudoInvit'])){
       
        
       // echo "count = ". count($pseudo);
       
           for($i=0 ; $i<count($users); $i++){
                     
            if($users[$i]['pseudo'] == $_POST['pseudoInvit'] && $_POST['pseudoInvit'] != $_SESSION['pseudo']){
               $userExist = true; 
               $userInvitedId = $users[$i]['id_user'];
               $userInvited = htmlspecialchars($_POST['pseudoInvit']);
            }  
           }

       


           if(!$userExist){
          
            ?>  <br> </br> <?php
            //TODO : pb de " ' " entre l et utilisateur


           echo '<span style="color:#FF0000;text-align:center;">l utilisateur n existe pas ou vous essayez de vous inviter, veuillez réitérer votre demande ...</span>';
           
           } else {
            ?>
           
         <?php
           
          
            //eviter les doublons d'invit
            $recupInvit = $bdd->prepare('SELECT * FROM invit WHERE id_group = ? AND id_user = ? AND id_user_invited = ? AND  host_pseudo = ? AND  name_group= ? AND invited = ? ');
            $recupInvit->execute(array($_SESSION['id_group'], $_SESSION['id_user'], $userInvitedId, $_SESSION['pseudo'], $_SESSION['name_group'], $userInvited));

        $fetch = $recupInvit->fetch();
        //si au niveau du tableau on à reçu au moins un élément on va pouvoir traiter les infos
        if ($recupInvit->rowCount() > 0) { // on peut connecter l'utilisateur
           
            echo "l'invitation à déjà été envoyée à " . $_POST['pseudoInvit'];

        } else{
            echo $_POST['pseudoInvit'] . " est invité(e) !";
            $inserInvit = $bdd->prepare('INSERT INTO invit(id_group,id_user,id_user_invited, host_pseudo, name_group, invited)VALUES (?,?,?,?,?,?)');
            $inserInvit->execute(array($_SESSION['id_group'], $_SESSION['id_user'], $userInvitedId, $_SESSION['pseudo'], $_SESSION['name_group'],$userInvited));
    
        }    
           }

    }else {
        echo "Veuillez écrire un nom d'utilisateur.";
    }


}

}


?>
 <form method="POST" action="">
 <br> </br> 
 <br> </br> 
 <br> </br> 

        <h2>Liste des invitations en attentes : </h2>
        <br> </br> 

<?php

  //todo : afficher les demandes envoyé par le user ??? pour pouvoir les annuler ?


        $allInvit = $bdd->prepare('SELECT * FROM invit WHERE id_user = ? ');
        $allInvit->execute(array($_SESSION['id_user']));

       
        
        
        if ($allInvit->rowCount() > 0) { 
            
            $invits = $allInvit->fetchAll();          
           // echo "le nombre = ". count($invits);

            for($i =0; $i < count($invits); $i++){

                ?>
                <br /><br />
                <?php


                echo "" . $invits[$i]['invited'] . " | STATUS : demande en cours... ";

                ?>
              <input type="button" name="delete" value="cancel">

                <?php
              
            }
  

      }

      
      
    }      


      ?> <br /><br />


    </form>

</body>

</html>