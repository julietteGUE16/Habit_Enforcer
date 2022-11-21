<?php


//TODO : check lequel marche :
include '../model/Group.php';
session_start();


$bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;', 'root', '');

//TODO : display point
//TODO : lors de la suppreision de groupe en cas de défaite delete all tâche + all invit


//todo : changer d'endroit

    //public static 
    function createGroupe($nom, $description)
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
            $_SESSION['last_score'] =  0;
            $_SESSION['previous_score'] =  0;
            $_SESSION['name_group'] = $nom;
            $_SESSION['description'] = $description;

            $UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
       
            $UpdateUser->execute(array($_SESSION['id_group'], $_SESSION['id_user']));


            header('Location: manageGroup.php');
        }


        
 }
    

?>

<!DOCTYPE html>
<html>

<head>
    <title>Groupe</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/creategroup.css" crossorigin="anonymous">
</head>
<body>
<div class="navbar">
    <div class="profil">
      <button class="open-button" onclick="openForm()">
    <img class="logoUSER" src="https://zupimages.net/up/22/45/xme3.png" />
      <div class="icon">
        <div class="nameUSER">
        <?php 
        echo $_SESSION['pseudo'];?>
        </div>
        <?php
        echo $_SESSION['email'];
        ?>
      </div>
    </button>
    </div>
    <div class="login-popup">
      <div class="form-popup" id="popupForm">
        <form action="/action_page.php" class="form-container">
          <h2>Mon compte</h2><br/><br/>
          <a>Changer de pseudo</a><br/><br/>
          <a href="../pages/deconnexion.php">se déconnecter</a><br/><br/>
          <button type="button" class="btncancel" onclick="closeForm()">Fermer</button>
        </form>
      </div>
    <script>
      function openForm() {
        document.getElementById("popupForm").style.display = "block";
      }

      function closeForm() {
        document.getElementById("popupForm").style.display = "none";
      }
    </script>
      </div>
      <div class="menu">
        <ul>
          <li><a href="../pages/menu.php">Retour au menu !</a></li>
        </ul>
      </div>
    </div>
</br>
<section class="creategroup">
    <section class="page1">
<?php     
        if($_SESSION['id_group'] == null){
        ?>
        <div class="cgroup">
        <form method="POST" action="">
        <h2>Créer son groupe : </h2>
        <br/>
        <input type="text" name="nom" placeholder="Nom du groupe" required="required" autocomplete="off">
        <br />
        <input type="text" name="description" placeholder="Description" required="required" autocomplete="off">
        <br /><br />
        <button type="submit" name="envoi">Créer le groupe !</button>
        </form>
        </div>
        <br/>
        <br/>
        <br/>    
        <?php 
        //afficher liste d'invitation
        $myInvit = $bdd->prepare('SELECT * FROM invit WHERE id_user_invited = ? ');
        $myInvit->execute(array($_SESSION['id_user']));
       
        if ($myInvit->rowCount() > 0) { 
            $myInvits = $myInvit->fetchAll();           
            ?> 
            <div class = "listetaches">
            <h2>Vous avez  <?php  echo   count($myInvits)  ?> invitation(s) : </h2>
            <?php            
           // echo "le nombre = ". count($invits);
            for($i =0; $i < count($myInvits); $i++){
                ?>
                <div class="invitationRecu">
                <form method="POST" action="">
                <div class="stat">
                <?php
                echo "" . $myInvits[$i]['host_pseudo']  . " vous a envoyé une demande pour rejoindre ". $myInvits[$i]['name_group'] . " | ";
                ?>
                <button name="<?php echo $i?>" value="accepter">accepter</button>
                <button name="<?php /*TODO : !!!!!*/ ?>" value="refuser">refuser</button></div>
                </form>
            </div>
                <?php
               // echo "ok = " . $_POST['$i'];
                if (isset($_POST['$i'])) 
                {
                    echo "le i = " . $i;
                   //TODO : rejoindre le groupe et delete l'invit 
                } 
            }

        } else {
            ?> </div> <div class="zeroinvit"><h2>vous avez 0 invitation : </h2></div>       
            <?php
        }
        ?>    
        <?php
        if(isset($_POST['envoi'])){//nom du bouton)
            echo "passage1";  
            if( $_SESSION['id_group'] == null){
                echo "passage2";  
                if (!empty($_POST['nom']) and !empty($_POST['description']) ) {
                    echo "passage3";  
            
                createGroupe($_POST['nom'], $_POST['description']);
                
                } else {
                    echo "Veuillez compléter tous les champs..";
                }
            } else {
                //todo
            }
            //users invitation
        } 
      } else {
        ?>
        <div class= "quitter">
            <p>Vous êtes déjà dans le groupe qui se nomme : <?php echo  $_SESSION['name_group']; ?> </p> </br>
        <form action = "leaveGroup.php" name="post">    
        <button type="submit"  onclick="leaveGroup()"> Quitter <?php echo $_SESSION['name_group'];  ?></button>
        </form>
      </div>
      <div class="try">
        <form method="POST" action="">
        <h2>Rentrer un pseudo de user pour l'inviter : </h2>
        <input type="text" name="pseudoInvit"  placeholder="pseudo de l'utilisateur..." required="required" autocomplete="off">
      </br></br>
        <?php
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
           
        <div class="invit"><button type="submit" name="invit">Inviter dans <?php echo $_SESSION['name_group'];  ?></button></div>
        </form>   
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
        <h2>Liste des invitations en attentes : </h2>
        <div class = "listetaches">
<?php
         // afficher les demandes envoyé par le user, pour pouvoir les annuler
        $allInvit = $bdd->prepare('SELECT * FROM invit WHERE id_user = ? ');
        $allInvit->execute(array($_SESSION['id_user']));  
        $listid = array();       
        if ($allInvit->rowCount() > 0) { 
            $invits = $allInvit->fetchAll();          
            for($i =0; $i < count($invits); $i++){
                ?>
                    <div class="annulinvit">
                  <form method="POST" action="">
                <div class="stat"><?php
                $listid[$i] = $invits[$i]['id_invit'];
                echo "" . $invits[$i]['invited'] . "(". $invits[$i]['id_invit'].")" . " | STATUS : demande en cours... ";
                ?></div>
                <div class="stat"><button type="submit" name="<?php echo $invits[$i]['id_invit']?>">annuler</button></div></div>
                 
                 <?php 
                 }

                 foreach ($listid as $value) 
            { 
                if (isset($_POST["$value"])) 
                {

                    echo "test2";
                    $deleteInvit = $bdd->prepare('DELETE FROM invit WHERE id_invit = ? ');
                    $deleteInvit->execute(array($value));

                    echo"here";
                    header('Location: manageGroup.php');
                } 

            }?>
        </form>
        </div>
            </div><?php
      }
    }      
      ?> <br /><br />
    <form action="" method="POST">
    <div id="result">
        <?php
        ?>
    </div>
    </form>
</section>
</section>
        <?php
        ?>
  

</body>

</html>