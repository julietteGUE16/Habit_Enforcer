<?php


class Task
{
    //task permet de définir la couleur par rapport au type de task selectionné
    private type_task $category;
    //text qui défini la tâche
    private  string $name;
    //level de difficulté de la tâche
    private int $difficulty;
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
    //date de la dernière validité
    private date $validDate;

    
    public function __construct(int $id)
    {  
      
        $this->$idTask = $id;
        //echo "id = ".$this->$idTask. " ||" ;
      
    }

    public function getCategory (): type_task{
        return $category;
    }

    public function getIdTask () : int{
        return $idTask;
    }

    public function getName (): string{
        return $name;
    }

    public function getDifficulty (): int{
        return $difficulty;
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
    

    //todo : get list of task depend of id in entry

    //todo : set data base for task : set for isValid

    //todo delete task

    public function getValidDate () : date {
        return $validDate;
    }

    public function getData (int $id){
        //check if id exist
        //if yes get all data by the id of the task:
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 

        $recupUser = $bdd->prepare('SELECT * FROM tasks WHERE id_user = ?');
        $recupUser->execute(array($id));

        //connexion line 41 voir info
    
        if($recupUser->rowCount() > 0){ // on peut connecter l'utilisateur
            $fetch = $recupUser->fetch();
            $name = $fetch['name_task'];
            $task = $fetch['category'];
            $level = $fetch['difficulty'];
            $isDaily = $fetch['isdaily'];
            $day = $fetch['chosen_day'];
            $idUser = $id;
            $isvalid = $fetch['isvalid'];
            $idTask = $fetch['id_task'];   
            $validDate = $fetch['last_valid_date'];     
        } else {
            echo "error";
        }

    }
    
}
