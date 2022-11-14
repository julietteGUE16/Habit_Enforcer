<?php


class task
{
    //task permet de définir la couleur par rapport au type de task selectionné
    private type_task $task;
    //text qui défini la tâche
    private  string $name;
    //level de difficulté de la tâche
    private int $level;
    //si true alors c'est quotidien sinon si false c'est hebdomadaire (weekly)
    private bool $isDaily;

    //si c'est hebdomadaire il faut choisir le jour de la semaine qui va revenir
    private string $day;
    //id user qui à créé la tâche
    private int $idUser;
    
    //bool qui permet de valider ou non le task
    private bool $isValid;

    //id task
    private int $idTask;


    //TODO : récurrence de la task
    

    //TODO : id task ????
    public function __construct($id)
    {  
        $this->$idTask = $id;
      
    }

    public function getTask (): type_task{
        return $task;
    }

    public function getIdTask () : int{
        return $idTask;
    }

    public function getName (): string{
        return $name;
    }

    public function getLevel (): int{
        return $level;
    }

    public function getIsDaily (): bool{
        return $isDaily;
    }
    public function getDay (): string{
        return $day;
    }
    public function getIdUser (): int {
        return $idUser;
    }

    public function getIsValid () : bool {
        return $isValid;
    }

    public function getData (int $id){
        //check if id exist
        //if yes get all data by the id of the task:
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 

        $recupUser = $bdd->prepare('SELECT * FROM task WHERE id_users = ?');
        $recupUser->execute(array($id));

        //connexion line 41 voir info
    
        if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
            $fetch = $recupUser->fetch();
            $name = $fetch['nom'];
            $task = $fetch['style'];
            $level = $fetch['niveau'];
            $isDaily = $fetch['isdaily'];
            $day = $fetch['jour'];
            $idUser = $id;
            $isvalid = $fetch['isvalid'];
            $idTask = $fetch['id_task'];     
        } else {
            echo "error";
        }

    }
}
